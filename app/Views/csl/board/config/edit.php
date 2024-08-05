<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="bc_idx" name="bc_idx" value="<?=$info->bc_idx ?>">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>게시판 설정</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">게시판 설정</li>
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
                                    <label for="board_id" class="col-sm-2 col-form-label">게시판 아이디</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="board_id" name="board_id" value="<?=$info->board_id ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" value="<?=$info->title ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="category" class="col-sm-2 col-form-label">분류</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="category" name="category" value="<?=$info->category ?>">
                                        <br>
                                        분류를 입력하실땐 구분자를 ||(파이프 문자 2개)로 해서 입력해주세요.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="category_yn" class="col-sm-2 col-form-label">분류 사용여부</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="category_yn" name="category_yn">
                                            <option value="N">N</option>
                                            <option value="Y">Y</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="user_write" class="col-sm-2 col-form-label">사용자 글쓰기</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="user_write" name="user_write">
                                            <option value="N">N</option>
                                            <option value="Y">Y</option>
                                        </select>
                                        <br>
                                        사용자가 글쓰기 가능하게 할지 결정합니다. N으로 해두면 관리자 화면에서만 글쓰기가 가능합니다.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="base_rows" class="col-sm-2 col-form-label">줄 수</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="base_rows" name="base_rows" value="<?=$info->base_rows ?>">
                                        <br>
                                        최초 접근시 화면에 보여줄 줄 수를 지정할 수 있습니다.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="reg_date_yn" class="col-sm-2 col-form-label">등록일 기능</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="reg_date_yn" name="reg_date_yn">
                                            <option value="N">N</option>
                                            <option value="Y">Y</option>
                                        </select>
                                        <br>
                                        등록일 기능을 사용하시면 등록일을 수정하실 수 있습니다.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file_cnt" class="col-sm-2 col-form-label">첨부파일 수</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="file_cnt" name="file_cnt" value="<?=$info->file_cnt ?>">
                                        <br>
                                        첨부파일수는 자유롭게 지정가능하며, 1이상 입력가능합니다.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file_upload_size_limit" class="col-sm-2 col-form-label">개별 최대 용량</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="file_upload_size_limit" name="file_upload_size_limit" value="<?=$info->file_upload_size_limit ?>">
                                        <br>
                                        개별용량은 자유롭게 지정가능하며 메가바이트(MB)단위로 입력하세요. 1이상 입력가능합니다. 다만 너무 높게 설정할 경우 서버설정에 의해 오류가 발생할 수 있습니다.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file_upload_size_total" class="col-sm-2 col-form-label">첨부 최대 용량</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="file_upload_size_total" name="file_upload_size_total" value="<?=$info->file_upload_size_total ?>">
                                        <br>
                                        최대용량은 자유롭게 지정가능하며, 1이상 입력가능합니다. 다만 너무 높게 설정할 경우 서버설정에 의해 오류가 발생할 수 있습니다.
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
        $("#li-board-config-list").addClass("menu-open");
        $("#upper-board-config-list").addClass("active");
        $("#a-board-config-list").addClass("active");
        $("#category_yn").val("<?=$info->category_yn ?>").prop("selected", true);
        $("#reg_date_yn").val("<?=$info->reg_date_yn ?>").prop("selected", true);
        $("#user_write").val("<?=$info->user_write ?>").prop("selected", true);
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/board/config/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
