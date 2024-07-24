<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=env("app.sitename") ?> &gt; <?=$title_info->head_title ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/resource/vendor/fontawesome-free/css/all.min.css?ver=<?=env("app.cssVer") ?>">
    <link rel="stylesheet" href="/resource/usr/css/adminlte.min.css?ver=<?=env("app.cssVer") ?>">
    <link rel="stylesheet" href="/resource/community/css/community.css?ver=<?=env("app.cssVer") ?>">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <script src="/resource/vendor/jquery/jquery.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/usr/js/adminlte.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/community.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/community/js/postcode.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/resource/vendor/moment/moment.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/inputmask/jquery.inputmask.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="/resource/community/js/summernote-ko-KR.js"></script>
    <script src="/resource/community/js/summernote_setting.js?ver=<?=JS_VER ?>"></script>
</head>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-1YHY605LGJ"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-1YHY605LGJ');
</script>
