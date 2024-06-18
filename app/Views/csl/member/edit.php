<script src="/resource/csl/js/postcode.js?ver=<?JS_VER ?>"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="m_idx" name="m_idx" value="<?=$info->m_idx ?>">
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
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">쓰기</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="member_id" class="col-sm-2 col-form-label">아이디</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="member_id" name="member_id" value="<?=$info->member_id ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="member_name" class="col-sm-2 col-form-label">이름</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="member_name" name="member_name" value="<?=$info->member_name ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="member_nickname" class="col-sm-2 col-form-label">별명</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="member_nickname" name="member_nickname" value="<?=$info->member_nickname ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">이메일</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email" value="<?=$info->email ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-2 col-form-label">전화</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?=$info->phone ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="post_code" class="col-sm-2 col-form-label">우편번호</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="post_code" name="post_code" value="<?=$info->post_code ?>" readonly>
                                    </div>
                                    <div class="col-sm-5">
                                        <button type="button" class="btn btn-info" onclick="postcode_open()">주소검색</button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
                                            <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="postcode_close()" alt="접기 버튼">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="addr1" class="col-sm-2 col-form-label">주소1</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="addr1" name="addr1" value="<?=$info->addr1 ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="addr2" class="col-sm-2 col-form-label">주소2</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="addr2" name="addr2" value="<?=$info->addr2 ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="auth_group" class="col-sm-2 col-form-label">권한그룹</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="auth_group" name="auth_group">
                                            <option value="">선택하세요</option>
                                            <option value="common">일반</option>
                                            <option value="office">기관</option>
                                            <option value="admin">관리자</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-info ml-3" id="save" name="save">등록</button>
                                    <button type="button" class="btn btn-default ml-3" id="cancel" name="cancel">취소</button>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
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
            ajax1("/csl/member/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
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
</script>

