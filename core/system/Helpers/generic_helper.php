<?php
use Modules\Hotels\Models\MarkupModel;


if (!function_exists('fetch_hotelbeds_hotels')) {
    function fetch_hotelbeds_hotels($hotelCodes = [])
    {
        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $timestamp = time();
        $signature = hash('sha256', $apiKey . $secret . $timestamp);

        $version = "1.0";
        $baseUrl = "https://api.test.hotelbeds.com/hotel-content-api/$version/hotels";

        $queryString = '';
        if (!empty($hotelCodes)) {
            $codesParam = implode(',', $hotelCodes);
            $queryString = '?codes=' . urlencode($codesParam);
        }

        $url = $baseUrl . $queryString;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Api-key: $apiKey",
                "X-Signature: $signature"
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            return ['error' => $error];
        }

        return ['status_code' => $httpCode, 'response' => json_decode($response, true)];
    }



    if (!function_exists('calculateProfitPrice')) {
        function calculateProfitPrice($netPrice)
        {
            $markupModel = new MarkupModel();
            $markup = $markupModel->first(); 
            // var_dump($markup);die();
            $markupPercent = isset($markup['b2c_markup']) ? (float)$markup['b2c_markup'] : 0;
            // var_dump($markupPercent);die();

            $convertedProfit = $markupPercent/100;
            $convertedProfitAmount = $convertedProfit + 1;
            //  var_dump($convertedProfitAmount);die();
            $profitMultiplier = $convertedProfitAmount;
            // var_dump($convertedProfitAmount);die();
            // $profitMultiplier = $markupPercent;
            return round($netPrice * $profitMultiplier, 2);
        }
    }


    if (!function_exists('getAvailableImageUrl')) {
        function getAvailableImageUrl($path) {
            $baseUrls = [
                'https://photos.hotelbeds.com/giata/xxl/',
                'https://photos.hotelbeds.com/giata/xl/',
                'https://photos.hotelbeds.com/giata/bigger/',
                'https://photos.hotelbeds.com/giata/'
            ];

            foreach ($baseUrls as $base) {
                $url = $base . $path;
                $headers = @get_headers($url, 1);
                if ($headers && strpos($headers[0], '200') !== false) {
                    return $url;
                }
            }

            return null;
        }
    }







   
}