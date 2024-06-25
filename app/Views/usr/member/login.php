<form id="frm" name="frm">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><?=env("app.sitename") ?></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">로그인해주세요</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="member_id" name="member_id" placeholder="아이디를 입력하세요.">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="member_password" name="member_password" placeholder="암호를 입력하세요.">
                </div>
                <div class="input-group mb-3 justify-content-center">
                    <button type="button" class="btn btn-primary" id="login" name="login">로그인</button>
                </div>
                <hr>
                <p class="mb-1 text-center">
                    <a href="/password/find" class="btn btn-warning">아이디찾기</a>
                    <a href="/password/forgot" class="btn btn-danger">암호분실</a>
                    <a href="/member/join" class="btn btn-info text-center">신규가입</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
</form>

<script>
    $(function() {
        $("#login").click(function() {
            ajax1("/member/signin", "frm");
        });
    });
</script>