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
                            <h1 class="h4 text-gray-900 mb-2">아이디를 잊으셨나요?</h1>
                            <p class="mb-4">회원가입시 이메일을 넣어주세요. 아이디 정보를 메일로 보내드립니다.</p>
                        </div>
                        <form class="user">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="이메일을 입력해주세요">
                            </div>
                            <button type="btn" class="btn btn-primary btn-user btn-block" onclick="sendmail()">
                                이메일 보내기
                            </button>
                        </form>
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
        ajax1("/password/send", "frm");
        alert("요청하신 메일로 회원정보를 보냈습니다.");
    }
</script>