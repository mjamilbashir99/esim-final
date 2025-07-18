<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// core\app\Modules\Hotels\Controllers\HotelController.php

// $routes->get('check-rate', 'Modules\Hotels\Controllers\HotelController::checkRate');
$routes->group('/', ['namespace' => 'Modules\Hotels\Controllers'], function ($routes) {
   $routes->get('get-city-suggestions', 'HotelController::getCitySuggestions');
   $routes->get('search-hotels', 'HotelController::searchHotels');
   $routes->get('search-result', 'HotelController::searchResult');
   $routes->post('check-rate', 'HotelController::checkRate');
   // $routes->get('check-rate', 'HotelController::checkRate');


});

// $routes->get('get-city-suggestions', 'Modules\Hotels\Controllers\HotelController::getCitySuggestions');
// $routes->get('search-hotels', 'Modules\Hotels\Controllers\HotelController::searchHotels');

$routes->group('hotels', ['namespace' => 'Modules\Hotels\Controllers'], function ($routes) {
   //Auth
   $routes->get('/', 'AuthController::index');
   $routes->get('register', 'AuthController::register');
   $routes->get('/hotelBedsApi', 'AuthController::hotelBedsApi');
   $routes->post('hotel-api/1.0/hotels', 'AuthController::searchNearbyHotels');
   $routes->get('home', 'AuthController::index');
   $routes->post('register/submit', 'AuthController::submit');
   $routes->get('login', 'AuthController::login');
   $routes->post('login/submit', 'AuthController::loginSubmit');
   $routes->get('verify-otp', 'AuthController::verifyOtpView');
   $routes->post('verify-otp/submit', 'AuthController::verifyOtpSubmit');
   $routes->get('resend-otp', 'AuthController::resendOtp');
   $routes->post('set-redirect-url', 'AuthController::setRedirectUrl');
   $routes->get('is-logged-in', 'AuthController::isLoggedIn');
   $routes->get('logout', 'AuthController::logout');
   //Hotels
   // $routes->get('get-city-suggestions', 'HotelController::getCitySuggestions');
   // $routes->get('search-hotels', 'HotelController::searchHotels');
   // $routes->get('search-result', 'HotelController::searchResult');
   $routes->get('hotel-details/(:num)', 'HotelController::hotelDetails/$1');
   $routes->get('hotel-details', 'HotelController::fetchHotelData');

   $routes->post('/book-hotel', 'HotelController::bookHotel');
   $routes->post('book-room', 'HotelController::bookRoom');
   // $routes->get('book-room', 'HotelController::bookRoom');
   $routes->get('checkout', 'HotelController::checkout');
   //Dump
   $routes->get('hotel-dump', 'DumpController::getHotelsDump');
   $routes->get('hotel-destination-dump', 'DumpController::getHotelsDestinationsDump');
   $routes->get('hotel-countries-dump', 'DumpController::getHotelsCountriesDump');
   $routes->get('dump/cleanBlockedAmenitiesFromDB', 'DumpController::cleanBlockedAmenitiesFromDB');
   //Profile
   $routes->get('profile/edit', 'ProfileController::edit');
   $routes->post('profile/update', 'ProfileController::update');
});


$routes->group('admin', ['namespace' => 'Modules\Admin\Controllers'], function ($routes) {
   $routes->get('login', 'AuthController::login');
   $routes->post('login/submit', 'AuthController::loginSubmit');
   $routes->get('logout', 'AuthController::logout');
});


$routes->group('', ['namespace' => 'Modules\Esim\Controllers'], function ($routes) {
   $routes->get('/esim', 'EsimController::showBundles');
   $routes->get('esim/bundle/(:any)', 'EsimController::viewbundle/$1');

   $routes->post('cart/add', 'EsimController::addToCart');
   $routes->get('cart', 'EsimController::viewCart');
   $routes->post('cart/remove', 'EsimController::removeFromCart');
   $routes->get('cart/count', 'EsimController::cartCount');
   $routes->get('eSimcheckout', 'EsimController::checkout');
   $routes->get('order/thankyou', 'EsimController::thankYou');
   $routes->get('fetch-bundles', 'EsimController::showSingleBundlePerCountry');
   //All Destinations 
   $routes->get('destinations', 'EsimController::viewAllDestinations');
   $routes->get('destinations/(:any)', 'EsimController::viewAllDestinations/$1');
});

$routes->group('', ['namespace' => 'Modules\Esim\Controllers'], function ($routes) {
   // //Compatibility articles 
   $routes->get('compatibility/index', 'CompatibilityController::index');
   $routes->get('compatibility/apple', 'CompatibilityController::apple');
   $routes->get('compatibility/google', 'CompatibilityController::google');
   $routes->get('compatibility/samsung', 'CompatibilityController::samsung');
   $routes->get('compatibility/huawei', 'CompatibilityController::huawei');
   $routes->get('compatibility/laptop', 'CompatibilityController::laptop');
   $routes->get('compatibility/oppo', 'CompatibilityController::oppo');
   $routes->get('compatibility/other', 'CompatibilityController::other');
   $routes->get('compatibility/(:segment)', 'CompatibilityController::show/$1');
});

$routes->group('', ['namespace' => 'Modules\Esim\Controllers'], function ($routes) {
   //Support
   $routes->get('support', 'SupportController::index');
   $routes->get('support', 'SupportController::index');
   $routes->post('support/submit', 'SupportController::submit');
});





// // //All Destinations 
// // $routes->get('destinations', 'Api\EsimController::viewAllDestinations');
// // $routes->get('destinations/(:any)', 'Api\EsimController::viewAllDestinations/$1');

// // $routes->get('/', 'Api\EsimController::showBundles');
// // Registeration Form
// $routes->get('register', 'Auth\AuthController::register');
// $routes->get('/testDatabaseConnection', 'Home::testDatabaseConnection');
// $routes->get('/hotelBedsApi', 'Auth\AuthController::hotelBedsApi');

// $routes->post('hotel-api/1.0/hotels', 'Auth\AuthController::searchNearbyHotels');
// $routes->get('home', 'Auth\AuthController::index');

// //  $routes->get('get-city-suggestions', 'Home\HomeController::getCitySuggestions');

// //  $routes->post('search-hotels', 'Home\HomeController::searchHotels');

// //  $routes->get('search-result', 'Home\HomeController::searchResult');
// $routes->post('register/submit', 'Auth\AuthController::submit');

// $routes->get('login', 'Auth\AuthController::login');
// $routes->post('login/submit', 'Auth\AuthController::loginSubmit');

// //  $routes->get('hotel-details/(:num)', 'Home\HomeController::hotelDetails/$1');



// $routes->get('verify-otp', 'Auth\AuthController::verifyOtpView');
// $routes->post('verify-otp/submit', 'Auth\AuthController::verifyOtpSubmit');

// $routes->get('resend-otp', 'Auth\AuthController::resendOtp');

// //  $routes->get('hotel-details', 'Home\HomeController::fetchHotelData');
// $routes->get('preview-otp-template', 'Auth\AuthController::previewTemplate');
// $routes->get('preview-registration-template', 'Auth\AuthController::previewRegistrationEmail');

// //  $routes->post('/check-rate', 'Home\HomeController::checkRate');


// $routes->post('set-redirect-url', 'Auth\AuthController::setRedirectUrl');

//     $routes->get('is-logged-in', 'Auth\AuthController::isLoggedIn');

    

//     $routes->post('/book-hotel', 'Home\HomeController::bookHotel');
//    //  $routes->post('/book-room', 'Home\HomeController::bookRoom');

//    //  $routes->get('checkout', 'Home\HomeController::checkout');
//     $routes->get('logout', 'Auth\AuthController::logout');

//    //  Esim site 
//    $routes->get('api/info', 'Api\EsimController::getApiInfo');
//    // All bundles
//    $routes->get('api/bundles', 'Api\EsimController::getBundles');
//    // bundle by country
//    $routes->get('api/bundles/(:any)', 'Api\EsimController::getBundlesByCountry/$1');
//    // $routes->get('api/fetch-bundles', 'Api\EsimController::showSingleBundlePerCountry');
//    // pagination bundles
//    // $routes->get('api/pagination-bundles', 'Api\EsimController::getPaginatedBundles');
//    // show bundle details in view bundles_list.php
//    $routes->get('esim', 'Api\EsimController::showBundles');
//    // $routes->get('bundle/(:segment)', 'Api\EsimController::viewbundle/$1');

   
//    // $routes->get('bundle/(:any)', 'Api\EsimController::viewbundle/$1');



//    $routes->get('bundlesview/suggestions', 'Api\EsimController::getCountrySuggestions');
//    // $routes->post('cart/add', 'Api\EsimController::addToCart');
//    // $routes->get('cart', 'Api\EsimController::viewCart');
//    // $routes->post('cart/remove', 'Api\EsimController::removeFromCart');
//    // $routes->get('cart/count', 'Api\EsimController::cartCount');
//    // $routes->get('eSimcheckout', 'Api\EsimController::checkout');
//    // $routes->get('order/thankyou', 'Api\EsimController::thankYou');



// $routes->post('/book-hotel', 'Home\HomeController::bookHotel');
// //  $routes->post('/book-room', 'Home\HomeController::bookRoom');

// //  $routes->get('checkout', 'Home\HomeController::checkout');
// $routes->get('logout', 'Auth\AuthController::logout');

// //  Esim site 
// $routes->get('api/info', 'Api\EsimController::getApiInfo');
// // All bundles
// $routes->get('api/bundles', 'Api\EsimController::getBundles');
// // bundle by country
// $routes->get('api/bundles/(:any)', 'Api\EsimController::getBundlesByCountry/$1');
// // $routes->get('api/fetch-bundles', 'Api\EsimController::showSingleBundlePerCountry');
// // pagination bundles
// // $routes->get('api/pagination-bundles', 'Api\EsimController::getPaginatedBundles');
// // show bundle details in view bundles_list.php
// $routes->get('esim', 'Api\EsimController::showBundles');
// // $routes->get('bundle/(:segment)', 'Api\EsimController::viewbundle/$1');
// // $routes->get('bundle/(:any)', 'Api\EsimController::viewbundle/$1');
// $routes->get('bundlesview/suggestions', 'Api\EsimController::getCountrySuggestions');
// // $routes->post('cart/add', 'Api\EsimController::addToCart');
// // $routes->get('cart', 'Api\EsimController::viewCart');
// // $routes->post('cart/remove', 'Api\EsimController::removeFromCart');
// // $routes->get('cart/count', 'Api\EsimController::cartCount');
// // $routes->get('eSimcheckout', 'Api\EsimController::checkout');


// $routes->post('purchase', 'Api\EsimController::book');
// $routes->post('payment/process', 'Api\PaymentController::process');
// $routes->get('getEsims', 'Api\EsimController::getEsims');

// $routes->get('profile/edit', 'Api\EsimController::viewProfile');
// $routes->post('profile/update', 'Api\EsimController::updateProfile');
// $routes->get('currency/set', 'Api\EsimController::set');
// $routes->get('search-countries', 'Api\EsimController::getCountryNetworks');






// // Admin routes
// $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
//    $routes->get('login', 'AuthController::login');
//    $routes->post('login/submit', 'AuthController::loginSubmit');
//    $routes->get('logout', 'AuthController::logout');

//    // Protected admin routes
//    $routes->group('', ['filter' => 'adminauth'], function ($routes) {
//       $routes->get('dashboard', 'AdminController::index');
//       $routes->get('all-users', 'AdminController::listUsers');
//       $routes->get('all-bookings', 'AdminController::listBookings');
//       $routes->get('hotels', 'AdminController::hotels'); // This is the correct route for the hotels page
//       $routes->post('save-hotel', 'AdminController::saveHotel');
//       $routes->get('delete-user/(:num)', 'AdminController::deleteUser/$1');
//       $routes->post('delete-hotel', 'AdminController::deleteHotel');
//       $routes->post('update-user', 'AdminController::updateUser');
//       $routes->post('update-hotel', 'AdminController::updatehotel');

//       // Email Templates
//       $routes->get('email-templates', 'EmailTemplates::index');
//       $routes->get('email-templates/create', 'EmailTemplates::create'); // Add this line
//       $routes->post('email-templates/store', 'EmailTemplates::store');  // Add this line
//       $routes->get('email-templates/edit/(:num)', 'EmailTemplates::edit/$1');
//       $routes->post('email-templates/update/(:num)', 'EmailTemplates::update/$1');
//       $routes->get('email-templates/delete/(:num)', 'EmailTemplates::delete/$1');
//    });
// });
