<form id="frm" name="frm">
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
</form>

<script>
    $(function() {
        $("#login").click(function() {
            ajax1("/member/signin", "frm");
        });
    });
</script>