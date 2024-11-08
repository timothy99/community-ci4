<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=env("app.sitename") ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/resource/vendor/fontawesome-free/css/all.min.css?ver=<?=env("app.cssVer") ?>">
    <link rel="stylesheet" href="/resource/csl/css/adminlte.min.css?ver=<?=env("app.cssVer") ?>">
    <link rel="stylesheet" href="/resource/community/css/community.css?ver=<?=env("app.cssVer") ?>">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet"><!-- 썸머노트 CSS -->
    <link rel="stylesheet" href="/resource/vendor/fullcalendar/main.css?ver=<?=env("app.cssVer") ?>"><!-- fullcalendar -->

    <script src="/resource/vendor/jquery/jquery.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/csl/js/adminlte.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/community.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/postcode.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/resource/vendor/moment/moment.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/inputmask/jquery.inputmask.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script><!-- 썸머노트 라이트 -->
    <script src="/resource/community/js/summernote-ko-KR.js?ver=<?=env("app.jsVer") ?>"></script><!-- 썸머노트 한국어 -->
    <script src="/resource/community/js/summernote_setting.js?ver=<?=env("app.jsVer") ?>"></script><!-- 썸머노트 설정 -->
    <script src="/resource/vendor/fullcalendar/main.js?ver=<?=env("app.jsVer") ?>"></script><!-- fullCalendar 2.2.5 -->
    <script src="/resource/vendor/fullcalendar/locales/ko.js?ver=<?=env("app.jsVer") ?>"></script><!-- fullCalendar 한국어 -->
</head>
