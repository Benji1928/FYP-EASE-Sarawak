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
$routes->get('/admin/promo_code', 'PromoCodeController::index');
$routes->get('/admin/promo_code/create', 'PromoCodeController::create');
$routes->post('/admin/promo_code/store', 'PromoCodeController::store');
$routes->get('/admin/promo_code/edit/(:num)', 'PromoCodeController::edit/$1');
$routes->post('/admin/promo_code/update/(:num)', 'PromoCodeController::update/$1');
$routes->get('/admin/promo_code/delete/(:num)', 'PromoCodeController::delete/$1');
$routes->get('/admin/content_management', 'ContentManagementController::index');
$routes->post('/admin/content_management/store', 'ContentManagementController::store');
$routes->post('/admin/content_management/set_active/(:num)', 'ContentManagementController::set_active/$1');
$routes->post('/admin/content_management/delete/(:num)', 'ContentManagementController::delete/$1');
$routes->post('/admin/content_management/set_inactive/(:num)', 'ContentManagementController::set_inactive/$1');
$routes->get('/admin/service_management', 'Admin::service_management');
$routes->post('/admin/service_management/update/(:num)', 'Admin::update_service_price/$1');