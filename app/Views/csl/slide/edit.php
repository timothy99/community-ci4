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
                                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?=$info->start_date_txt ?>">
                                    </div>
                                    <div class="col-sm-5 d-flex">
                                        ~ <input type="text" class="form-control ml-3" id="end_date" name="end_date" value="<?=$info->end_date_txt ?>">
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
                                        <input type="file" class="form-control" id="slide_file" name="slide_file" onchange="upload(this.id, 'general')">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="slide_file_visible">
<?php   if ($info->slide_file_info != null) { ?>
                                            <li id="<?=$info->slide_file_info->file_id ?>">
                                                <a href="/download/download/<?=$info->slide_file_info->file_id ?>"><?=$info->slide_file_info->file_name_org ?></a>
                                                <span class="ml-3"><button type="button" id="<?=$info->slide_file_info->file_id ?>" class="btn btn-danger btn-xs" onclick="file_delete('<?=$info->slide_file_info->file_id ?>')">삭제</button></span>
                                            </li>
<?php   } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="preview" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10" id="slide_preview">
<?php   if ($info->slide_file_info != null) { ?>
                                        <img src="/download/view/<?=$info->slide_file_info->file_id ?>" class="img-fluid"><br>
                                        이미지 실제크기 : <?=$info->slide_file_info->image_width ?>px * <?=$info->slide_file_info->image_height ?>px
<?php   } ?>
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
        $("#li-slide-list").addClass("menu-open");
        $("#upper-slide-list").addClass("active");
        $("#a-slide-list").addClass("active");

        $("#display_yn").val("<?=$info->display_yn ?>").prop("selected", true);
        $("#start_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd"});
        $("#end_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd"});
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/slide/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });

    function upload_after(proc_result) {
        var info = proc_result.info;
        var file_id = info.file_id;
        var input_file_id = info.input_file_id;
        var file_name_org = info.file_name_org;
        var image_width = info.image_width;
        var image_height = info.image_height;

        $("#"+input_file_id+"_hidden").val(file_id);
        $("#"+input_file_id+"_visible").html("<li id='"+file_id+"'><a href='/download/download/"+file_id+"'>"+file_name_org+"</a><span class='ml-3'><button type='button' id='"+file_id+"' class='btn btn-danger btn-xs' onclick='file_delete(\""+file_id+"\")'>삭제</button></span></li>");
        $("#slide_preview").html("<img src='/download/view/"+file_id+"' class='img-fluid'><br>이미지 실제크기 : "+image_width+"px * "+image_height+"px");
    }

    function delete_after(file_id) {
        $("#slide_preview").html(" ");
    }
</script>



