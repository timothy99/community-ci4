<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=env("app.sitename") ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"><!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="/resource/vendor/fontawesome-free/css/all.min.css?ver=<?=env("app.cssVer") ?>"><!-- Font Awesome -->
    <link rel="stylesheet" href="/resource/usr/css/adminlte.min.css?ver=<?=env("app.cssVer") ?>"><!-- Theme style -->

    <script src="/resource/vendor/jquery/jquery.min.js?ver=<?=env("app.jsVer") ?>"></script><!-- jQuery -->
    <script src="/resource/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=<?=env("app.jsVer") ?>"></script><!-- Bootstrap 4 -->
    <script src="/resource/usr/js/adminlte.min.js?ver=<?=env("app.jsVer") ?>"></script><!-- AdminLTE App -->

    <!-- User js-->
    <script src="/resource/community/js/community.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/postcode.js?ver=<?=env("app.jsVer") ?>"></script>

    <!-- InputMask -->
    <script src="/resource/vendor/moment/moment.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/inputmask/jquery.inputmask.min.js?ver=<?=env("app.jsVer") ?>"></script>
</head>

<body class="hold-transition login-page">