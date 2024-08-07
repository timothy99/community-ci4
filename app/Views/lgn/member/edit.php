<form id="frm" name="frm" class="login-form login-form2">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><?=env("app.sitename") ?></a>
            </div>
            <div class="card-body">
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        암호
                    </div>
                    <div class="col-sm-5 d-flex">
                        <button type="button" class="btn btn-info btn-user btn-block" onclick="change_password()">암호변경</button>
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        이름
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="member_name" name="member_name" value="<?=$info->member_name ?>">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        별명
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="member_nickname" name="member_nickname" value="<?=$info->member_nickname ?>">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        이메일
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" name="email" value="<?=$info->email ?>">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        전화
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?=$info->phone ?>">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        우편번호
                    </div>
                    <div class="col-sm-9 d-flex">
                        <input type="text" class="form-control" id="post_code" name="post_code" value="<?=$info->post_code ?>" readonly>
                        <button type="button" class="btn btn-info btn-user btn-block ml-3" onclick="postcode_open()">검색</button>
                    </div>
                </div>
                <div class="form-group row" id="post_div" style="display:none">
                    <div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="postcode_close()" alt="접기 버튼">
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        주소1
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="addr1" name="addr1" value="<?=$info->addr1 ?>" readonly>
                    </div>
                </div>
                <div class="input-group mb-3 d-flex align-items-center">
                    <div class="col-sm-3">
                        주소2
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="addr2" name="addr2" value="<?=$info->addr2 ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer clear-fix d-flex justify-content-end">
                <button type="button" class="btn btn-info" id="save" name="save">저장</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(window).on("load", function() {
        $("#email").inputmask({ alias: "email"});
        $("#phone").inputmask("9{1,3}-9{1,4}-9{1,4}");
    });

    $(function() {
        $("#save").click(function() {
            ajax1("/member/update", "frm");
        });
    });

    // 우편번호 검색된 결과값으로 페이지에 맞는 데이터 넣기
    function postcode_after(data) {
        // 우편번호와 주소 정보를 해당 필드에 넣는다.
        document.getElementById("post_code").value = data.zonecode;
        document.getElementById("addr1").value = data.addr1;
        document.getElementById("addr2").value = data.addr2;
        // 커서를 상세주소 필드로 이동한다.
        document.getElementById("addr2").focus();
    }

    function change_password() {
        location.href="/password/confirm";
    }
</script>
