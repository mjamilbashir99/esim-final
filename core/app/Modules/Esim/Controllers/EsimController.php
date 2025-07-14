<?php

namespace Modules\Esim\Controllers;

use App\Controllers\BaseController;
use Modules\Esim\Models\MarkupModel;
use Modules\Esim\Models\UserModel;
use Modules\Blog\Models\CountryModel;
use App\Libraries\EsimTemplate;
use CodeIgniter\Pager\Pager;


class EsimController extends BaseController
{
    protected $template;
    protected $userModel;
    public function __construct()
    {
        $this->template = new EsimTemplate();
        $this->userModel = new UserModel();
    }
    public function getApiInfo()
    {
        $client = \Config\Services::curlrequest();
        $apiKey = getenv('ESIM_API_KEY');
        try {
            $response = $client->get('https://api.esim-go.com/v2.3/', [
                'headers' => [
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            return $this->response->setJSON([
                'available_endpoints' => $body
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Request failed: ' . $e->getMessage()
            ]);
        }
    }

    // get all bundeles
    public function getBundles()
    {
        $client = \Config\Services::curlrequest();
        $apiKey = getenv('ESIM_API_KEY');

        try {
            $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
                'headers' => [
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            return $this->response->setJSON([
                'bundles' => $body
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Failed to fetch bundles: ' . $e->getMessage()
            ]);
        }
    }

    // get bundles by country
    // http://localhost:8080/api/bundles/United%20Arab%20Emirates
    public function getBundlesByCountry($countryName)
    {
        $client = \Config\Services::curlrequest();
        $apiKey = getenv('ESIM_API_KEY');

        try {
            $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
                'headers' => [
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $bundles = $body['bundles'] ?? [];

            // Filter by country
            $filtered = array_filter($bundles, function ($bundle) use ($countryName) {
                foreach ($bundle['countries'] as $country) {
                    if (strtolower($country['name']) === strtolower($countryName)) {
                        return true;
                    }
                }
                return false;
            });

            return $this->response->setJSON([
                'country' => $countryName,
                'bundles' => array_values($filtered)
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Failed to fetch bundles: ' . $e->getMessage()
            ]);
        }
    }

    // public function showBundles()
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');
    //     $page = (int) ($this->request->getGet('page') ?? 1);
    //     $selectedCountry = $this->request->getGet('country');
    //     $searchQuery = $this->request->getGet('search');  // Get search query
    //     $perPage = 12;

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];

    //         // Extract unique countries
    //         $countryList = [];
    //         foreach ($allBundles as $bundle) {
    //             foreach ($bundle['countries'] as $country) {
    //                 $countryList[$country['name']] = true;
    //             }
    //         }
    //         $countries = array_keys($countryList);

    //         // Search functionality: Filter bundles based on search query
    //         if ($searchQuery) {
    //             $allBundles = array_filter($allBundles, function ($bundle) use ($searchQuery) {
    //                 foreach ($bundle['countries'] as $country) {
    //                     if (stripos($country['name'], $searchQuery) !== false) {
    //                         return true;
    //                     }
    //                 }
    //                 return false;
    //             });
    //             $allBundles = array_values($allBundles); // Re-index after filtering
    //         }


    //         // Filter by selected country if exists
    //         if ($selectedCountry) {
    //             $allBundles = array_filter($allBundles, function ($bundle) use ($selectedCountry) {
    //                 foreach ($bundle['countries'] as $country) {
    //                     if (strtolower($country['name']) === strtolower($selectedCountry)) {
    //                         return true;
    //                     }
    //                 }
    //                 return false;
    //             });
    //             $allBundles = array_values($allBundles); // Re-index after filtering
    //         }

    //         // Manual pagination
    //         $total = count($allBundles);
    //         $start = ($page - 1) * $perPage;
    //         $bundles = array_slice($allBundles, $start, $perPage);
    //         // After array_slice:
    //         $bundles = array_slice($allBundles, $start, $perPage);

    //         // Add selling price
    //         foreach ($bundles as &$bundle) {
    //             if (isset($bundle['price'])) {
    //                 $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
    //             }
    //         }
    //         //  return $this->template->render('admin/all-users', $data);
    //         return $this->template->render('bundles_list', [
    //             'bundles' => $bundles,
    //             'currentPage' => $page,
    //             'totalPages' => ceil($total / $perPage),
    //             'countries' => $countries,
    //             'selectedCountry' => $selectedCountry,
    //             'searchQuery' => $searchQuery // Pass search query to the view
    //         ]);

    //     } catch (\Exception $e) {
    //         return $this->template->render('bundles_list', ['bundles' => [], 'error' => $e->getMessage()]);
    //     }
    // }
    //With Region
    //     public function showBundles()
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');
    //     $page = (int) ($this->request->getGet('page') ?? 1);
    //     $selectedCountry = $this->request->getGet('country');
    //     $searchQuery = $this->request->getGet('search');
    //     $perPage = 12;

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];

    //         // Extract unique countries
    //         $countryList = [];
    //         foreach ($allBundles as $bundle) {
    //             foreach ($bundle['countries'] as $country) {
    //                 $countryList[$country['name']] = true;
    //             }
    //         }
    //         $countries = array_keys($countryList);

    //         // Extract unique regions and region-wise bundles
    //         $regionList = [];
    //         $regionBundles = [];

    //         foreach ($allBundles as $bundle) {
    //             foreach ($bundle['countries'] as $country) {
    //                 if (!empty($country['region'])) {
    //                     $regionList[$country['region']] = true;
    //                     $regionBundles[$country['region']][] = $bundle;
    //                 }
    //             }
    //         }
    //         $regions = array_keys($regionList);

    //         // Filter by search (for country)
    //         if ($searchQuery) {
    //             $allBundles = array_filter($allBundles, function ($bundle) use ($searchQuery) {
    //                 foreach ($bundle['countries'] as $country) {
    //                     if (stripos($country['name'], $searchQuery) !== false) {
    //                         return true;
    //                     }
    //                 }
    //                 return false;
    //             });
    //             $allBundles = array_values($allBundles);
    //         }

    //         // Filter by selected country
    //         if ($selectedCountry) {
    //             $allBundles = array_filter($allBundles, function ($bundle) use ($selectedCountry) {
    //                 foreach ($bundle['countries'] as $country) {
    //                     if (strtolower($country['name']) === strtolower($selectedCountry)) {
    //                         return true;
    //                     }
    //                 }
    //                 return false;
    //             });
    //             $allBundles = array_values($allBundles);
    //         }

    //         // Manual pagination
    //         $total = count($allBundles);
    //         $start = ($page - 1) * $perPage;
    //         $bundles = array_slice($allBundles, $start, $perPage);

    //         // Add selling price
    //         foreach ($bundles as &$bundle) {
    //             if (isset($bundle['price'])) {
    //                 $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
    //             }
    //         }

    //         return $this->template->render('bundles_list', [
    //             'bundles' => $bundles,
    //             'currentPage' => $page,
    //             'totalPages' => ceil($total / $perPage),
    //             'countries' => $countries,
    //             'regions' => $regions,
    //             'regionBundles' => $regionBundles,
    //             'selectedCountry' => $selectedCountry,
    //             'searchQuery' => $searchQuery
    //         ]);
    //     } catch (\Exception $e) {
    //         return $this->template->render('bundles_list', [
    //             'bundles' => [],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
    public function showBundles()
    {
        $client = \Config\Services::curlrequest();
        $apiKey = getenv('ESIM_API_KEY');
        $page = (int) ($this->request->getGet('page') ?? 1);
        $tab = $this->request->getGet('tab') ?? 'country'; 
        $selectedCountry = $this->request->getGet('country');
        $searchQuery = $this->request->getGet('search');
        $perPage = 12;

        try {
            $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
                'headers' => [
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $allBundles = $body['bundles'] ?? [];

            // Countries list
            $countryList = [];
            foreach ($allBundles as $bundle) {
                foreach ($bundle['countries'] as $country) {
                    $countryList[$country['name']] = true;
                }
            }
            $countries = array_keys($countryList);

            // Region list and flat list for pagination
            $regionList = [];
            $regionBundlesGrouped = [];
            $flatRegionBundles = [];

            foreach ($allBundles as $bundle) {
                foreach ($bundle['countries'] as $country) {
                    if (!empty($country['region'])) {
                        $regionList[$country['region']] = true;
                        $regionBundlesGrouped[$country['region']][] = $bundle;

                        $bundle['_region'] = $country['region']; 
                        $flatRegionBundles[] = $bundle;
                    }
                }
            }

            $regions = array_keys($regionList);

            // Handle COUNTRY view
            $paginatedCountryBundles = [];
            $countryTotal = 0;

            if ($tab === 'country') {
                // Apply filters
                if ($searchQuery) {
                    $allBundles = array_filter($allBundles, function ($bundle) use ($searchQuery) {
                        foreach ($bundle['countries'] as $country) {
                            if (stripos($country['name'], $searchQuery) !== false) {
                                return true;
                            }
                        }
                        return false;
                    });
                    $allBundles = array_values($allBundles);
                }

                if ($selectedCountry) {
                    $allBundles = array_filter($allBundles, function ($bundle) use ($selectedCountry) {
                        foreach ($bundle['countries'] as $country) {
                            if (strtolower($country['name']) === strtolower($selectedCountry)) {
                                return true;
                            }
                        }
                        return false;
                    });
                    $allBundles = array_values($allBundles);
                }

                $countryTotal = count($allBundles);
                $start = ($page - 1) * $perPage;
                $paginatedCountryBundles = array_slice($allBundles, $start, $perPage);

                foreach ($paginatedCountryBundles as &$bundle) {
                    if (isset($bundle['price'])) {
                        $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
                        // var_dump($bundle['selling_price']);
                    }
                }
            }

            // Handle REGION view
            $paginatedRegionBundles = [];
            $regionTotal = count($flatRegionBundles);

            if ($tab === 'region') {
                $start = ($page - 1) * $perPage;
                $paginatedRegionBundles = array_slice($flatRegionBundles, $start, $perPage);

                foreach ($paginatedRegionBundles as &$bundle) {
                    if (isset($bundle['price'])) {
                        $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
                    }
                }
            }

            return $this->template->render('Esim/Views/bundles_list', [
                'bundles' => $paginatedCountryBundles,
                'paginatedRegionBundles' => $paginatedRegionBundles,
                'countries' => $countries,
                'regions' => $regions,
                'regionBundles' => $regionBundlesGrouped,
                'selectedCountry' => $selectedCountry,
                'searchQuery' => $searchQuery,
                'activeTab' => $tab,
                'currentPage' => $page,
                'totalPages' => $tab === 'region' ? ceil($regionTotal / $perPage) : ceil($countryTotal / $perPage),
            ]);
        } catch (\Exception $e) {
            return $this->template->render('Esim/Views/bundles_list', [
                'bundles' => [],
                'error' => $e->getMessage(),
                'activeTab' => $tab
            ]);
        }
    }

    //view all destinations
    public function viewAllDestinations($countryName = null)
{
    $client = \Config\Services::curlrequest();
    $apiKey = getenv('ESIM_API_KEY');

    try {
        $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
            'headers' => [
                'X-API-Key' => $apiKey,
                'Content-Type' => 'application/json'
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        $allBundles = $body['bundles'] ?? [];

        if ($countryName) {
            // Filter for specific country
            $filteredBundles = array_filter($allBundles, function ($bundle) use ($countryName) {
                foreach ($bundle['countries'] as $country) {
                    if (strtolower($country['name']) === strtolower(urldecode($countryName))) {
                        return true;
                    }
                }
                return false;
            });

            $filteredBundles = array_values($filteredBundles);

            return $this->template->render('layouts/country_plans', [
                'country' => urldecode($countryName),
                'bundles' => $filteredBundles
            ]);
        } else {
            // Group all bundles by country
            $destinations = [];

            foreach ($allBundles as $bundle) {
                foreach ($bundle['countries'] as $country) {
                    $countryName = $country['name'];
                    $destinations[$countryName][] = $bundle;
                }
            }

            ksort($destinations);

            return $this->template->render('layouts/all_destinations', [
                'destinations' => $destinations
            ]);
        }

    } catch (\Exception $e) {
        if ($countryName) {
            return $this->template->render('layouts/country_plans', [
                'country' => urldecode($countryName),
                'bundles' => [],
                'error' => $e->getMessage()
            ]);
        } else {
            return $this->template->render('layouts/all_destinations', [
                'destinations' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
}

    // public function viewAllDestinations()
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];

    //         // Group bundles by country
    //         $destinations = [];

    //         foreach ($allBundles as $bundle) {
    //             foreach ($bundle['countries'] as $country) {
    //                 $countryName = $country['name'];
    //                 if (!isset($destinations[$countryName])) {
    //                     $destinations[$countryName] = [];
    //                 }
    //                 $destinations[$countryName][] = $bundle;
    //             }
    //         }

    //         ksort($destinations);

    //         return  $this->template->render('layouts/all_destinations', [
    //             'destinations' => $destinations
    //         ]);
    //     } catch (\Exception $e) {
    //         return  $this->template->render('layouts/all_destinations', [
    //             'destinations' => [],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // public function countryPlans($countryName)
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];

    //         // Filter bundles for the requested country (case-insensitive)
    //         $countryBundles = array_filter($allBundles, function ($bundle) use ($countryName) {
    //             foreach ($bundle['countries'] as $country) {
    //                 if (strtolower($country['name']) === strtolower(urldecode($countryName))) {
    //                     return true;
    //                 }
    //             }
    //             return false;
    //         });

    //         // Optional: Re-index array
    //         $countryBundles = array_values($countryBundles);

    //         return $this->template->render('layouts\country_plans', [
    //             'country' => urldecode($countryName),
    //             'bundles' => $countryBundles
    //         ]);
    //     } catch (\Exception $e) {
    //         return $this->template->render('layouts\country_plans', [
    //             'country' => urldecode($countryName),
    //             'bundles' => [],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }



    // public function showBundles()
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');
    //     $page = (int) ($this->request->getGet('page') ?? 1);
    //     $selectedCountry = $this->request->getGet('country');
    //     $perPage = 12;

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];

    //         $countryList = [];
    //         foreach ($allBundles as $bundle) {
    //             foreach ($bundle['countries'] as $country) {
    //                 $countryList[$country['name']] = true;
    //             }
    //         }
    //         $countries = array_keys($countryList);

    //         if ($selectedCountry) {
    //             $allBundles = array_filter($allBundles, function ($bundle) use ($selectedCountry) {
    //                 foreach ($bundle['countries'] as $country) {
    //                     if (strtolower($country['name']) === strtolower($selectedCountry)) {
    //                         return true;
    //                     }
    //                 }
    //                 return false;
    //             });
    //             $allBundles = array_values($allBundles); 
    //         }


    //         $total = count($allBundles);
    //         $start = ($page - 1) * $perPage;
    //         $bundles = array_slice($allBundles, $start, $perPage);

    //         foreach ($bundles as &$bundle) {
    //             if (isset($bundle['price'])) {
    //                 $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
    //             }
    //         }

    //         return $this->template->render('bundles_list', [
    //             'bundles' => $bundles,
    //             'currentPage' => $page,
    //             'totalPages' => ceil($total / $perPage),
    //             'countries' => $countries,
    //             'selectedCountry' => $selectedCountry
    //         ]);

    //     } catch (\Exception $e) {
    //         return $this->template->render('bundles_list', [
    //             'bundles' => [],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }


    //     public function showBundles()
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');

    //     $searchQuery = $this->request->getGet('search');

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ],
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];
    //         var_dump($body);die();
    //         // Filter bundles based on search query (country name)
    //         if (!empty($searchQuery)) {
    //             $allBundles = $this->searchBundlesByCountryName($allBundles, $searchQuery);
    //         }
    //         var_dump($allBundles);die();

    //         // Calculate selling price
    //         foreach ($allBundles as &$bundle) {
    //             if (isset($bundle['price'])) {
    //                 $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
    //             }
    //         }

    //         return $this->template->render('bundles_list', [
    //             'bundles' => $allBundles,
    //             'searchQuery' => $searchQuery,
    //         ]);

    //     } catch (\Exception $e) {
    //         return $this->template->render('bundles_list', [
    //             'bundles' => [],
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // private function searchBundlesByCountryName(array $bundles, string $searchQuery): array
    // {
    //     $filtered = array_filter($bundles, function ($bundle) use ($searchQuery) {
    //         foreach ($bundle['countries'] as $country) {
    //             if (stripos($country['name'], $searchQuery) !== false) {
    //                 return true;
    //             }
    //         }
    //         return false;
    //     });

    //     return array_values($filtered);
    // }


    public function getCountrySuggestions()
    {
        $searchQuery = $this->request->getGet('query');

        if (empty($searchQuery)) {
            return $this->response->setJSON([]);
        }

        $client = \Config\Services::curlrequest();
        $apiKey = getenv('ESIM_API_KEY');

        try {
            $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
                'headers' => [
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $allBundles = $body['bundles'] ?? [];

            $countryList = [];
            foreach ($allBundles as $bundle) {
                foreach ($bundle['countries'] as $country) {
                    $countryList[] = $country['name'];
                }
            }

            $countryList = array_unique($countryList);

            $matchingCountries = array_filter($countryList, function ($country) use ($searchQuery) {
                return stripos($country, $searchQuery) !== false;
            });

            $matchingCountries = array_slice(array_values($matchingCountries), 0, 10);

            return $this->response->setJSON($matchingCountries);
        } catch (\Exception $e) {
            return $this->response->setJSON([]);
        }
    }
    //     public function getCountrySuggestions()
    // {
    //     $searchQuery = $this->request->getGet('query');

    //     if (empty($searchQuery)) {
    //         return $this->response->setJSON([]);
    //     }

    //     $countryModel = new \App\Models\CountryModel();

    //     $countries = $countryModel->distinct()
    //         ->select('name')
    //         ->like('name', $searchQuery)
    //         ->orderBy('name', 'ASC')
    //         ->limit(10)
    //         ->findAll();

    //     // Remove exact duplicates and trim whitespace
    //     $countryNames = array_unique(array_map('trim', array_column($countries, 'name')));

    //     return $this->response->setJSON($countryNames);
    // }





    public function viewbundle($bundleName)
    {
        $client = \Config\Services::curlrequest();
        $apiKey = getenv('ESIM_API_KEY');

        try {
            $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
                'headers' => [
                    'X-API-Key' => $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $allBundles = $body['bundles'] ?? [];
            // var_dump($allBundles);die();

            // Find and return only the main bundle
            foreach ($allBundles as $b) {
                if ($b['name'] === $bundleName) {
                    // Add selling price here also
                    if (isset($b['price'])) {
                        $b['selling_price'] = $this->calculateSellingPrice($b['price']);
                    }
                    return $this->template->render('Esim/Views/bundle_detail', ['bundle' => $b]);
                }
            }

            throw new \Exception("Bundle not found.");
        } catch (\Exception $e) {
            return $this->response->setStatusCode(404)->setBody("Bundle not found or error: " . $e->getMessage());
        }
    }
    // Optimised 
    // public function viewbundle($bundleName)
    // {
    //     $client = \Config\Services::curlrequest();
    //     $apiKey = getenv('ESIM_API_KEY');

    //     try {
    //         $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
    //             'headers' => [
    //                 'X-API-Key' => $apiKey,
    //                 'Content-Type' => 'application/json'
    //             ],
    //             'query' => [
    //                 'countries' => 'PK,IN,AE,US'
    //             ]
    //         ]);

    //         $body = json_decode($response->getBody(), true);
    //         $allBundles = $body['bundles'] ?? [];

    //         $foundBundle = null;
    //         foreach ($allBundles as $bundle) {
    //             if (strtolower($bundle['name']) === strtolower(urldecode($bundleName))) {
    //                 if (isset($bundle['price'])) {
    //                     $bundle['selling_price'] = $this->calculateSellingPrice($bundle['price']);
    //                 }
    //                 $foundBundle = $bundle;
    //                 break;
    //             }
    //         }

    //         if (!$foundBundle) {
    //             throw new \Exception('Bundle not found');
    //         }

    //         return $this->template->render('bundle_detail', [
    //             'bundle' => $foundBundle
    //         ]);

    //     } catch (\Exception $e) {
    //         return $this->template->render('bundle_detail', [
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }



    public function viewCart()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        return $this->template->render('Esim/Views/cart_view', ['cart' => $cart]);
    }

    public function addToCart()
    {
        $request = service('request');
        $session = session();

        $data = $request->getJSON(true);

        $bundleName = $data['bundleName'] ?? '';
        $country = $data['country'] ?? 'N/A';
        $price = $data['price'] ?? 0;
        $quantity = $data['quantity'] ?? 1;

        if (!$bundleName || $quantity < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid input']);
        }

        $cart = $session->get('cart') ?? [];

        if (isset($cart[$bundleName])) {
            $cart[$bundleName]['quantity'] += $quantity;
        } else {
            $cart[$bundleName] = [
                'name' => $bundleName,
                'country' => $country,
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        $session->set('cart', $cart);

        return $this->response->setJSON(['success' => true, 'message' => 'Bundle added to cart', 'cartCount' => count($cart)]);
    }


    public function removeFromCart()
    {
        $request = service('request');
        $session = session();

        $bundleName = $request->getPost('bundleName');

        $cart = $session->get('cart') ?? [];

        if (isset($cart[$bundleName])) {
            unset($cart[$bundleName]);
            $session->set('cart', $cart);
        }

        return redirect()->to(site_url('cart'))->with('success', 'Bundle removed from cart');
    }
    public function cartCount()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $count = count($cart);

        return $this->response->setJSON(['count' => $count]);
    }

    // public function checkout()
    // {
    //     $session = session();
    //     $cart = $session->get('cart') ?? [];



    //     if (empty($cart)) {
    //         return redirect()->to('/')->with('message', 'Your cart is empty.');
    //     }

    //     return $this->template->render('checkout', ['cart' => $cart]);
    // }
    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/')->with('message', 'Your cart is empty.');
        }

        if (!$session->get('logged_in')) {
            $session->set('redirect_after_login', current_url());
            return redirect()->to('/login')->with('message', 'Please log in to continue checkout.');
        }

        return $this->template->render('Esim/Views/checkout', ['cart' => $cart]);
    }


    private function calculateSellingPrice($costPrice)
    {
        $profitMargin = $this->getB2CMarkup(); 
        // var_dump($profitMargin);die();
        $profitMarginPercentage = $profitMargin / 100;
        // var_dump($profitMarginPercentage);die();
        return round($costPrice + ($costPrice * $profitMarginPercentage), 2);
    }

    private function getB2CMarkup()
    {
        $markupModel = new MarkupModel();

        $markup = $markupModel->where('status', 'enabled')->first();

        if ($markup && isset($markup['b2c_markup'])) {
            return (float) $markup['b2c_markup'];
        }

        return 0;
    }

    public function book()
    {
        $data = $this->request->getJSON(true);

        $paymentMethodId = $data['payment_method'] ?? '';
        $cartItems = $data['cart_items'] ?? [];
        $grandTotal = $data['grand_total'] ?? 0;
        $iccids = $data['iccids'] ?? [];

        if (empty($paymentMethodId) || empty($cartItems) || empty($iccids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required data.'
            ]);
        }

        $apiKey = getenv('ESIM_API_KEY');
        // echo $apiKey; exit;


        // Prepare Order Data
        $order = [];
        foreach ($cartItems as $item) {
            $bundleName = $item['name'] ?? '';
            $quantity = $item['quantity'] ?? 1;

            if (isset($iccids[$bundleName])) {
                $order[] = [
                    'type' => 'bundle',
                    'quantity' => $quantity,
                    'item' => $bundleName,
                    // 'iccids' => $iccids[$bundleName],
                    'allowReassign' => true
                ];
            }
        }

        if (empty($order)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No valid order data found.'
            ]);
        }

        $postData = [
            'type' => 'transaction',
            'assign' => true,
            'order' => $order
        ];


        $logDir = WRITEPATH . 'esim_logs/';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $filename = $logDir . 'payload_' . date('Ymd_His') . '.json';

        file_put_contents($filename, json_encode($postData, JSON_PRETTY_PRINT));


        // cURL API Call
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.esim-go.com/v2.4/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-API-Key: ' . $apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $logDir = WRITEPATH . 'esim_logs/';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $filename = $logDir . 'response_' . date('Ymd_His') . '.json';

        file_put_contents($filename, json_encode($response, JSON_PRETTY_PRINT));

        $responseData = json_decode($response, true);

        $responseData = json_decode($response, true);
        file_put_contents(WRITEPATH . 'esim_logs/last_decoded_response.json', json_encode($responseData, JSON_PRETTY_PRINT));
        
        if ($httpCode === 200 && isset($responseData['order'][0]['esims'][0])) {
            $orderData = $responseData['order'][0];
            $esimInfo = $orderData['esims'][0];
        
            $iccid = $esimInfo['iccid'] ?? '';
            $matchingId = $esimInfo['matchingId'] ?? '';
            $smdpAddress = $esimInfo['smdpAddress'] ?? '';
            $orderId = $responseData['orderReference'] ?? '';

            $session = session();
            $session->set([
                'iccid'        => $iccid,
                'matchingId'   => $matchingId,
                'smdpAddress'  => $smdpAddress,
                'orderId'      => $orderId
            ]);
            $session->remove('cart'); // preferred method over unset()

        
            return $this->response->setJSON([
                'success' => true,
                'iccid' => $iccid,
                'matchingId' => $matchingId,
                'smdpAddress' => $smdpAddress,
                'orderId' => $orderId
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'eSIM Go API call failed or invalid response.',
                'http_code' => $httpCode,
                'response' => $responseData
            ]);
        }
        

    }

    public function viewProfile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return $this->template->render('profile/edit', ['user' => $user]);
    }

    public function updateProfile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'No user found.');
        }

        $rules = [
            'name'          => 'required',
            'phone'         => 'required',
            'email'         => 'required|valid_email',
            'password'      => 'permit_empty|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'         => $this->request->getPost('name'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);

        session()->set([
            'user_name'         => $data['name'],
            'user_email'        => $data['email'],
            'user_phone'        => $data['phone'],
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


    public function set()
    {
        $session = session();
        $currency = $this->request->getGet('currency');

        $allowed = ['USD', 'EUR', 'GBP', 'CAD', 'AUD', 'INR', 'CNY', 'JPY', 'SAR', 'AED'];

        if (in_array($currency, $allowed)) {
            $session->set('currency', $currency);
        }

        return redirect()->back();
    }







    public function showSingleBundlePerCountry()
    {
        // echo "sss";die();
        $apiKey = getenv('ESIM_API_KEY');
        $client = \Config\Services::curlrequest();
        $countryPlans = [];

        try {
            $response = $client->get('https://api.esim-go.com/v2.3/catalogue', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $apiKey
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $bundles = $data['bundles'] ?? [];

            $seenCountries = [];

            foreach ($bundles as $bundle) {
                $country = $bundle['countries'][0] ?? null;
                if (!$country) {
                    continue;
                }

                $iso = $country['iso'] ?? '';
                if (isset($seenCountries[$iso])) {
                    continue;
                }

                $bundle['countryName'] = $country['name'] ?? 'Unknown';
                $bundle['countryIso'] = strtolower($iso);
                $seenCountries[$iso] = true;

                $countryPlans[] = $bundle;
            }
        } catch (\Exception $e) {
            // Optionally log the error
            return redirect()->back()->with('error', 'An error occurred. Please try again later.');
        }

        // Handle pagination manually using CI4's Pager
        $pager = \Config\Services::pager();
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 10;
        $total = count($countryPlans);
        $offset = ($page - 1) * $perPage;

        // Paginate the countryPlans array
        $paginatedPlans = array_slice($countryPlans, $offset, $perPage);

        return $this->template->render('Esim/Views/plans/list', [
            'plans' => $paginatedPlans,
            'pager' => $pager->makeLinks($page, $perPage, $total, 'custom'), // 'custom' = your pagination template name
        ]);
    }

    public function thankyou(){
        $session = session();
        $iccid = $session->get('iccid');
        $matchingId = $session->get('matchingId');
        $smdpAddress = $session->get('smdpAddress');
        $orderId = $session->get('orderId');
        return $this->template->render('Esim/Views/thankyou', [
            'iccid' => $iccid,
            'matchingId' => $matchingId,
            'smdpAddress' => $smdpAddress,
            'orderId' => $orderId,
        ]);
    }
}
