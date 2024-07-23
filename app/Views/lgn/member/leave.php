<form id="frm" name="frm" onsubmit="return false">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><?=env("app.sitename") ?></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-2">회원탈퇴를 하시나요?</h1>
                            <p class="mb-4">아이디 : <?=$info->member_id ?></p>
                        </div>
                        <button type="button" class="btn btn-danger btn-user btn-block" id="leave" name="leave">탈퇴</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $("#leave").click(function(e) {
            if (confirm("탈퇴하면 모든 데이터가 삭제됩니다. 탈퇴하시겠습니까?")) {
                ajax1("/member/delete", "frm");
            }
        });
    });
</script>
