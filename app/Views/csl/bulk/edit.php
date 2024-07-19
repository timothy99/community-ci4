<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="bd_idx" name="bd_idx" value="<?=$info->bd_idx ?>">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>슬라이드</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">슬라이드</li>
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
                                <h3 class="card-title">쓰기</h3>
                            </div>
    
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="member_name" class="col-sm-2 col-form-label">이름</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="member_name" name="member_name"  value="<?=$info->member_name ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">이메일</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email"  value="<?=$info->email ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">전화</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="phone" name="phone"  value="<?=$info->phone ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">성별</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="gender" name="gender"  value="<?=$info->gender ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="post_code" class="col-sm-2 col-form-label">우편번호</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="post_code" name="post_code"  value="<?=$info->post_code ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="addr1" class="col-sm-2 col-form-label">주소1</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="addr1" name="addr1"  value="<?=$info->addr1 ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="addr2" class="col-sm-2 col-form-label">주소2</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="addr2" name="addr2"  value="<?=$info->addr2 ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-info ml-3" id="save" name="save">등록</button>
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
        $("#li-bulk-list").addClass("menu-open");
        $("#upper-bulk-list").addClass("active");
        $("#a-bulk-list").addClass("active");
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/bulk/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
