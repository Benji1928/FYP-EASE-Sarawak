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
$routes->get('/edit_user/(:num)', 'Admin::edit/$1');
$routes->post('/update_user/(:num)', 'Admin::update/$1');
$routes->get('/delete_user/(:num)', 'Admin::delete/$1');