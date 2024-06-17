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
    <script src="/resource/usr/js/community.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/usr/js/postcode.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

    <!-- InputMask -->
    <script src="/resource/vendor/moment/moment.min.js?ver=<?=env("app.jsVer") ?>"></script>
    <script src="/resource/vendor/inputmask/jquery.inputmask.min.js?ver=<?=env("app.jsVer") ?>"></script>
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width:500px">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1>회원가입</h1>
        </div>
        <div class="card-body">
            <p class="login-box-msg">기본정보</p>
            <form id="frm" name="frm">
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        아이디
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control ml-3" id="member_id" name="member_id">
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary mr-3" id="duplicate" name="duplicate">중복확인</button>
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        암호
                    </div>
                    <div class="col-sm-9">
                        <input type="password" class="form-control ml-3" id="member_password" name="member_password">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        암호 확인
                    </div>
                    <div class="col-sm-9">
                        <input type="password" class="form-control ml-3" id="member_password_confirm" name="member_password_confirm">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        이름
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ml-3" id="member_name" name="member_name">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        별명
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ml-3" id="member_nickname" name="member_nickname">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        이메일
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ml-3" id="email" name="email">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        전화
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ml-3" id="phone" name="phone">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        우편번호
                    </div>
                    <div class="col-sm-9 d-flex">
                        <input type="text" class="form-control ml-3" id="post_code" name="post_code" placeholder="우편번호" readonly>
                        <button type="button" class="btn btn-info btn-user btn-block ml-3" onclick="postcode_open()">검색</button>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="postcode_close()" alt="접기 버튼">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        주소1
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ml-3" id="addr1" name="addr1">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        주소2
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control ml-3" id="addr2" name="addr2">
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-primary mr-3" id="signup" name="signup">가입하기</button>
                    <button type="button" class="btn btn-danger" id="cancel" name="cancel">취소하기</button>
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->
</body>
</html>

<script>
    $(window).on("load", function() {
        $("#email").inputmask({ alias: "email"});
        $("#phone").inputmask("999-9999-9999", { "placeholder": "000-0000-0000" });
    });

    $(function() {
        $("#signup").click(function() {
            ajax1("/member/signup", "frm");
        });

        $("#cancel").click(function() {
            location.href="/";
        });

        $("#duplicate").click(function() {
            ajax6("/member/duplicate", "frm");
        });
    });

    // 우편번호 검색된 결과값으로 페이지에 맞는 데이터 넣기
    function postcode_after(data) {
        // 우편번호와 주소 정보를 해당 필드에 넣는다.
        document.getElementById("post_code").value = data.zonecode;
        document.getElementById("addr1").value = data.addr1;
        document.getElementById("addr2").value = data.addr2;
        // 커서를 상세주소 필드로 이동한다.
        document.getElementById("addr2").focus();
    }
</script>