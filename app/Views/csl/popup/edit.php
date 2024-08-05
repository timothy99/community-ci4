<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="p_idx" name="p_idx" value="<?=$info->p_idx ?>">
    <input type="hidden" id="popup_file_hidden" name="popup_file_hidden" value="<?=$info->popup_file ?>">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>레이어 팝업</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">레이어 팝업</li>
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
                                    <label for="disabled_hours" class="col-sm-2 col-form-label">시간</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="disabled_hours" name="disabled_hours" value="<?=$info->disabled_hours ?>">
                                        고객이 다시 보지 않음을 선택할 시 몇 시간동안 팝업레이어를 보여주지 않을지 설정합니다.
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title"  value="<?=$info->title ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="http_link" class="col-sm-2 col-form-label">링크</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="http_link" name="http_link" value="<?=$info->http_link ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="position_left" class="col-sm-2 col-form-label">좌측 위치</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="position_left" name="position_left" value="<?=$info->position_left ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="position_top" class="col-sm-2 col-form-label">상단 위치</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="position_top" name="position_top" value="<?=$info->position_top ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="popup_width" class="col-sm-2 col-form-label">너비</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="popup_width" name="popup_width" value="<?=$info->popup_width ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="popup_height" class="col-sm-2 col-form-label">높이</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="popup_height" name="popup_height" value="<?=$info->popup_height ?>">
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
                                    <label for="popup_file" class="col-sm-2 col-form-label">이미지</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="popup_file" name="popup_file" onchange="upload(this.id, 'general')">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="popup_file_visible">
<?php   if ($info->popup_file_info != null) { ?>
                                            <li id="<?=$info->popup_file_info->file_id ?>">
                                                <a href="/download/download/<?=$info->popup_file_info->file_id ?>"><?=$info->popup_file_info->file_name_org ?></a>
                                                <span class="ml-3"><button type="button" id="<?=$info->popup_file_info->file_id ?>" class="btn btn-danger btn-xs" onclick="file_delete('<?=$info->popup_file_info->file_id ?>')">삭제</button></span>
                                            </li>
<?php   } ?>
                                        </ul>
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
        $("#li-popup-list").addClass("menu-open");
        $("#upper-popup-list").addClass("active");
        $("#a-popup-list").addClass("active");

        $("#display_yn").val("<?=$info->display_yn ?>").prop("selected", true);
        $("#start_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd HH:MM"});
        $("#end_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd HH:MM"});
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/popup/update", "frm");
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

        $("#"+input_file_id+"_hidden").val(file_id);
        $("#"+input_file_id+"_visible").html("<li id='"+file_id+"'><a href='/download/download/"+file_id+"'>"+file_name_org+"</a><span class='ml-3'><button type='button' id='"+file_id+"' class='btn btn-danger btn-xs' onclick='file_delete(\""+file_id+"\")'>삭제</button></span></li>");
    }

    function delete_after(file_id) {
        // do nothing, reserved function location
    }
</script>
