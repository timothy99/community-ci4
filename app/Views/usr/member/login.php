<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=SITE_NAME ?> - 로그인</title>

    <!-- Custom fonts for this template-->
    <link href="../../usr/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../usr/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="../../usr/vendor/jquery/jquery.min.js"></script>
    <script src="../../usr/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../usr/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../usr/js/sb-admin-2.min.js"></script>

    <!-- User Javascript -->
    <script src="../../usr/js/ajax.js"></script>
</head>


<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-5 col-md-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">로그인해주세요</h1>
                                    </div>
                                    <form id="frm" name="frm" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="member_id" name="member_id" placeholder="아이디를 입력해주세요.">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="member_password" name="member_password" placeholder="암호를 입력해주세요">
                                        </div>
                                        <button type="button" id="login" name="login" class="btn btn-primary btn-user btn-block">
                                            로그인
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="/member/forgot">암호를 잊어버리셨어요?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/member/join">회원가입하세요!</a>
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
        $("#login").click(function() {
            ajax1("/member/signin", "frm");
        });
    });
</script>