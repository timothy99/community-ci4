<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="member_id" name="member_id" value="<?=$info->member_id ?>">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>회원</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">회원</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">암호변경</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="member_password" class="col-sm-2 col-form-label">변경암호</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="member_password" name="member_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="member_password_confirm" class="col-sm-2 col-form-label">암호확인</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="member_password_confirm" name="member_password_confirm">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-info ml-3" id="save" name="save">변경</button>
                                    <button type="button" class="btn btn-default ml-3" id="cancel" name="cancel">취소</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</form>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#upper-member-list").addClass("active");
        $("#a-member-list").addClass("active");

        $("#auth_group").val("<?=$info->auth_group ?>").prop("selected", true);
        $("#email").inputmask({ alias: "email"});
        $("#phone").inputmask("9{1,3}-9{1,4}-9{1,4}");

    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/member/change", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
