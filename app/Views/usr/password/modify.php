<form id="frm" name="frm" onsubmit="return false" class="login-form">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><?=env("app.sitename") ?></a>
            </div>
            <div class="card-body">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-2">암호를 변경합니다.</h1>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" value="<?=getUserSessionInfo("member_id") ?>" readonly>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="member_password" name="member_password" placeholder="새로운 암호를 입력하세요.">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="member_password_confirm" name="member_password_confirm" placeholder="한번 더 입력해 주세요.">
                        </div>
                        <button type="btn" class="btn btn-primary btn-user btn-block" onclick="password_change()">
                            변경
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function password_change() {
        ajax1("/password/change", "frm");
    }
</script>