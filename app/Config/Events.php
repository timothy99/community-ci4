<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;
use App\Models\Common\AuthorityModel; // 권한관리 모델

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the "on()" method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on("create", [$myInstance, "myMethod"]);
 */

Events::on("pre_system", static function () {
    if (ENVIRONMENT !== "testing") {
        if (ini_get("zlib.output_compression")) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on("DBQuery", "CodeIgniter\Debug\Toolbar\Collectors\Database::collect");
        Services::toolbar()->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === "development") {
            Services::routes()->get("__hot-reload", static function () {
                (new HotReloader())->run();
            });
        }
    }
});

/*
    사용자 추가 이벤트
    1. 세션을 찾아서 세션에 언어 설정이 없으면 한국어로 기본 설정해서 데이터 넣기
*/
Events::on("post_controller_constructor", function () {
    $authority_model = new AuthorityModel();

    getUserSession() ?? setBaseSession(); // 사용자 세션이 없다면 기본 세션 생성

    $previous_url = previous_url();
    if($previous_url != base_url()."/user/login") { // 이전페이지가 로그인 페이지면 입력하지 않는다.
        setUserSessionInfo("user_referer", $previous_url); // 이전 url
    }

    $request = \Config\Services::request();

    // 현재 사용자가 보고 있는 화면 url
    $site_url = site_url();
    $request_uri = $request->getServer("REQUEST_URI");
    $full_url = $site_url.$request_uri;
    $full_url = str_replace("//", "/", $full_url);
    $full_url = str_replace(":/", "://", $full_url);
    setUserSessionInfo("full_url", $full_url); // 이전 url

    $segments = $request->getUri()->getSegments(); // segments 확인
    $authority_model->checkAuthority($segments);
});

// CI에서 기본적 DB이벤트(select등 모두 포함)가 발생되었을때의 로깅
Events::on("DBQuery", function () {
    logModifyQuery(); // 쿼리 로깅
});