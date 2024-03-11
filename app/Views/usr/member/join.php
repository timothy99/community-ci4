<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=env("app.sitename") ?> > 회원가입</title>

    <!-- Custom fonts for this template-->
    <link href="/resource/usr/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/resource/usr/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="/resource/usr/vendor/jquery/jquery.min.js"></script>
    <script src="/resource/usr/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/resource/usr/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/resource/usr/js/sb-admin-2.min.js"></script>

    <!-- User Javascript -->
<?php   if ($uri == "/member/join") { // 회원가입일때 우편번호 검색 스크립트 로딩 ?>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/resource/usr/js/postcode.js"></script>
<?php   } ?>
    <script src="/resource/usr/js/ajax.js"></script>

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">회원가입</h1>
                                    </div>
                                    <form id="frm" name="frm" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_id" name="member_id" placeholder="아이디">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user" id="member_password" name="member_password" placeholder="암호">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user" id="member_password_confirm" name="member_password_confirm" placeholder="암호 재입력">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_name" name="member_name" placeholder="이름">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_nickname" name="member_nickname" placeholder="별명">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="phone" name="phone" placeholder="전화번호">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="이메일주소">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="post_code" name="post_code" placeholder="우편번호" readonly>
                                            </div>
                                            <div class="col-sm-6">
                                                <button type="button" class="btn btn-info btn-user btn-block" onclick="postcode_open()">검색</button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
                                                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="postcode_close()" alt="접기 버튼">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="addr1" name="addr1" placeholder="주소" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="addr2" name="addr2" placeholder="상세주소">
                                        </div>
                                        <button type="button" id="signup" name="signup" class="btn btn-primary btn-user btn-block">
                                            가입하기
                                        </button>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="/member/forgot">암호를 잊었어요</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/member/login">이미 가입하셨나요?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(function() {
        $("#signup").click(function() {
            ajax1("/member/signup", "frm");
        });
    });
</script>