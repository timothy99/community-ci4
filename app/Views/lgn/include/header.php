<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=env("app.sitename") ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/resource/vendor/fontawesome-free/css/all.min.css?ver=<?=env("app.cssVer") ?>">
    <link rel="stylesheet" href="/resource/lgn/css/adminlte.min.css?ver=<?=env("app.cssVer") ?>">
    <link rel="stylesheet" href="/resource/community/css/community.css?ver=<?=env("app.cssVer") ?>">

    <script src="/resource/vendor/jquery/jquery.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/lgn/js/adminlte.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/community.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/postcode.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/resource/vendor/moment/moment.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/inputmask/jquery.inputmask.min.js?ver=<?=env("app.jsVer") ?>"></script>
</head>

<body class="hold-transition login-page">
