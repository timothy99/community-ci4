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
$routes->get("/member/myinfo", "Usr\Member::myinfo");
$routes->get("/member/login", "Usr\Member::login");
$routes->get("/member/join", "Usr\Member::join");
$routes->get("/member/forgot", "Usr\Member::forgot");
$routes->post("/member/signup", "Usr\Member::signup");
$routes->post("/member/signin", "Usr\Member::signin");
$routes->get("/member/logout", "Usr\Member::logout");
$routes->get("/board", "Usr\Board::index");
$routes->get("/board/(:alpha)/list", "Usr\Board::list");

$routes->get("/csl", "Csl\Dashboard::index");
$routes->get("/csl/dashboard", "Csl\Dashboard::index");
$routes->get("/csl/dashboard/main", "Csl\Dashboard::main");

$routes->get("/csl/member", "Csl\Member::index");
$routes->get("/csl/member/list", "Csl\Member::list");
$routes->get("/csl/member/view/(:alphanum)", "Csl\Member::view");
$routes->get("/csl/member/edit/(:alphanum)", "Csl\Member::edit");
$routes->post("/csl/member/update", "Csl\Member::update");
$routes->post("/csl/member/delete/(:alphanum)", "Csl\Member::delete");

$routes->get("/csl/board/(:alpha)/list", "Csl\Board::list");
$routes->get("/csl/board/(:alpha)/write", "Csl\Board::write");
$routes->get("/csl/board/(:alpha)/edit/(:num)", "Csl\Board::edit");
$routes->post("/csl/board/(:alpha)/update", "Csl\Board::update");
$routes->get("/csl/board/(:alpha)/view/(:num)", "Csl\Board::view");
$routes->post("/csl/board/(:alpha)/delete/(:num)", "Csl\Board::delete");

$routes->post("/csl/file/upload", "Csl\File::upload");
$routes->post("/csl/file/list", "Csl\File::list");
$routes->get("/csl/file/view/(:alphanum)", "Csl\File::view");
$routes->get("/csl/file/download/(:alphanum)", "Csl\File::download");
