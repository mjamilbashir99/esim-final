<?php

namespace Modules\Hotels\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Template;
use Modules\Hotels\Models\BookingModel;
use Modules\Hotels\Models\HotelModel;
use Modules\Hotels\Models\MarkupModel;
use Modules\Hotels\Models\CountryCodeModel;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class HotelController extends BaseController
{
    protected $template;
    protected $apiUrl;
    protected $contentUrl;
    protected $hotelUrl;

    public function __construct()
    {
        $this->template = new Template();
        $this->apiUrl = getenv('HOTELBEDS_API_BASE');
        $this->contentUrl = getenv('HOTELBEDS_CONTENT_API_URL');
        $this->hotelUrl = getenv('HOTELBEDS_HOTEL_API_URL');
    }

    public function getCitySuggestions(): ResponseInterface
    {
        $term = $this->request->getGet('term');

        if (!$term || strlen($term) < 2) {
            return $this->response->setJSON([]);
        }

        $db = \Config\Database::connect();
        $hotelModel = new HotelModel();
        $suggestions = [];
        $uniqueKeys = [];

        $destBuilder = $db->table('destinations');
        $destBuilder->select('DISTINCT destinations.name, destinations.country_name', false)
            ->groupStart()
            ->like('destinations.name', $term)
            ->orLike('destinations.country_name', $term)
            ->groupEnd()
            ->orderBy('destinations.country_name')
            ->limit(20);
        $destinations = $destBuilder->get()->getResultArray();

        foreach ($destinations as $destination) {
            $key = strtolower(preg_replace('/[^a-z0-9]/i', '', $destination['name']));
            if (!isset($uniqueKeys[$key])) {
                $uniqueKeys[$key] = true;
                $suggestions[] = [
                    'type' => 'destination',
                    'city_name' => $destination['name'],
                    'state_name' => '',
                    'country_name' => $destination['country_name'],
                ];
            }
        }

        $builder = $db->table('hotels');
        $builder->select('DISTINCT hotels.city', false)
            ->like('hotels.city', $term)
            ->limit(20);
        $cities = $builder->get()->getResultArray();

        foreach ($cities as $city) {
            $key = strtolower(preg_replace('/[^a-z0-9]/i', '', $city['city']));
            if (!isset($uniqueKeys[$key])) {
                $uniqueKeys[$key] = true;
                $suggestions[] = [
                    'type' => 'city',
                    'city_name' => $city['city'],
                    'state_name' => '',
                    'country_name' => '',
                ];
            }
        }

        $hotels = $hotelModel->like('name', $term)
            ->limit(20)
            ->findAll();

        foreach ($hotels as $hotel) {
            $key = strtolower(preg_replace('/[^a-z0-9]/i', '', $hotel['name']));
            if (!isset($uniqueKeys[$key])) {
                $uniqueKeys[$key] = true;
                $suggestions[] = [
                    'type' => 'hotel',
                    'city_name' => $hotel['name'],
                    'state_name' => '',
                    'country_name' => 'Hotel',
                ];
            }
        }

        return $this->response->setJSON($suggestions);
    }

    // Optimised Searching
    public function searchHotels()
    {
        helper('generic_helper');
        $session = session();

        $destination   = trim($this->request->getGet('destination') ?? '');
        $checkInRaw    = $this->request->getGet('checkin');
        $checkOutRaw   = $this->request->getGet('checkout');
        $rooms         = (int) $this->request->getGet('rooms');
        $passenger     = $this->request->getGet('passenger');
        $adults        = (int) $this->request->getGet('adults');
        $childrenAges  = isset($_GET['children_ages']) ? array_filter(explode(",", $_GET['children_ages']), fn($age) => $age !== '') : [];
        $children      = count($childrenAges);

        $session->set([
            'adults_store_in_session'     => $adults,
            'destination_store_in_session' => $destination,
            'checkin_raw_store_in_session' => $checkInRaw,
            'checkout_raw_store_in_session' => $checkOutRaw,
            'rooms'                       => $rooms,
            'passenger'                   => $passenger,
            'adults'                      => $adults,
            'children'                    => $children,
        ]);

        $checkIn  = date('Y-m-d', strtotime($checkInRaw));
        $checkOut = date('Y-m-d', strtotime($checkOutRaw));

        $HotelModel = new HotelModel();
        $db = \Config\Database::connect();
        $payload = null;
        $paxes = $this->generatePaxes($adults, $childrenAges);

        // by city
        if ($city = $HotelModel->select('latitude, longitude')->where('city', $destination)->first()) {
            $payload = $this->preparePayload($checkIn, $checkOut, $rooms, $adults, $children, $paxes, [
                'type' => 'geolocation',
                'latitude' => (float) $city['latitude'],
                'longitude' => (float) $city['longitude'],
                'radius' => 50,
                'unit' => 'km'
            ]);
        }

        // destination name
        if (!$payload) {
            $destinationRow = $db->table('destinations')->select('code')->where('name', $destination)->get()->getRowArray();

            if ($destinationRow) {
                $destinationCode = $destinationRow['code'];
                $hotel = $HotelModel->select('latitude, longitude')->where('destination_code', $destinationCode)->first();

                if ($hotel) {
                    $payload = $this->preparePayload($checkIn, $checkOut, $rooms, $adults, $children, $paxes, [
                        'type' => 'geolocation',
                        'latitude' => (float) $hotel['latitude'],
                        'longitude' => (float) $hotel['longitude'],
                        'radius' => 50,
                        'unit' => 'km'
                    ]);
                }
            }
        }

        // by hotel name
        if (!$payload) {
            $hotel = $HotelModel->select('name, city')->where('name', $destination)->first();

            if (!$hotel) {
                return $this->response->setJSON([
                    'error' => 'No results found. Try searching with Hotel name, City name, or Destination.'
                ]);
            }

            $hotelCodes = $HotelModel->where('city', $hotel['city'])->limit(100)->findColumn('hotel_code');

            $payload = $this->preparePayload($checkIn, $checkOut, $rooms, $adults, $children, $paxes, [
                'type' => 'hotels',
                'hotelCodes' => $hotelCodes
            ]);
        }


        $client = \Config\Services::curlrequest();
        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $signature = hash('sha256', $apiKey . $secret . time());

        try {
            $response = $client->post($this->hotelUrl . '/hotels', [
                'headers' => [
                    'Api-Key' => $apiKey,
                    'X-Signature' => $signature,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload)
            ]);
            // var_dump($response);die();

            $responseBody = json_decode($response->getBody(), true);
            $hotels = $responseBody['hotels'] ?? [];
            $maxPrice = 0;

            foreach ($hotels as $hotel) {
                $rate = $hotel['rooms'][0]['rates'][0]['net'] ?? 0;
                $sellingPrice = calculateProfitPrice($rate);
                $maxPrice = max($maxPrice, $sellingPrice);
            }

            $session->set([
                'hotel_search_results' => ['hotels' => $hotels],
                'maxPrice' => $maxPrice
            ]);

            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            log_message('error', 'Hotel Search Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage() ?: 'Something went wrong'
            ]);
        }
    }

    private function preparePayload(
        string $checkIn,
        string $checkOut,
        int $rooms,
        int $adults,
        int $children,
        array $paxes,
        array $location
    ): array {
        $payload = [
            "stay" => [
                "checkIn" => $checkIn,
                "checkOut" => $checkOut
            ],
            "occupancies" => [[
                "rooms" => $rooms,
                "adults" => $adults,
                "children" => $children,
                "paxes" => $paxes
            ]]
        ];

        // var_dump($location);die();
        if (isset($location['type']) && $location['type'] === 'geolocation') {
            $payload['geolocation'] = [
                "latitude" => $location['latitude'],
                "longitude" => $location['longitude'],
                "radius" => $location['radius'],
                "unit" => $location['unit']
            ];
        } elseif (isset($location['type']) && $location['type'] === 'hotels') {
            $payload['hotels'] = [
                "hotel" => $location['hotelCodes']
            ];
        }

        return $payload;
    }

    private function generatePaxes(int $adults, array $childrenAges = []): array
    {
        $paxes = [];

        // Add adults
        for ($i = 0; $i < $adults; $i++) {
            $paxes[] = [
                "roomId" => 1,
                "type" => "AD",
                "age" => 30
            ];
        }

        // Add children
        foreach ($childrenAges as $index => $age) {
            $paxes[] = [
                "roomId" => 1,
                "type" => "CH",
                "age" => (int) $age
            ];
        }

        return $paxes;
    }

    // optimised code with pagination
    public function searchResult()
    {
        $title = 'Hotel Room Discount | Search Result';
        $session = session();
        $results = $session->get('hotel_search_results');
        $adults = $session->get('adults_store_in_session');
        $destination = $session->get('destination_store_in_session');
        $checkin = $session->get('checkin_raw_store_in_session');
        $checkout = $session->get('checkout_raw_store_in_session');
        $rooms = $session->get('rooms');
        $passenger = $session->get('passenger');
        $children = $session->get('children');
        $childrenAges = $session->get('children_ages') ?? [];


        $hotels = isset($results['hotels']) ? $results['hotels'] : [];
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $total = count($hotels['hotels'] ?? []);


        $matchedHotels = [];
        $hotelModel = new HotelModel();

        if (!empty($hotels['hotels']) && is_array($hotels['hotels'])) {
            $hotelCodes = array_column($hotels['hotels'], 'code');

            $localHotels = $hotelModel
                ->select('hotel_code, amenities, chain_code, thumbnail_url')
                ->whereIn('hotel_code', $hotelCodes)
                ->findAll();

            $indexedHotels = [];
            foreach ($localHotels as $localHotel) {
                $indexedHotels[$localHotel['hotel_code']] = $localHotel;
            }

            foreach ($hotels['hotels'] as &$hotel) {
                $hotelCode = $hotel['code'] ?? null;
                if ($hotelCode && isset($indexedHotels[$hotelCode])) {
                    $hotel['hotels_local_accumodation'] = $indexedHotels[$hotelCode];
                }
            }
        }

        $markupModel = new MarkupModel();
        $markup = $markupModel->where('module_id', 'hotel')->where('status', 'enabled')->first();

        $markupPercent = isset($markup['b2c_markup']) ? (float)$markup['b2c_markup'] : 0;
        // var_dump($markupPercent);
        // die();

        return $this->template->render('Hotels/Views/search_result', [
            'hotels' => $hotels,
            'currentPage' => $currentPage,
            'destination' => $destination,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'rooms' => $rooms,
            'passenger' => $passenger,
            'adults' => $adults,
            'children' => $children,
            'children_ages' => $childrenAges,
            'markupPercent' => $markupPercent,
            'title' => $title
        ]);
    }


    public function fetchHotelData()
    {
        $client = \Config\Services::curlrequest();

        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $timestamp = time();
        $signature = hash('sha256', $apiKey . $secret . $timestamp);

        $url = $this->contentUrl . '/hotels/437/details';


        $headers = [
            'Accept'       => 'application/json',
            'Api-Key'      => $apiKey,
            'X-Signature'  => $signature
        ];

        try {
            $response = $client->get($url, ['headers' => $headers]);
            $body = $response->getBody();

            $filePath = WRITEPATH . 'cache/hotel_681970.json';
            file_put_contents($filePath, $body);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data fetched and saved.',
                'file' => $filePath
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function hotelDetails($code)
    {
        $title = 'Hotel Room Discount | Hotel Details';
        $session = session();

        $searchResults = $session->get('hotel_search_results');
        $getSearchedAdults = $session->get('adults_store_in_session');
        $cacheFile = WRITEPATH . "cache/hotel_{$code}_details.json";

        $hotelRates = null;

        if (isset($searchResults['hotels']['hotels'])) {
            foreach ($searchResults['hotels']['hotels'] as $hotel) {
                if ((int)$hotel['code'] === (int)$code) {
                    $hotelRates = $hotel;
                    break;
                }
            }
        }

        if (file_exists($cacheFile)) {
            $responseBody = json_decode(file_get_contents($cacheFile), true);
            $session->set('hotel_details', $responseBody);
        } else {
            $apiKey = getenv('HOTELBEDS_API_KEY');
            $secret = getenv('HOTELBEDS_SECRET');
            $timestamp = time();
            $signature = hash('sha256', $apiKey . $secret . $timestamp);

            $url = $this->contentUrl . "/hotels/{$code}/details";


            $client = \Config\Services::curlrequest();

            try {
                $response = $client->get($url, [
                    'headers' => [
                        'Api-Key' => $apiKey,
                        'X-Signature' => $signature,
                        'Accept' => 'application/json',
                    ]
                ]);

                $responseBody = json_decode($response->getBody(), true);
                $session->set('hotel_details', $responseBody);
                file_put_contents($cacheFile, json_encode($responseBody));
            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => $e->getMessage()]);
            }
        }

        $markupModel = new MarkupModel();
        $markup = $markupModel->first();

        $markupPercent = isset($markup['b2c_markup']) ? (float)$markup['b2c_markup'] : 0;

        $convertedProfit = $markupPercent / 100;
        $convertedProfitAmount = $convertedProfit + 1;

        return $this->template->render('Hotels/Views/hotel_details', [
            'hotelDetails' => $responseBody,
            'rateData' => $hotelRates,
            'getSearchedAdults' => $getSearchedAdults,
            'convertedProfitAmount' => $convertedProfitAmount,
            'title' => $title
        ]);
    }


    public function checkRate()
    {
        // die("hello");
        $rateKey = $this->request->getPost('rateKey');

        if (!$rateKey) {
            return $this->response->setJSON(['error' => 'RateKey is required']);
        }

        $hash = md5($rateKey);
        $cacheFile = WRITEPATH . "logs/check_rate_cache_{$hash}.json";

        if (file_exists($cacheFile)) {
            $cached = file_get_contents($cacheFile);
            return $this->response->setJSON(json_decode($cached, true));
        }

        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $timestamp = time();
        $signature = hash('sha256', $apiKey . $secret . $timestamp);

        $url = $this->hotelUrl . '/checkrates';
        $client = \Config\Services::curlrequest();

        $payload = [
            'rooms' => [
                ['rateKey' => $rateKey]
            ]
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Api-Key' => $apiKey,
                    'X-Signature' => $signature,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
                'http_errors' => false
            ]);

            $status = $response->getStatusCode();
            $body = (string) $response->getBody();
            $decoded = json_decode($body, true);

            $timestampedFile = WRITEPATH . 'logs/check_rate_' . date('Ymd_His') . '.json';
            file_put_contents($timestampedFile, json_encode([
                'status' => $status,
                'response' => $decoded ?? $body,
            ], JSON_PRETTY_PRINT));

            if ($status !== 200 || isset($decoded['error'])) {
                $errorMessage = $decoded['error'] ?? "HTTP Error: $status";
                return $this->response->setJSON([
                    'error' => $errorMessage,
                    'status' => $status
                ]);
            }

            file_put_contents($cacheFile, json_encode($decoded, JSON_PRETTY_PRINT));
            return $this->response->setJSON($decoded);
        } catch (\Exception $e) {
            $errorLog = [
                'error' => $e->getMessage(),
                'rateKey' => $rateKey,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            $errorFile = WRITEPATH . 'logs/check_rate_error_' . date('Ymd_His') . '.json';
            file_put_contents($errorFile, json_encode($errorLog, JSON_PRETTY_PRINT));

            return $this->response->setJSON(['error' => 'Unexpected server error']);
        }
    }

    public function bookRoom()
    {
        // echo "hello";die();
        helper('text');
        $session = session();
        $email = session()->get('user_email');
        $price = session()->get('price');

        $rateKey = $this->request->getPost('rateKey');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $paymentMethodId = $this->request->getPost('payment_method_id');
        $hotelPrice = $this->request->getPost('hotel_price');
        $userId = session()->get('user_id');

        if (!$rateKey || !$paymentMethodId) {
            return $this->response->setJSON(['error' => 'Required fields missing']);
        }

        $amountInCents = $hotelPrice * 100;

        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));

        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'capture_method' => 'manual'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Card Error: ' . $e->getMessage()]);
        }

        if ($paymentIntent->status !== 'requires_capture') {
            return $this->response->setJSON(['error' => 'Card authorization failed']);
        }

        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $timestamp = time();
        $signature = hash('sha256', $apiKey . $secret . $timestamp);
        $url = $this->hotelUrl . '/bookings';
        $client = \Config\Services::curlrequest();

        $payload = [
            'holder' => [
                'name' => $name,
                'surname' => $surname
            ],
            'rooms' => [
                ['rateKey' => $rateKey]
            ],
            'clientReference' => random_string('alnum', 20),
            'remark' => 'Booking via site'
        ];

        $response = $client->post($url, [
            'headers' => [
                'Api-Key' => $apiKey,
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($payload),
            'http_errors' => false
        ]);

        $status = $response->getStatusCode();
        $body = json_decode($response->getBody(), true);

        if ($status === 200 && isset($body['booking'])) {
            \Stripe\PaymentIntent::retrieve($paymentIntent->id)->capture();


            $bookingModel = new BookingModel();


            $bookingData = [
                'user_id' => $userId,
                'hotel_id' => $body['booking']['hotel']['code'],
                'room_id' => $body['booking']['hotel']['rooms'][0]['id'],
                'booking_reference' => $body['booking']['reference'],
                'check_in' => $body['booking']['hotel']['checkIn'],
                'check_out' => $body['booking']['hotel']['checkOut'],
                'guests' => count($body['booking']['hotel']['rooms'][0]['paxes']),
                'actual_price' => $body['booking']['totalNet'],
                'total_price' => $hotelPrice,
                'currency' => $body['booking']['currency'],
                'status' => 'confirmed'
            ];

            $bookingDataEmail = [
                'hotel_name' => $session->get('checkout_hotel_name'),
                'price' => $session->get('checkout_price'),
                'currency' => $session->get('checkout_currency'),
                'checkin' => $session->get('checkout_checkin'),
                'checkout' => $session->get('checkout_checkout'),
                'address' => $session->get('checkout_address'),
                'checkin_hour' => $session->get('checkin_hour'),
                'checkout_hour' => $session->get('checkout_hour'),
            ];

            $bookingModel->insert($bookingData);

            $body['booking']['pendingAmount'] = 0;

            $this->sendBookingConfirmationEmail($email, $name, $bookingDataEmail);

            $html = $this->template->render('Hotels/Views/thankyou', ['booking' => $body['booking'], 'price' => $price]);

            return $this->response->setJSON([
                'html' => $html
            ]);
        } else {
            \Stripe\PaymentIntent::retrieve($paymentIntent->id)->cancel();
            return $this->response->setJSON(['error' => 'Booking failed. Card not charged.']);
        }
    }

    public function checkout()
    {
        $title = 'Hotel Room Discount | Checkout';
        $countryCodeModel = new countryCodeModel();
        $country_codes = $countryCodeModel->getCountryCodes();
        $session = session();

        if (!$session->get('logged_in')) {
            $session->set('redirect_url', current_url() . '?' . $_SERVER['QUERY_STRING']);
            return redirect()->to('hotels/login')->with('error', 'Please log in to continue to checkout.');
        }

        $searchResults = $session->get('hotel_search_results');
        $hotelDetails = $session->get('hotel_details');

        $checkInHour = '';
        $checkOutHour = '';

        if (!empty($hotelDetails['hotel']['facilities'])) {
            foreach ($hotelDetails['hotel']['facilities'] as $facility) {
                if (!empty($facility['description']['content'])) {
                    if ($facility['description']['content'] === 'Check-in hour' && !empty($facility['timeFrom'])) {
                        $checkInHour = date("g:i A", strtotime($facility['timeFrom']));
                    }
                    if ($facility['description']['content'] === 'Check-out hour' && !empty($facility['timeTo'])) {
                        $checkOutHour = date("g:i A", strtotime($facility['timeTo']));
                    }
                }
            }
        }

        $imageUrl = '';
        if (!empty($hotelDetails['hotel']['images'][0]['path'])) {
            $imageUrl = $hotelDetails['hotel']['images'][0]['path'];
        }

        $rateKey = urldecode($this->request->getGet('rateKey'));
        $hotelName = urldecode($this->request->getGet('hotelName'));
        $price = $this->request->getGet('price');
        $session->set(['price' => $price,]);
        $currency = $this->request->getGet('currency');
        $checkin = $session->get('checkin_raw_store_in_session');
        $checkout = $session->get('checkout_raw_store_in_session');

        $address = '';
        if (!empty($hotelDetails['hotel']['address']['content'])) {
            $address = $hotelDetails['hotel']['address']['content'];
        }


        $session->set([
            'checkout_hotel_name' => $hotelName,
            'checkout_price' => $price,
            'checkout_currency' => $currency,
            'checkout_checkin' => $checkin,
            'checkout_checkout' => $checkout,
            'checkout_address' => $address,
            'checkin_hour' => $checkInHour,
            'checkout_hour' => $checkOutHour
        ]);



        if (!$rateKey) {
            return redirect()->to('/')->with('error', 'Missing rate key.');
        }

        return $this->template->render('Hotels/Views/checkout_form', [
            'rateKey' => $rateKey,
            'hotelName' => $hotelName,
            'price' => $price,
            'currency' => $currency,
            'imageUrl' => $imageUrl,
            'address' => $address,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'checkInHour' => $checkInHour,
            'checkOutHour' => $checkOutHour,
            'title' => $title,
            'country_codes' => $country_codes
        ]);
    }



    private function sendBookingConfirmationEmail($email, $name, $bookingData)
    {
        $templateContent = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Booking Confirmation</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f6f9fc;
                        margin: 0;
                        padding: 20px;
                    }
                    .email-container {
                        background-color: #ffffff;
                        max-width: 600px;
                        margin: auto;
                        padding: 30px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
                    }
                    .header {
                        text-align: center;
                        padding-bottom: 20px;
                    }
                    .header h2 {
                        margin: 0;
                        color: #333333;
                    }
                    .content {
                        font-size: 16px;
                        color: #555555;
                        line-height: 1.6;
                    }
                    .content p {
                        margin: 10px 0;
                    }
                    .booking-details {
                        background: #f2f2f2;
                        padding: 15px;
                        border-radius: 5px;
                        margin-top: 15px;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 13px;
                        color: #999999;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="header">
                        <h2>Booking Confirmed</h2>
                    </div>
                    <div class="content">
                        <p>Hi ' . htmlspecialchars($name) . ',</p>
                        <p>Thank you for booking with us! Your booking has been successfully confirmed.</p>
                        <div class="booking-details">
                            <p><strong>Hotel Name:</strong> ' . htmlspecialchars($bookingData['hotel_name']) . '</p>
                            <p><strong>Check-in:</strong> ' . htmlspecialchars($bookingData['checkin']) . ' ' . htmlspecialchars($bookingData['checkin_hour']) . '</p>
                            <p><strong>Check-out:</strong> ' . htmlspecialchars($bookingData['checkout']) . ' ' . htmlspecialchars($bookingData['checkout_hour']) . '</p>
                            <p><strong>Address:</strong> ' . htmlspecialchars($bookingData['address']) . '</p>
                            <p><strong>Total Price:</strong> ' . htmlspecialchars($bookingData['price']) . ' ' . htmlspecialchars($bookingData['currency']) . '</p>
                        </div>
                        <p>If you have any questions or need to make changes to your booking, feel free to contact our support team.</p>
                        <p>Best regards,<br>The Hotel Bed Discount Team</p>
                    </div>
                    <div class="footer">
                        &copy; ' . date("Y") . ' Hotel Bed Discount. All rights reserved.
                    </div>
                </div>
            </body>
            </html>';

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject("Your Booking Confirmation");
        $emailService->setMessage($templateContent);
        $emailService->setMailType('html');
        return $emailService->send();
    }


    public function bookingList()
    {
        $model = new BookingModel();

        $data['bookings'] = $model->orderBy('id', 'desc')->findAll();

        $hotelModel = new HotelModel();
        $hotels = $hotelModel->findAll();
        $hotelNames = [];
        foreach ($hotels as $hotel) {
            $hotelNames[$hotel['id']] = $hotel['name'];
        }

        $data['hotelNames'] = $hotelNames;

        return $this->template->render('bookings/list', $data);
    }
}
