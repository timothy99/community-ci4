<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="s_idx" name="s_idx" value="<?=$info->s_idx ?>">
    <input type="hidden" id="slide_file_hidden" name="slide_file_hidden" value="<?=$info->slide_file ?>">
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
                                    <label for="order_no" class="col-sm-2 col-form-label">정렬순서</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="order_no" name="order_no"  value="<?=$info->order_no ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title"  value="<?=$info->title ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contents" class="col-sm-2 col-form-label">내용</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="contents" name="contents" rows="6"><?=$info->contents ?></textarea>
                                        슬라이드이기 때문에 내용은 alt 태그에만 노출됩니다. (이미지 위에 마우스를 가져다 대고 있어야함) 웹접근성을 위해서는 되도록 상세하게 넣어주세요.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="http_link" class="col-sm-2 col-form-label">링크</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="http_link" name="http_link" value="<?=$info->http_link ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="display_date" class="col-sm-2 col-form-label">게시기간</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?=$info->start_date_txt ?>" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd HH:MM" inputmode="numeric">
                                    </div>
                                    <div class="col-sm-5 d-flex">
                                        ~ <input type="text" class="form-control ml-3" id="end_date" name="end_date" value="<?=$info->end_date_txt ?>" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd HH:MM" inputmode="numeric">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="display_yn" class="col-sm-2 col-form-label">노출여부</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="display_yn" name="display_yn">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="slide_file" class="col-sm-2 col-form-label">이미지</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="slide_file" name="slide_file" onchange="upload2(this.id)">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="slide_file_visible">
<?php   if ($info->slide_file_info != null) { ?>
                                            <li id="<?=$info->slide_file_info->file_id ?>">
                                                <a href="/csl/file/download/<?=$info->slide_file_info->file_id ?>"><?=$info->slide_file_info->file_name_org ?></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a id="<?=$info->slide_file_info->file_id ?>" href="javascript:void(0)" onclick="file_delete('<?=$info->slide_file_info->file_id ?>')">삭제</a>
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
        $("#li-slide-list").addClass("menu-open");
        $("#upper-slide-list").addClass("active");
        $("#a-slide-list").addClass("active");

        $("#display_yn").val("<?=$info->display_yn ?>").prop("selected", true);
        $("#start_date").inputmask("yyyy-mm-dd HH:MM");
        $("#end_date").inputmask("yyyy-mm-dd HH:MM");
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/slide/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
