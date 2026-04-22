<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('comments/list', 'Home::list');
$routes->post('comments', 'Home::create');
$routes->post('comments/(:num)/delete', 'Home::delete/$1');
