<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", "Usr\Home::index");

$routes->get("/home", "Usr\Home::index");
$routes->get("/home/main", "Usr\Home::main");

$routes->get("/menu", "Usr\Menu::index");
$routes->get("/menu/menu1", "Usr\Menu::menu1");
$routes->get("/menu/menu2", "Usr\Menu::menu2");

$routes->get("/board", "Usr\Board::index");
$routes->get("/board/(:any)/list", "Usr\Board::list");
$routes->get("/board/(:any)/view/(:num)", "Usr\Board::view");
$routes->get("/board/(:any)/write", "Usr\Board::write");
$routes->get("/board/(:any)/edit/(:num)", "Usr\Board::edit");
$routes->post("/board/(:any)/update", "Usr\Board::update");
$routes->post("/board/(:any)/delete/(:num)", "Usr\Board::delete");

$routes->post("/upload/general", "Usr\Upload::general");
$routes->post("/upload/board", "Usr\Upload::board");
$routes->post("/upload/image", "Usr\Upload::image");
$routes->post("/upload/original", "Usr\Upload::original");

$routes->get("/download/view", "Usr\Download::view");
$routes->get("/download/view/(:alphanum)", "Usr\Download::view");
$routes->get("/download/download/(:alphanum)", "Usr\Download::download");

$routes->get("/contents/view/(:num)", "Usr\Contents::view");

$routes->post("/popup/disabled/(:num)/(:num)", "Usr\Popup::disabled");

$routes->post("/ask/write", "Usr\Ask::write");

$routes->get("/s/(:num)", "Usr\Shortlink::hyperlink");

$routes->get("/member/login", "Lgn\Member::login");
$routes->get("/member/join", "Lgn\Member::join");
$routes->post("/member/signup", "Lgn\Member::signup");
$routes->post("/member/signin", "Lgn\Member::signin");
$routes->get("/member/logout", "Lgn\Member::logout");
$routes->post("/member/duplicate", "Lgn\Member::duplicate");
$routes->get("/member/view", "Lgn\Member::view");
$routes->get("/member/edit", "Lgn\Member::edit");
$routes->post("/member/update", "Lgn\Member::update");
$routes->get("/member/leave", "Lgn\Member::leave");
$routes->post("/member/delete", "Lgn\Member::delete");

$routes->get("/password/find", "Lgn\Password::find");
$routes->post("/password/send", "Lgn\Password::send");
$routes->get("/password/forgot", "Lgn\Password::forgot");
$routes->post("/password/password", "Lgn\Password::password");
$routes->get("/password/reset/(:any)", "Lgn\Password::reset");
$routes->post("/password/update", "Lgn\Password::update");
$routes->get("/password/confirm", "Lgn\Password::confirm");
$routes->post("/password/search", "Lgn\Password::search");
$routes->get("/password/modify", "Lgn\Password::modify");
$routes->post("/password/change", "Lgn\Password::change");

$routes->get("/csl", "Csl\Slide::index");

$routes->get("/csl/member", "Csl\Member::index");
$routes->get("/csl/member/list", "Csl\Member::list");
$routes->get("/csl/member/view/(:alphanum)", "Csl\Member::view");
$routes->get("/csl/member/edit/(:alphanum)", "Csl\Member::edit");
$routes->post("/csl/member/update", "Csl\Member::update");
$routes->post("/csl/member/delete/(:alphanum)", "Csl\Member::delete");
$routes->get("/csl/member/excel", "Csl\Member::excel");
$routes->get("/csl/member/password/(:alphanum)", "Csl\Member::password");
$routes->post("/csl/member/change", "Csl\Member::change");

$routes->get("/csl/board", "Csl\Board::index");
$routes->get("/csl/board/config", "Csl\BoardConfig::index");

$routes->get("/csl/board/config/list", "Csl\BoardConfig::list");
$routes->get("/csl/board/config/write", "Csl\BoardConfig::write");
$routes->get("/csl/board/config/edit/(:num)", "Csl\BoardConfig::edit");
$routes->post("/csl/board/config/update", "Csl\BoardConfig::update");
$routes->get("/csl/board/config/view/(:num)", "Csl\BoardConfig::view");
$routes->post("/csl/board/config/delete/(:num)", "Csl\BoardConfig::delete");

$routes->get("/csl/board/manage", "Csl\BoardManage::index");
$routes->get("/csl/board/manage/list", "Csl\BoardManage::list");

$routes->get("/csl/board/(:any)/list", "Csl\Board::list");
$routes->get("/csl/board/(:any)/write", "Csl\Board::write");
$routes->get("/csl/board/(:any)/edit/(:num)", "Csl\Board::edit");
$routes->post("/csl/board/(:any)/update", "Csl\Board::update");
$routes->get("/csl/board/(:any)/view/(:num)", "Csl\Board::view");
$routes->post("/csl/board/(:any)/delete/(:num)", "Csl\Board::delete");

$routes->get("/csl/comment", "Csl\Comment::index");
$routes->post("/csl/comment/insert", "Csl\Comment::insert");
$routes->post("/csl/comment/delete/(:num)", "Csl\Comment::delete");
$routes->post("/csl/comment/edit/(:num)", "Csl\Comment::edit");
$routes->post("/csl/comment/update", "Csl\Comment::update");

$routes->post("/comment/insert", "Usr\Comment::insert");
$routes->post("/comment/delete/(:num)", "Usr\Comment::delete");
$routes->post("/comment/edit/(:num)", "Usr\Comment::edit");
$routes->post("/comment/update", "Usr\Comment::update");

$routes->get("/csl/slide/list", "Csl\Slide::list");
$routes->get("/csl/slide/write", "Csl\Slide::write");
$routes->get("/csl/slide/edit/(:num)", "Csl\Slide::edit");
$routes->post("/csl/slide/update", "Csl\Slide::update");
$routes->get("/csl/slide/view/(:num)", "Csl\Slide::view");
$routes->post("/csl/slide/delete/(:num)", "Csl\Slide::delete");

$routes->get("/csl/contents", "Csl\Contents::index");
$routes->get("/csl/contents/list", "Csl\Contents::list");
$routes->get("/csl/contents/write", "Csl\Contents::write");
$routes->get("/csl/contents/edit/(:num)", "Csl\Contents::edit");
$routes->post("/csl/contents/update", "Csl\Contents::update");
$routes->get("/csl/contents/view/(:num)", "Csl\Contents::view");
$routes->post("/csl/contents/delete/(:num)", "Csl\Contents::delete");

$routes->post("/mail/send", "Usr\Mail::send");

$routes->get("/csl/bulk", "Csl\Bulk::index");
$routes->get("/csl/bulk/list", "Csl\Bulk::list");
$routes->get("/csl/bulk/excel/write", "Csl\Bulk::excelWrite");
$routes->post("/csl/bulk/excel/upload", "Csl\Bulk::excelUpload");
$routes->get("/csl/bulk/detail/(:num)", "Csl\Bulk::detail");
$routes->get("/csl/bulk/view/(:num)", "Csl\Bulk::view");
$routes->get("/csl/bulk/edit/(:num)", "Csl\Bulk::edit");
$routes->post("/csl/bulk/update", "Csl\Bulk::update");
$routes->post("/csl/bulk/delete/(:num)/(:num)", "Csl\Bulk::delete");

$routes->get("/csl/menu", "Csl\Menu::index");
$routes->get("/csl/menu/list", "Csl\Menu::list");
$routes->get("/csl/menu/write/(:num)", "Csl\Menu::write");
$routes->get("/csl/menu/edit/(:num)", "Csl\Menu::edit");
$routes->post("/csl/menu/update", "Csl\Menu::update");
$routes->get("/csl/menu/view/(:num)", "Csl\Menu::view");
$routes->post("/csl/menu/delete/(:num)", "Csl\Menu::delete");

$routes->get("/csl/popup", "Csl\Popup::index");
$routes->get("/csl/popup/list", "Csl\Popup::list");
$routes->get("/csl/popup/write", "Csl\Popup::write");
$routes->get("/csl/popup/edit/(:num)", "Csl\Popup::edit");
$routes->post("/csl/popup/update", "Csl\Popup::update");
$routes->get("/csl/popup/view/(:num)", "Csl\Popup::view");
$routes->post("/csl/popup/delete/(:num)", "Csl\Popup::delete");

$routes->get("/csl/ask/list", "Csl\Ask::list");
$routes->post("/csl/ask/delete/(:num)", "Csl\Ask::delete");

$routes->get("/csl/shortlink/list", "Csl\Shortlink::list");
$routes->get("/csl/shortlink/write", "Csl\Shortlink::write");
$routes->get("/csl/shortlink/edit/(:num)", "Csl\Shortlink::edit");
$routes->post("/csl/shortlink/update", "Csl\Shortlink::update");
$routes->get("/csl/shortlink/view/(:num)", "Csl\Shortlink::view");
$routes->post("/csl/shortlink/delete/(:num)", "Csl\Shortlink::delete");

$routes->get("/csl/privacy", "Csl\Privacy::index");
$routes->get("/csl/privacy/list", "Csl\Privacy::list");

$routes->get("/csl/youtube", "Csl\Youtube::index");
$routes->get("/csl/youtube/list", "Csl\Youtube::list");
$routes->get("/csl/youtube/write", "Csl\Youtube::write");
$routes->get("/csl/youtube/edit/(:num)", "Csl\Youtube::edit");
$routes->post("/csl/youtube/update", "Csl\Youtube::update");
$routes->get("/csl/youtube/view/(:num)", "Csl\Youtube::view");
$routes->post("/csl/youtube/delete/(:num)", "Csl\Youtube::delete");
$routes->get("/csl/youtube/search", "Csl\Youtube::search");

$routes->get("/csl/calendar/list", "Csl\Calendar::list");
$routes->post("/csl/calendar/month", "Csl\Calendar::month"); // 그 달의 스케쥴 불러오기
$routes->get("/csl/calendar/write", "Csl\Calendar::write");
$routes->post("/csl/calendar/update", "Csl\Calendar::update");
$routes->get("/csl/calendar/view", "Csl\Calendar::view");
$routes->get("/csl/calendar/edit", "Csl\Calendar::edit");
$routes->post("/csl/calendar/delete/(:num)", "Csl\Calendar::delete");

// 테이블명세서 생성하기
$routes->get("/csl/table/write", "Csl\Table::write");
$routes->post("/csl/table/view", "Csl\Table::view");
