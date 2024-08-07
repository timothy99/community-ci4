<form id="frm" name="frm" onsubmit="return false">
    <input type="hidden" id="reset_key" name="reset_key" value="<?=$reset_key ?>">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><?=env("app.sitename") ?></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">암호를 초기화 합니다.</h1>
                                <p class="mb-4">회원가입시 이메일과 아이디를 새로운 암호를 입력해주세요.</p>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="member_id" name="member_id" placeholder="아이디를 입력해주세요">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="이메일을 입력해주세요">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="member_password" name="member_password" placeholder="새로운 암호를 입력하세요.">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="member_password_confirm" name="member_password_confirm" placeholder="새로운 암호를 한번 더 입력해 주세요.">
                            </div>
                            <button type="btn" class="btn btn-primary btn-user btn-block" onclick="password_change()">
                                초기화
                            </button>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="/member/join">회원가입하세요!</a>
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
</form>

<script>
    function password_change() {
        ajax1("/password/update", "frm");
    }
</script>