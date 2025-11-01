<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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