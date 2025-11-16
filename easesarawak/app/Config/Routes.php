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

// ========================================
// ADMIN PORTAL ROUTES
// ========================================

// Main Admin Dashboard
$routes->get('/admin', 'AdminDashboard::index');
$routes->get('/admin/dashboard', 'AdminDashboard::index');

// Dashboard Sections
$routes->group('admin/dashboard', function ($routes) {
    $routes->get('overview', 'AdminDashboard::overview');
    $routes->get('orders', 'AdminDashboard::orders');
    $routes->get('customers', 'AdminDashboard::customers');
    $routes->get('operations', 'AdminDashboard::operations');
});

// ========================================
// ORDERS MANAGEMENT
// ========================================
$routes->group('admin/orders', function ($routes) {
    $routes->get('/', 'AdminOrders::index');
    $routes->get('view/(:num)', 'AdminOrders::view/$1');
    $routes->post('update-status/(:num)', 'AdminOrders::updateStatus/$1');
});

// ========================================
// USERS/CUSTOMERS MANAGEMENT
// ========================================
$routes->group('admin/users', function ($routes) {
    $routes->get('/', 'AdminUsers::index');
    $routes->get('view/(:num)', 'AdminUsers::view/$1');
    $routes->get('search', 'AdminUsers::search');
});

// ========================================
// STAFF MANAGEMENT (Legacy - from Admin controller)
// ========================================
$routes->group('admin/staff', function ($routes) {
    $routes->get('/', 'Admin::user');
    $routes->match(['get', 'post'], 'create', 'Admin::create_user');
    $routes->get('edit/(:num)', 'Admin::edit_user/$1');
});

// ========================================
// PARTNERS MANAGEMENT
// ========================================
$routes->group('admin/partners', function ($routes) {
    $routes->get('/', 'AdminPartners::index');
    $routes->get('create', 'AdminPartners::create');
    $routes->post('store', 'AdminPartners::store');
    $routes->get('edit/(:num)', 'AdminPartners::edit/$1');
    $routes->post('update/(:num)', 'AdminPartners::update/$1');
    $routes->get('delete/(:num)', 'AdminPartners::delete/$1');
    $routes->get('performance/(:num)', 'AdminPartners::performance/$1');
});

// ========================================
// LOCATIONS MANAGEMENT
// ========================================
$routes->group('admin/locations', function ($routes) {
    $routes->get('/', 'AdminLocations::index');
    $routes->get('create', 'AdminLocations::create');
    $routes->post('store', 'AdminLocations::store');
    $routes->get('edit/(:num)', 'AdminLocations::edit/$1');
    $routes->post('update/(:num)', 'AdminLocations::update/$1');
    $routes->get('delete/(:num)', 'AdminLocations::delete/$1');
    $routes->get('storage/(:num)', 'AdminLocations::storage/$1');
});

// ========================================
// PROMO CODES MANAGEMENT
// ========================================
$routes->group('admin/promo', function ($routes) {
    $routes->get('/', 'AdminPromo::index');
    $routes->get('create', 'AdminPromo::create');
    $routes->post('store', 'AdminPromo::store');
    $routes->get('edit/(:segment)', 'AdminPromo::edit/$1');
    $routes->post('update/(:segment)', 'AdminPromo::update/$1');
    $routes->get('delete/(:segment)', 'AdminPromo::delete/$1');
});

// ========================================
// ANALYTICS & REPORTS
// ========================================
$routes->group('admin/analytics', function ($routes) {
    $routes->get('/', 'Admin::report');
    $routes->get('revenue', 'AdminAnalytics::revenue');
    $routes->get('customers', 'AdminAnalytics::customers');
    $routes->get('operations', 'AdminAnalytics::operations');
    $routes->get('external-data', 'AdminAnalytics::externalData');
});

// ========================================
// AJAX ENDPOINTS & API
// ========================================
$routes->group('admin/api', function ($routes) {
    // Order AJAX endpoints
    $routes->get('order/details/(:num)', 'Admin::getDetails/$1');
    $routes->post('order/save-note', 'Admin::save_note');

    // Revenue data for charts
    $routes->get('revenue-data', 'Admin::getRevenueData');
});

// ========================================
// DATA EXPORTS
// ========================================
$routes->group('admin/export', function ($routes) {
    $routes->get('revenue', 'Admin::exportRevenue');
});

// ========================================
// LEGACY ROUTES (Backwards Compatibility)
// TODO: Remove these after updating all navigation links
// ========================================
$routes->get('/report', 'Admin::report');
$routes->get('/order', 'AdminOrders::index');
$routes->get('/user', 'Admin::user');
$routes->get('/admin/report', 'Admin::report');
$routes->get('/admin/order', 'AdminOrders::index');
$routes->get('/admin/user', 'Admin::user');
$routes->get('/admin/change_status/(:num)', 'Admin::change_status/$1');
$routes->get('/change_status/(:num)', 'Admin::change_status/$1');
$routes->match(['get', 'post'], '/admin/create_user', 'Admin::create_user');
$routes->match(['get', 'post'], '/create_user', 'Admin::create_user');
$routes->get('/admin/order/getDetails/(:num)', 'Admin::getDetails/$1');
$routes->get('/order/getDetails/(:num)', 'Admin::getDetails/$1');
$routes->post('/admin/save_note', 'Admin::save_note');
$routes->post('/save_note', 'Admin::save_note');
$routes->get('/admin/getRevenueData', 'Admin::getRevenueData');
$routes->get('/admin/export-revenue', 'Admin::exportRevenue');