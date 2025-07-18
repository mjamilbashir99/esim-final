<?php

namespace Modules\Hotels\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Template;
use Modules\Hotels\Models\UserModel;
use Modules\Hotels\Models\CountryCodeModel;


class AuthController extends BaseController
{
    protected $template;

    public function __construct()
    {
        $this->template = new Template();
    }

    public function index()
    {
        $data = [
            'title' => 'Hotel Room Discount | Home',
        ];
        return $this->template->render('Hotels/Views/index', $data);
    }

    public function register()
    {
        $countryCodeModel = new CountryCodeModel();
        $data = [
            'title' => 'Hotel Room Discount | Register',
            'country_codes' => $countryCodeModel->getCountryCodes(),
        ];

        return $this->template->render('Hotels/Views/register', $data);
    }

    private function sendOtpToUser($email, $userId)
    {
        // Generate OTP
        $otp = rand(100000, 999999);

        $userModel = new UserModel();
        $userModel->update($userId, [
            'otp' => $otp,
            'otp_created_at' => date('Y-m-d H:i:s')
        ]);

        $user = $userModel->find($userId);
        $name = $user['name'] ?? 'User';

        $templateModel = new \App\Models\EmailTemplateModel();
        $slug = 'OTP-template';
        $template = $templateModel->where('slug', $slug)->first();

        if (!$template) {
            return false;
        }

        $templateContent = $template['content'];

        $templateContent = str_replace('<?= esc($name) ?>', esc($name), $templateContent);
        $templateContent = str_replace('<?= esc($otp) ?>', $otp, $templateContent);

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject($template['subject']);
        $emailService->setMessage($templateContent);
        $emailService->setMailType('html');

        return $emailService->send();
    }


    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'            => 'required|min_length[3]',
            'email'           => 'required|valid_email|is_unique[users.email]',
            'phone'           => 'required|min_length[10]',
            'country_code'    => 'required',
            'password'        => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();

        $data = [
            'name'         => $this->request->getPost('name'),
            'email'        => $this->request->getPost('email'),
            'phone'        => $this->request->getPost('phone'),
            'country_code' => $this->request->getPost('country_code'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'otp'          => 0, // placeholder
            'is_verified'  => 0,
        ];

        $userModel->insert($data);
        $userId = $userModel->getInsertID();

        if ($this->sendOtpToUser($data['email'], $userId)) {
            // return redirect()->to('verify-otp?email=' . urlencode($data['email']));

            $redirectUrl = session()->get('redirect_url') ?? '/home';
            session()->remove('redirect_url');

            // After OTP verification redirect to $redirectUrl
            session()->set('post_verification_redirect', $redirectUrl);
            return redirect()->to('verify-otp?email=' . urlencode($data['email']));
        } else {
            return redirect()->back()->with('error', 'Failed to send verification email.');
        }
    }

    public function verifyOtpSubmit()
    {
        $email = $this->request->getPost('email');
        $otpArray = $this->request->getPost('otp');
        $otp = implode('', $otpArray);

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->to('register')->with('error', 'User not found.');
        }

        // Check if OTP is expired (60 seconds validity)
        $otpCreatedAt = strtotime($user['otp_created_at']);
        if (!$otpCreatedAt || (time() - $otpCreatedAt > 60)) {
            return redirect()->to('verify-otp?email=' . urlencode($email))
                ->with('error', 'OTP has expired. Please request a new one.');
        }

        // Verify OTP
        if ($user['otp'] === $otp) {
            $userModel->update($user['id'], [
                'otp' => null,
                'otp_created_at' => null,
                'is_verified' => 1
            ]);

            session()->set([
                'user_id'    => $user['id'],
                'user_name'  => $user['name'],
                'user_email' => $user['email'],
                'user_country_code' => $user['country_code'],
                'logged_in'  => true,
            ]);

            $this->sendWelcomeEmail($user['email'], $user['name']);

            // return redirect()->to('/home')->with('success', 'Email verified successfully.');
            $redirect = session()->get('post_verification_redirect') ?? '/home';
            session()->remove('post_verification_redirect');
            return redirect()->to($redirect);
            // return redirect()->to('/home')->with('success', 'Email verified successfully.');
        }

        return redirect()->to('verify-otp?email=' . urlencode($email))
            ->with('error', 'Invalid OTP. Please try again.');
    }




    public function verifyOtpView()
    {
        // return view('auth/verify_otp');
        return $this->template->render('Hotels/Views/verify_otp');
    }


    public function hotelBedsApi(): ResponseInterface
    {
        helper('generic_helper');

        $result = fetch_hotelbeds_hotels();

        if (isset($result['error'])) {
            return $this->response->setJSON(['error' => $result['error']]);
        }

        $hotelsData = [];

        if (isset($result['response']['hotels'])) {
            foreach ($result['response']['hotels'] as $hotel) {

                $hotelDetails = [
                    'code' => $hotel['code'],
                    'name' => $hotel['name']['content'] ?? '',
                    'description' => $hotel['description']['content'] ?? '',
                    'country_code' => $hotel['countryCode'] ?? '',
                    'state_code' => $hotel['stateCode'] ?? '',
                    'destination_code' => $hotel['destinationCode'] ?? '',
                    'coordinates' => [
                        'latitude' => $hotel['coordinates']['latitude'] ?? '',
                        'longitude' => $hotel['coordinates']['longitude'] ?? ''
                    ],
                    'categoryCode' =>  $hotel['categoryCode'] ?? '',
                    'address' => [
                        'content' => $hotel['address']['content'] ?? '',
                        'street' => $hotel['address']['street'] ?? '',
                        'number' => $hotel['address']['number'] ?? '',
                    ],
                    'postalCode' =>  $hotel['postalCode'] ?? '',
                    'city' => [
                        'content' => $hotel['city']['content'] ?? '',
                    ],
                    "S2C" => $hotel['S2C'] ?? '',

                ];


                $imagesData = [];
                if (isset($hotel['images'])) {
                    foreach ($hotel['images'] as $image) {
                        $imageDetails = [
                            'image_type_code' => $image['imageTypeCode'] ?? '',
                            'path' => $image['path'] ?? '',
                            'order' => $image['order'] ?? '',
                            'visual_order' => $image['visualOrder'] ?? '',
                        ];

                        if (isset($image['roomCode'])) {
                            $imageDetails['room_code'] = $image['roomCode'];
                            $imageDetails['room_type'] = $image['roomType'];
                            $imageDetails['characteristic_code'] = $image['characteristicCode'];
                        }

                        $imagesData[] = $imageDetails;
                    }
                }


                $roomsData = [];
                if (isset($hotel['rooms'])) {
                    foreach ($hotel['rooms'] as $room) {
                        $roomDetails = [
                            'room_code' => $room['roomCode'] ?? '',
                            'is_parent_room' => $room['isParentRoom'] ?? false,
                            'min_pax' => $room['minPax'] ?? 1,
                            'max_pax' => $room['maxPax'] ?? 1,
                            'max_adults' => $room['maxAdults'] ?? 1,
                            'max_children' => $room['maxChildren'] ?? 0,
                            'min_adults' => $room['minAdults'] ?? 1,
                            'room_type' => $room['roomType'] ?? '',
                            'characteristic_code' => $room['characteristicCode'] ?? ''
                        ];

                        $roomsData[] = $roomDetails;
                    }
                }

                $hotelDetails['rooms'] = $roomsData;

                $hotelDetails['images'] = $imagesData;

                $hotelsData[] = $hotelDetails;
            }
        }

        return $this->response->setJSON([
            'status_code' => $result['status_code'],
            'total_hotels' => $result['response']['total'],
            'hotels' => $hotelsData,
        ]);
    }




    public function searchNearbyHotels(): ResponseInterface
    {
        helper('generic_helper');
        $request = $this->request->getJSON(true);

        if (
            !isset($request['stay'], $request['occupancies'], $request['geolocation']) ||
            !isset($request['stay']['checkIn'], $request['stay']['checkOut']) ||
            !isset($request['geolocation']['latitude'], $request['geolocation']['longitude'])
        ) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request body.']);
        }

        $checkIn = $request['stay']['checkIn'];
        $checkOut = $request['stay']['checkOut'];
        $occupancies = $request['occupancies'];
        $lat = $request['geolocation']['latitude'];
        $lng = $request['geolocation']['longitude'];
        $radius = $request['geolocation']['radius'] ?? 20;
        $unit = $request['geolocation']['unit'] ?? 'km';

        $mockResponse = [
            'search_summary' => [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'guests' => $occupancies,
                'location' => [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'radius' => $radius,
                    'unit' => $unit
                ]
            ],
            'hotels_found' => [
                [
                    'hotel_code' => '000001',
                    'name' => 'Mock Hotel Palma',
                    'distance' => 1.2,
                    'category' => '4*',
                    'latitude' => 39.57125,
                    'longitude' => 2.64660,
                ],
                [
                    'hotel_code' => '000002',
                    'name' => 'Sea View Hotel',
                    'distance' => 3.5,
                    'category' => '3*',
                    'latitude' => 39.56800,
                    'longitude' => 2.64500,
                ]
            ]
        ];

        return $this->response->setJSON($mockResponse);
    }




    public function login()
    {
        // return view('auth/login');
        $data = [
            'title' => 'Hotel Room Discount | Login',
        ];
        return $this->template->render('Hotels/Views/login', $data);
    }


    public function loginSubmit()
    {
        $session = session();
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {

            if ($user['is_verified'] == 0) {
                $this->sendOtpToUser($email, $user['id']);
                return redirect()->to('/verify-otp?email=' . urlencode($email));
            }

            $session->set([
                'user_id'    => $user['id'],
                'user_name'  => $user['name'],
                'user_email' => $user['email'],
                'user_phone' => $user['phone'],
                'user_country_code' => $user['country_code'],
                'logged_in'  => true,
            ]);

            $redirectUrl = session()->get('redirect_url') ?? 'hotels/home';
            session()->remove('redirect_url');

            return redirect()->to($redirectUrl);
            // return redirect()->to('/home');
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }
    }




    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }

    private function checkLogin()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }
    }

    public function resendOtp()
    {
        $email = $this->request->getGet('email');
        if (!$email) {
            return redirect()->to('register')->with('error', 'Invalid request.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->to('register')->with('error', 'User not found.');
        }

        $success = $this->sendOtpToUser($email, $user['id']);

        if ($success) {
            return redirect()->to('verify-otp?email=' . urlencode($email))
                ->with('success', 'OTP has been resent to your email.');
        } else {
            return redirect()->to('verify-otp?email=' . urlencode($email))
                ->with('error', 'Failed to resend OTP. Please try again.');
        }
    }


    private function sendWelcomeEmail($email, $name)
    {
        $templateModel = new \App\Models\EmailTemplateModel();
        $slug = 'Welcome-User';
        $template = $templateModel->where('slug', $slug)->first();

        if (!$template) {
            return false;
        }


        $templateContent = $template['content'];


        $templateContent = str_replace('<?= esc($name) ?>', esc($name), $templateContent);
        $templateContent = str_replace('<?= base_url("login") ?>', base_url('login'), $templateContent);


        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject($template['subject']);
        $emailService->setMessage($templateContent);
        $emailService->setMailType('html');
        return $emailService->send();
    }

    public function isLoggedIn()
    {
        $session = session();
        return $this->response->setJSON([
            'logged_in' => $session->get('logged_in') == true
        ]);
    }


    public function setRedirectUrl()
    {
        $url = $this->request->getPost('url');
        if ($url) {
            session()->set('redirect_url', $url);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }
}
