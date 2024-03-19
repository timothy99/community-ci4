<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="b_idx" name="b_idx" value="<?=$b_idx ?>">
    <input type="hidden" id="board_id" name="board_id" value="<?=$board_id ?>">
    <input type="hidden" id="summer_code" name="summer_code">
    <input type="hidden" id="upload_result" name="upload_result">
    <ul id="ul_file_list" name="ul_file_list" style="display:none">
<?php   foreach($file_list as $no => $val) { ?>
        <li id="<?=$val->file_id ?>">
            <input type="hidden" id="file_list" name="file_list[]" value="<?=$val->file_id ?>">
        </li>
<?php   } ?>
    </div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>게시판</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">홈</a></li>
                            <li class="breadcrumb-item active">게시판</li>
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
                                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" placeholder="제목을 입력하세요">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contents" class="col-sm-2 col-form-label">내용</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contents" name="contents">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="attach" class="col-sm-2 col-form-label">파일첨부</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="attach" name="attach" onchange="upload(this.id)">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="visible_file_list">
<?php   foreach($file_list as $no1 => $val1) { ?>
                                            <li id="<?=$val1->file_id ?>">
                                                <a href="/csl/attach/download/<?=$val1->file_id ?>"><?=$val1->file_name_org ?></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a id="<?=$val1->file_id ?>" href="javascript:void(0)" onclick="file_delete('<?=$val1->file_id ?>')">
                                                    삭제
                                                </a>
                                            </li>
<?php   } ?>
                                        </ul>
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
        $("#li-board-notice-list").addClass("menu-open");
        $("#upper-board-notice-list").addClass("active");
        $("#a-board-<?=$board_id ?>-list").addClass("active");

        $("#title").val("<?=$info->title ?>"); // 내용채우기
        summernote_initialize("contents", "<?=$info->contents ?>", summernote_settings); // 썸머노트 내용 초기화
    });

    $(function() {
        $("#save").click(function(e) {
            $("#summer_code").val($("#contents").summernote("code"));
            ajax1("/csl/board/<?=$board_id ?>/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>

