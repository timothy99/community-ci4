<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=env("app.sitename") ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"><!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="/resource/vendor/fontawesome-free/css/all.min.css?ver=<?=env("app.cssVer") ?>"><!-- Font Awesome -->
    <link rel="stylesheet" href="/resource/csl/css/adminlte.min.css?ver=<?=env("app.cssVer") ?>"><!-- Theme style -->

    <script src="/resource/vendor/jquery/jquery.min.js?ver=<?=env("app.jsVer") ?>"></script><!-- jQuery -->
    <script src="/resource/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=<?=env("app.jsVer") ?>"></script><!-- Bootstrap 4 -->
    <script src="/resource/csl/js/adminlte.min.js?ver=<?=env("app.jsVer") ?>"></script><!-- AdminLTE App -->

    <!-- User js-->
    <script src="/resource/common/js/community.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/common/js/postcode.js?ver=<?=env("app.jsVer") ?>"></script>

    <!-- InputMask -->
    <script src="/resource/vendor/moment/moment.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/inputmask/jquery.inputmask.min.js?ver=<?=env("app.jsVer") ?>"></script>

    <!-- summernote -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="/resource/common/js/summernote-ko-KR.js"></script>
    <script src="/resource/common/js/summernote_setting.js?ver=<?=JS_VER ?>"></script><!-- summernote 사용자 설정 -->
</head>