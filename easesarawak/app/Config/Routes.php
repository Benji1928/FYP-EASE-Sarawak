<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Intro-Landing Page routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/policy', 'Home::policy');
$routes->get('/terms-and-conditions', 'Home::tnc');
$routes->get('/booking', 'Home::booking');
$routes->get('/bookingdetail', 'Home::bookingdetail');
$routes->get('/bookingcustomerdetail', 'Home::bookingcustomerdetail');
$routes->post('/saveOrder', 'Home::saveOrder');
$routes->get('/booking-confirmation', 'Home::bookingConfirmation');
$routes->post('/checkPromoCode', 'Home::checkPromoCode');

// Login routes
$routes->get('/login', 'Login::index');
$routes->post('/login_submit', 'Login::submit');
$routes->get('/logout', 'Login::logout');

// Admin Portal routes
$routes->get('/admin', 'Admin::index');
$routes->get('/report', 'Admin::report');
$routes->get('/order', 'Admin::order');
$routes->get('/change_status/(:num)', 'Admin::change_status/$1');
$routes->get('/user', 'Admin::user');
$routes->match(['get', 'post'], '/create_user', 'Admin::create_user');
$routes->get('/order/getDetails/(:num)', 'Admin::getDetails/$1');
$routes->post('/save_note', 'Admin::save_note');
$routes->get('/admin/getRevenueData', 'Admin::getRevenueData');

// Admin Data Export Routes
$routes->get('/admin/export-revenue', 'Admin::exportRevenue');

// Admin Dashboard
$routes->get('/admin/dashboard', 'AdminDashboard::index');

// Admin Users Management
$routes->group('admin/users', function ($routes) {
    $routes->get('/', 'AdminUsers::index');
    $routes->get('view/(:num)', 'AdminUsers::view/$1');
    $routes->get('search', 'AdminUsers::search');
});

// Admin Partners Management
$routes->group('admin/partners', function ($routes) {
    $routes->get('/', 'AdminPartners::index');
    $routes->get('create', 'AdminPartners::create');
    $routes->post('store', 'AdminPartners::store');
    $routes->get('edit/(:num)', 'AdminPartners::edit/$1');
    $routes->post('update/(:num)', 'AdminPartners::update/$1');
    $routes->get('delete/(:num)', 'AdminPartners::delete/$1');
    $routes->get('performance/(:num)', 'AdminPartners::performance/$1');
});

// Admin Locations Management
$routes->group('admin/locations', function ($routes) {
    $routes->get('/', 'AdminLocations::index');
    $routes->get('create', 'AdminLocations::create');
    $routes->post('store', 'AdminLocations::store');
    $routes->get('edit/(:num)', 'AdminLocations::edit/$1');
    $routes->post('update/(:num)', 'AdminLocations::update/$1');
    $routes->get('delete/(:num)', 'AdminLocations::delete/$1');
    $routes->get('storage/(:num)', 'AdminLocations::storage/$1');
});

// Admin Promo Codes Management
$routes->group('admin/promo', function ($routes) {
    $routes->get('/', 'AdminPromo::index');
    $routes->get('create', 'AdminPromo::create');
    $routes->post('store', 'AdminPromo::store');
    $routes->get('edit/(:segment)', 'AdminPromo::edit/$1');
    $routes->post('update/(:segment)', 'AdminPromo::update/$1');
    $routes->get('delete/(:segment)', 'AdminPromo::delete/$1');
});

// Admin Orders Management
$routes->group('admin/orders', function ($routes) {
    $routes->get('/', 'AdminOrders::index');
    $routes->get('view/(:num)', 'AdminOrders::view/$1');
    $routes->post('update-status/(:num)', 'AdminOrders::updateStatus/$1');
});

// Admin Analytics
$routes->group('admin/analytics', function ($routes) {
    $routes->get('revenue', 'AdminAnalytics::revenue');
    $routes->get('customers', 'AdminAnalytics::customers');
    $routes->get('operations', 'AdminAnalytics::operations');
    $routes->get('external-data', 'AdminAnalytics::externalData');
});