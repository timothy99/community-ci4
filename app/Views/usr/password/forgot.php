<form id="frm" name="frm" onsubmit="return false" class="login-form">
    <div class="login-box">
        <!-- Outer Row -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><?=env("app.sitename") ?></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-2">암호를 잊으셨나요?</h1>
                            <p class="mb-4">회원가입시 이메일과 아이디를 넣어주세요. 초기화 정보를 메일로 보내드립니다.</p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="member_id" name="member_id" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="이메일을 입력해주세요">
                        </div>
                        <button type="btn" class="btn btn-primary btn-user btn-block" onclick="sendmail()">
                            이메일 보내기
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
</form>

<script>
    function sendmail() {
        ajax1("/password/password", "frm");
    }
</script>