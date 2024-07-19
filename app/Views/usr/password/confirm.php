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
                            <h1 class="h4 text-gray-900 mb-2">암호를 확인합니다.</h1>
                        </div>
                        <form class="user">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="member_password" name="member_password" placeholder="암호를 입력해주세요">
                            </div>
                            <button type="btn" class="btn btn-primary btn-user btn-block" onclick="password_confirm()">
                                확인
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function password_confirm() {
        ajax1("/password/search", "frm");
    }
</script>