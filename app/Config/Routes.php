<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", "Usr\Home::index");
$routes->get("/home", "Usr\Home::index");
$routes->get("/home/home", "Usr\Home::home");
