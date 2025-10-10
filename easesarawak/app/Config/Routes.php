<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/policy', 'Home::policy');
$routes->get('/terms-and-conditions', 'Home::tnc');


$routes->get('/admin', 'Admin::index');
$routes->get('/report', 'Admin::report');
$routes->get('/order', 'Admin::order');
$routes->get('/change_status/(:num)', 'Admin::change_status/$1');
$routes->get('/user', 'Admin::user');
$routes->match(['get', 'post'], '/create_user', 'Admin::create_user');
$routes->get('/order/getDetails/(:num)', 'admin::getDetails/$1');
