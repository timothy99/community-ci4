<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", "Usr\Home::index");
$routes->get("/home", "Usr\Home::index");
$routes->get("/home/home", "Usr\Home::home");
$routes->get("/menu", "Usr\Menu::index");
$routes->get("/menu/menu1", "Usr\Menu::menu1");
$routes->get("/menu/menu2", "Usr\Menu::menu2");
