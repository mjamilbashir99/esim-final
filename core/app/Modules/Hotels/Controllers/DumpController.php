<?php

namespace App\Controllers\Hotels;

use App\Controllers\BaseController;
use App\Libraries\Template;
use App\Models\HotelModel;
use App\Models\HotelSyncProgressModel;
use App\Models\DestinationModel;
use App\Models\CountryModel;

class DumpController extends BaseController
{
    protected $template;
    protected $contentUrl;

    public function __construct()
    {
        $this->template = new Template();
        $this->contentUrl = getenv('HOTELBEDS_CONTENT_API_URL');
    }



    // Old working code 
    // public function getHotelsDump()
    // {
    //     $apiKey = getenv('HOTELBEDS_API_KEY');
    //     $secret = getenv('HOTELBEDS_SECRET');
    //     $hotelModel = new HotelModel();
    //     $progressModel = new HotelSyncProgressModel();

    //     $progressRow = $progressModel->first();
    //     $from = $progressRow ? $progressRow['last_to'] + 1 : 1;
    //     $to = $from + 99;

    //     while (true) {
    //         echo "<h3>Fetching hotels from $from to $to</h3>";

    //         $signature = hash("sha256", $apiKey . $secret . time());
    //         $headers = [
    //             "Api-Key: $apiKey",
    //             "X-Signature: $signature"
    //         ];
    //         $endpoint = $this->contentUrl . "/hotels?fields=all&language=ENG&from=$from&to=$to";

    //         try {
    //             $response = $this->fetchData($endpoint, $headers);
    //             $data = json_decode($response, true);
    //         } catch (\Exception $e) {
    //             echo "API Error: " . $e->getMessage();
    //             break;
    //         }

    //         if (empty($data['hotels'])) {
    //             echo "No more hotel data found from $from to $to.";
    //             break;
    //         }

    //         $insertCount = 0;
    //         $updateCount = 0;
    //         $failedInserts = [];

    //         foreach ($data['hotels'] as $hotel) {
    //             try {
    //                 if (empty($hotel['code']) || empty($hotel['name']['content'])) {
    //                     $failedInserts[] = "Missing hotel fields. Code: " . ($hotel['code'] ?? 'N/A');
    //                     continue;
    //                 }

    //                 $hotelCode = $hotel['code'];
    //                 $singleHotelEndpoint = $this->contentUrl . "/hotels/{$hotelCode}/details";
    //                 $singleHotel = $this->fetchData($singleHotelEndpoint, $headers);
    //                 $singleHotelData = json_decode($singleHotel, true);
    //                 $hotelDetail = $singleHotelData['hotel'] ?? [];

    //                 $allowedAmenities = array_map(fn($a) => mb_strtolower(trim($a)), $this->getAllowedAmenities());
    //                 $amenities = [];

    //                 foreach ($hotelDetail['facilities'] ?? [] as $facility) {
    //                     $desc = $facility['description']['content'] ?? null;
    //                     if ($desc && in_array(mb_strtolower(trim($desc)), $allowedAmenities)) {
    //                         $amenities[] = $desc;
    //                     }
    //                 }

    //                 $phonesJson = json_encode($hotelDetail['phones'] ?? []);
    //                 $boardCodes = isset($hotel['boardCodes']) ? implode(',', $hotel['boardCodes']) : null;
    //                 $segmentCodes = isset($hotel['segmentCodes']) ? json_encode($hotel['segmentCodes']) : null;

    //                 $hotelData = [
    //                     'hotel_code' => $hotel['code'],
    //                     'name' => $hotel['name']['content'] ?? null,
    //                     'country_code' => $hotel['countryCode'] ?? null,
    //                     'destination_code' => $hotel['destinationCode'] ?? null,
    //                     'category' => $hotel['categoryCode'] ?? null,
    //                     'latitude' => $hotel['coordinates']['latitude'] ?? null,
    //                     'longitude' => $hotel['coordinates']['longitude'] ?? null,
    //                     'address' => $hotel['address']['content'] ?? null,
    //                     'description' => $hotel['description']['content'] ?? null,
    //                     'rating' => $hotel['categoryCode'] ?? null,
    //                     'thumbnail_url' => $hotel['images'][0]['path'] ?? null,
    //                     'created_at' => date('Y-m-d H:i:s'),
    //                     'state_code' => $hotel['stateCode'] ?? null,
    //                     'zone_code' => $hotel['zoneCode'] ?? null,
    //                     'category_code' => $hotel['categoryCode'] ?? null,
    //                     'category_group_code' => $hotel['categoryGroupCode'] ?? null,
    //                     'chain_code' => $hotel['chainCode'] ?? null,
    //                     'accommodation_type_code' => $hotel['accommodationTypeCode'] ?? null,
    //                     'board_codes' => $boardCodes,
    //                     'segment_codes' => $segmentCodes,
    //                     'hotel_address' => $hotel['address']['content'] ?? null,
    //                     'postal_code' => $hotel['postalCode'] ?? null,
    //                     'city' => $hotel['city']['content'] ?? null,
    //                     'email' => $hotelDetail['email'] ?? null,
    //                     'license' => $hotelDetail['license'] ?? null,
    //                     'giata_code' => $hotel['giataCode'] ?? null,
    //                     'phones' => $phonesJson,
    //                     'thumbnail' => $hotel['images'][0]['path'] ?? null,
    //                     'amenities' => json_encode(array_values(array_unique($amenities))),
    //                 ];

    //                 $existing = $hotelModel->where('hotel_code', $hotelCode)->first();

    //                 if (!$existing) {
    //                     $hotelModel->insert($hotelData);
    //                     $insertCount++;
    //                 } else {
    //                     $fieldsToUpdate = [];

    //                     foreach ($hotelData as $key => $value) {
    //                         if (!array_key_exists($key, $existing)) continue;

    //                         $existingValue = is_null($existing[$key]) ? '' : trim($existing[$key]);
    //                         $newValue = is_null($value) ? '' : trim($value);

    //                         if ($existingValue !== $newValue) {
    //                             $fieldsToUpdate[$key] = $value;
    //                         }
    //                     }

    //                     if (!empty($fieldsToUpdate)) {
    //                         $hotelModel->update($existing['id'], $fieldsToUpdate);
    //                         $updateCount++;
    //                     }
    //                 }
    //             } catch (\Exception $e) {
    //                 $failedInserts[] = "Hotel Code {$hotel['code']}: " . $e->getMessage();
    //             }
    //         }

    //         echo "<strong>Inserted:</strong> $insertCount, <strong>Updated:</strong> $updateCount<br>";

    //         if (!empty($failedInserts)) {
    //             echo "<strong>Errors:</strong><br>";
    //             foreach ($failedInserts as $failMsg) {
    //                 echo "$failMsg<br>";
    //             }
    //         }

    //         $progressModel->update(1, ['last_to' => $to]);
    //         $from = $to + 1;
    //         $to = $from + 99;
    //     }
    // }




    // Optimised Code 
    // public function getHotelsDump()
    // {
    //     $apiKey = getenv('HOTELBEDS_API_KEY');
    //     $secret = getenv('HOTELBEDS_SECRET');
    //     $hotelModel = new HotelModel();
    //     $progressModel = new HotelSyncProgressModel();
    //     $db = \Config\Database::connect();

    //     $progressRow = $progressModel->first();
    //     $from = $progressRow ? $progressRow['last_to'] + 1 : 1;
    //     $to = $from + 99;

    //     $allowedAmenities = array_map(fn($a) => mb_strtolower(trim($a)), $this->getAllowedAmenities());

    //     while (true) {
    //         echo "<h3>Fetching hotels from $from to $to</h3>";

    //         $signature = hash("sha256", $apiKey . $secret . time());
    //         $headers = [
    //             "Api-Key: $apiKey",
    //             "X-Signature: $signature"
    //         ];
    //         $endpoint = $this->contentUrl . "/hotels?fields=all&language=ENG&from=$from&to=$to";

    //         try {
    //             $response = $this->fetchData($endpoint, $headers);
    //             $data = json_decode($response, true);
    //         } catch (\Exception $e) {
    //             echo "API Error: " . $e->getMessage();
    //             break;
    //         }

    //         if (empty($data['hotels'])) {
    //             echo "No more hotel data found from $from to $to.";
    //             break;
    //         }

    //         $batchData = [];
    //         $failedInserts = [];

    //         foreach ($data['hotels'] as $hotel) {
    //             try {
    //                 if (empty($hotel['code']) || empty($hotel['name']['content'])) {
    //                     $failedInserts[] = "Missing hotel fields. Code: " . ($hotel['code'] ?? 'N/A');
    //                     continue;
    //                 }

    //                 $hotelCode = $hotel['code'];
    //                 $singleHotelEndpoint = $this->contentUrl . "/hotels/{$hotelCode}/details";
    //                 $singleHotel = $this->fetchData($singleHotelEndpoint, $headers);
    //                 $singleHotelData = json_decode($singleHotel, true);
    //                 $hotelDetail = $singleHotelData['hotel'] ?? [];

    //                 // Amenities filtering
    //                 $amenities = [];
    //                 foreach ($hotelDetail['facilities'] ?? [] as $facility) {
    //                     $desc = $facility['description']['content'] ?? null;
    //                     if ($desc && in_array(mb_strtolower(trim($desc)), $allowedAmenities)) {
    //                         $amenities[] = $desc;
    //                     }
    //                 }

    //                 $phonesJson = json_encode($hotelDetail['phones'] ?? []);
    //                 $boardCodes = isset($hotel['boardCodes']) ? implode(',', $hotel['boardCodes']) : null;
    //                 $segmentCodes = isset($hotel['segmentCodes']) ? json_encode($hotel['segmentCodes']) : null;

    //                 $hotelData = [
    //                     'hotel_code' => $hotelCode,
    //                     'name' => $hotel['name']['content'] ?? null,
    //                     'country_code' => $hotel['countryCode'] ?? null,
    //                     'destination_code' => $hotel['destinationCode'] ?? null,
    //                     'category' => $hotel['categoryCode'] ?? null,
    //                     'latitude' => $hotel['coordinates']['latitude'] ?? null,
    //                     'longitude' => $hotel['coordinates']['longitude'] ?? null,
    //                     'address' => $hotel['address']['content'] ?? null,
    //                     'description' => $hotel['description']['content'] ?? null,
    //                     'rating' => $hotel['categoryCode'] ?? null,
    //                     'thumbnail_url' => $hotel['images'][0]['path'] ?? null,
    //                     'created_at' => date('Y-m-d H:i:s'),
    //                     'state_code' => $hotel['stateCode'] ?? null,
    //                     'zone_code' => $hotel['zoneCode'] ?? null,
    //                     'category_code' => $hotel['categoryCode'] ?? null,
    //                     'category_group_code' => $hotel['categoryGroupCode'] ?? null,
    //                     'chain_code' => $hotel['chainCode'] ?? null,
    //                     'accommodation_type_code' => $hotel['accommodationTypeCode'] ?? null,
    //                     'board_codes' => $boardCodes,
    //                     'segment_codes' => $segmentCodes,
    //                     'hotel_address' => $hotel['address']['content'] ?? null,
    //                     'postal_code' => $hotel['postalCode'] ?? null,
    //                     'city' => $hotel['city']['content'] ?? null,
    //                     'email' => $hotelDetail['email'] ?? null,
    //                     'license' => $hotelDetail['license'] ?? null,
    //                     'giata_code' => $hotel['giataCode'] ?? null,
    //                     'phones' => $phonesJson,
    //                     'thumbnail' => $hotel['images'][0]['path'] ?? null,
    //                     'amenities' => json_encode(array_values(array_unique($amenities))),
    //                 ];

    //                 $batchData[] = $hotelData;
    //             } catch (\Exception $e) {
    //                 $failedInserts[] = "Hotel Code {$hotel['code']}: " . $e->getMessage();
    //             }
    //         }

    //         // Bulk upsert
    //         if (!empty($batchData)) {
    //             $builder = $db->table('hotels');
    //             foreach ($batchData as $row) {
    //                 $builder->replace($row); // REPLACE INTO (works like insert/update)
    //             }
    //         }

    //         echo "<strong>Processed:</strong> " . count($batchData) . "<br>";

    //         if (!empty($failedInserts)) {
    //             echo "<strong>Errors:</strong><br>";
    //             foreach ($failedInserts as $failMsg) {
    //                 echo "$failMsg<br>";
    //             }
    //         }

    //         $progressModel->update(1, ['last_to' => $to]);
    //         $from = $to + 1;
    //         $to = $from + 99;
    //     }
    // }
    // With limit
    public function getHotelsDump()
    {
        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $hotelModel = new HotelModel();
        $progressModel = new HotelSyncProgressModel();
        $db = \Config\Database::connect();

        $progressRow = $progressModel->first();
        $from = $progressRow ? $progressRow['last_to'] + 1 : 1;
        $to = $from + 99;

        $allowedAmenities = array_map(fn($a) => mb_strtolower(trim($a)), $this->getAllowedAmenities());

        while (true) {
            echo "<h3>Fetching hotels from $from to $to</h3>";

            $signature = hash("sha256", $apiKey . $secret . time());
            $headers = [
                "Api-Key: $apiKey",
                "X-Signature: $signature"
            ];
            $endpoint = $this->contentUrl . "/hotels?fields=all&language=ENG&from=$from&to=$to";

            try {
                $response = $this->fetchData($endpoint, $headers);
                $data = json_decode($response, true);
            } catch (\Exception $e) {
                echo "API Error: " . $e->getMessage();
                break;
            }

            if (empty($data['hotels'])) {
                echo "No more hotel data found from $from to $to.";
                break;
            }

            $batchData = [];
            $failedInserts = [];

            foreach ($data['hotels'] as $hotel) {

                try {
                    if (empty($hotel['code']) || empty($hotel['name']['content'])) {
                        $failedInserts[] = "Missing hotel fields. Code: " . ($hotel['code'] ?? 'N/A');
                        continue;
                    }

                    $hotelCode = $hotel['code'];
                    $singleHotelEndpoint = $this->contentUrl . "/hotels/{$hotelCode}/details";
                    $singleHotel = $this->fetchData($singleHotelEndpoint, $headers);
                    $singleHotelData = json_decode($singleHotel, true);
                    $hotelDetail = $singleHotelData['hotel'] ?? [];

                    $amenities = [];
                    foreach ($hotelDetail['facilities'] ?? [] as $facility) {
                        $desc = $facility['description']['content'] ?? null;
                        if ($desc && in_array(mb_strtolower(trim($desc)), $allowedAmenities)) {
                            $amenities[] = $desc;
                        }
                    }

                    $phonesJson = json_encode($hotelDetail['phones'] ?? []);
                    $boardCodes = isset($hotel['boardCodes']) ? implode(',', $hotel['boardCodes']) : null;
                    $segmentCodes = isset($hotel['segmentCodes']) ? json_encode($hotel['segmentCodes']) : null;

                    $hotelData = [
                        'hotel_code' => $hotelCode,
                        'name' => $hotel['name']['content'] ?? null,
                        'country_code' => $hotel['countryCode'] ?? null,
                        'destination_code' => $hotel['destinationCode'] ?? null,
                        'category' => $hotel['categoryCode'] ?? null,
                        'latitude' => $hotel['coordinates']['latitude'] ?? null,
                        'longitude' => $hotel['coordinates']['longitude'] ?? null,
                        'address' => $hotel['address']['content'] ?? null,
                        'description' => $hotel['description']['content'] ?? null,
                        'rating' => $hotel['categoryCode'] ?? null,
                        'thumbnail_url' => $hotel['images'][0]['path'] ?? null,
                        'created_at' => date('Y-m-d H:i:s'),
                        'state_code' => $hotel['stateCode'] ?? null,
                        'zone_code' => $hotel['zoneCode'] ?? null,
                        'category_code' => $hotel['categoryCode'] ?? null,
                        'category_group_code' => $hotel['categoryGroupCode'] ?? null,
                        'chain_code' => $hotel['chainCode'] ?? null,
                        'accommodation_type_code' => $hotel['accommodationTypeCode'] ?? null,
                        'board_codes' => $boardCodes,
                        'segment_codes' => $segmentCodes,
                        'hotel_address' => $hotel['address']['content'] ?? null,
                        'postal_code' => $hotel['postalCode'] ?? null,
                        'city' => $hotel['city']['content'] ?? null,
                        'email' => $hotelDetail['email'] ?? null,
                        'license' => $hotelDetail['license'] ?? null,
                        'giata_code' => $hotel['giataCode'] ?? null,
                        'phones' => $phonesJson,
                        'amenities' => json_encode(array_values(array_unique($amenities))),
                    ];

                    $batchData[] = $hotelData;

                } catch (\Exception $e) {
                    $failedInserts[] = "Hotel Code {$hotel['code']}: " . $e->getMessage();
                }
            }

            if (!empty($batchData)) {
                $builder = $db->table('hotels');
                foreach ($batchData as $row) {
                    $builder->replace($row);
                }
            }

            echo "<strong>Processed:</strong> " . count($batchData) . "<br>";

            if (!empty($failedInserts)) {
                echo "<strong>Errors:</strong><br>";
                foreach ($failedInserts as $failMsg) {
                    echo "$failMsg<br>";
                }
            }

            $progressModel->update(1, ['last_to' => $to]);
            $from = $to + 1;
            $to = $from + 99;
        }
    }




    public function getHotelsDestinationsDump()
    {
        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $signature = hash("sha256", $apiKey . $secret . time());

        $headers = [
            "Api-Key: $apiKey",
            "X-Signature: $signature",
            "Accept: application/json"
        ];

        $from = isset($_GET['from']) ? intval($_GET['from']) : 1;
        $to = isset($_GET['to']) ? intval($_GET['to']) : 1000;

        $endpoint = $this->contentUrl . "/locations/destinations?fields=all&language=ENG&from=$from&to=$to&useSecondaryLanguage=false";
        $response = $this->fetchData($endpoint, $headers);
        $data = json_decode($response, true);

        if (!isset($data['destinations'])) {
            echo "No destinations found.";
            return;
        }

        $destinationModel = new DestinationModel();

        foreach ($data['destinations'] as $destination) {
            $baseData = [
                'code' => $destination['code'] ?? null,
                'name' => $destination['name']['content'] ?? null,
                'country_code' => $destination['countryCode'] ?? null,
                'iso_code' => $destination['isoCode'] ?? null,
            ];

            if (!empty($destination['zones'])) {
                foreach ($destination['zones'] as $zone) {
                    $row = $baseData + [
                        'zone_code' => $zone['zoneCode'] ?? null,
                        'description' => $zone['description']['content'] ?? null
                    ];
                    $destinationModel->insert($row);
                }
            } else {
                $row = $baseData + [
                    'zone_code' => null,
                    'description' => null
                ];
                $destinationModel->insert($row);
            }
        }

        echo "Destinations with zones stored successfully.";
    }

    public function getHotelsCountriesDump()
    {
        $apiKey = getenv('HOTELBEDS_API_KEY');
        $secret = getenv('HOTELBEDS_SECRET');
        $signature = hash("sha256", $apiKey . $secret . time());

        $headers = [
            "Api-Key: $apiKey",
            "X-Signature: $signature",
            "Accept: application/json"
        ];

        $from = isset($_GET['from']) ? intval($_GET['from']) : 1;
        $to = isset($_GET['to']) ? intval($_GET['to']) : 203;

        $endpoint = $this->contentUrl . "/locations/countries?fields=all&language=ENG&from=$from&to=$to";
        $response = $this->fetchData($endpoint, $headers);
        $data = json_decode($response, true);

        if (!isset($data['countries'])) {
            echo "No countries found.";
            return;
        }

        $countryModel = new CountryModel();

        foreach ($data['countries'] as $country) {
            $base = [
                'country_code' => $country['code'] ?? null,
                'iso_code' => $country['isoCode'] ?? null,
                'country_name' => $country['description']['content'] ?? null,
            ];

            if (!empty($country['states'])) {
                foreach ($country['states'] as $state) {
                    $row = $base + [
                        'state_code' => $state['code'] ?? null,
                        'state_name' => $state['name'] ?? null,
                    ];
                    $countryModel->insert($row);
                }
            } else {
                $row = $base + [
                    'state_code' => null,
                    'state_name' => null,
                ];
                $countryModel->insert($row);
            }
        }

        echo "Countries and states stored successfully.";
    }

    private function fetchData($url, $headers)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            return;
        }

        curl_close($ch);
        return $response;
    }

    private function getBlockedAmenities(): array
    {
        return [
            'Year Of Construction',
            'Total Number Of Rooms',
            'Number Of Floors (main Building)',
            'Year Of Most Recent Renovation',
            'Double Rooms',
            'Number Of Bedrooms',
            'Bus/train Station',
            'Airport',
            'Fax',
            'Room Size (sqm)',
            'Dvd Player',
            'Alarm Clock',
            'Darts',
            'Table Tennis',
            'No Hen/stag Or Any Other Parties Allowed',
            'Gala Dinner',
            'Windsurfing',
            'Canoeing',
            'Bowling Alley',
            'Electric Kettle',
            'Full Board With Drinks',
            'Ski Slopes',
            'Lodge',
            'Towel Menu',
            'Only Adults',
            'Secretarial Service',
            'Jet Ski',
            'Nh - Feel Safe At Nh',
            'Desk',
            'Morocco - Tourisme Au Maroc Post Covid-19',
            'Riu - Covid-19 Health Protocol',
        ];
    }

    //Blocked amenities removed from existing hotel records.
    // public function cleanBlockedAmenitiesFromDB()
    // {
    //     $hotelModel = new \App\Models\HotelModel();
    //     $blocked = array_map('mb_strtolower', $this->getBlockedAmenities()); // make all lowercase

    //     $hotels = $hotelModel->findAll();

    //     foreach ($hotels as $hotel) {
    //         $amenities = json_decode($hotel['amenities'], true);
    //         if (!is_array($amenities)) continue;

    //         // lowercase all amenities for comparison
    //         $filteredAmenities = array_filter($amenities, function ($a) use ($blocked) {
    //             return !in_array(mb_strtolower($a), $blocked);
    //         });

    //         if ($filteredAmenities !== $amenities) {
    //             $hotelModel->update($hotel['id'], [
    //                 'amenities' => json_encode(array_values($filteredAmenities))
    //             ]);
    //         }
    //     }

    //     echo "Blocked amenities removed from existing hotel records.";
    // }

    //Blocked amenities removed (with case-insensitive + trim check)
    public function cleanBlockedAmenitiesFromDB()
    {
        $hotelModel = new \App\Models\HotelModel();
        $blocked = array_map(fn($a) => mb_strtolower(trim($a)), $this->getBlockedAmenities());

        $hotels = $hotelModel->findAll();

        foreach ($hotels as $hotel) {
            $raw = $hotel['amenities'];
            $amenities = json_decode($raw, true);

            if (!is_array($amenities)) continue;

            $filtered = array_filter($amenities, function ($item) use ($blocked) {
                return !in_array(mb_strtolower(trim($item)), $blocked);
            });

            if ($filtered !== $amenities) {
                $hotelModel->update($hotel['id'], [
                    'amenities' => json_encode(array_values($filtered))
                ]);
            }
        }

        echo "Blocked amenities removed (with case-insensitive + trim check).";
    }

    private function getAllowedAmenities(): array
    {
        return [
            '24-hour reception',
            'Adapted for disabled',
            'Air conditioned',
            'Barbecue facilities',
            'Bathroom',
            'Connecting rooms',
            'Fireplace',
            'Games Room',
            'Gym',
            'Heating',
            'Hot Tub',
            'Internet',
            'Parking',
            'Private pool',
            'Restaurant',
            'Safe2Stay',
            'Shower',
            'Ski to door access',
            'Spa',
            'Swimming Pool',
            'TV',
        ];
    }

    public function cleanUnallowedAmenitiesFromDB()
    {
        $hotelModel = new \App\Models\HotelModel();
        $allowed = array_map(fn($a) => mb_strtolower(trim($a)), $this->getAllowedAmenities());

        $hotels = $hotelModel->findAll();

        foreach ($hotels as $hotel) {
            $raw = $hotel['amenities'];
            $amenities = json_decode($raw, true);

            if (!is_array($amenities)) continue;

            // Keep only allowed
            $filtered = array_filter($amenities, function ($item) use ($allowed) {
                return in_array(mb_strtolower(trim($item)), $allowed);
            });

            if ($filtered !== $amenities) {
                $hotelModel->update($hotel['id'], [
                    'amenities' => json_encode(array_values(array_unique($filtered)))
                ]);
            }
        }

        echo "Only allowed amenities retained in all hotel records.";
    }
}
