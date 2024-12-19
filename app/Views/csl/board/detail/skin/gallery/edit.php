<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="b_idx" name="b_idx" value="<?=$b_idx ?>">
    <input type="hidden" id="board_id" name="board_id" value="<?=$board_id ?>">
    <input type="hidden" id="summernote_code" name="summernote_code">
    <input type="hidden" id="upload_result" name="upload_result">
    <input type="hidden" id="contents_code" name="contents_code" value='<?=base64_encode($info->contents) ?>'>
    <input type="hidden" id="summer_code" name="summer_code">
    <ul id="ul_file_list" name="ul_file_list" style="display:none">
<?php   foreach($file_list as $no => $val) { ?>
        <li id="<?=$val->file_id ?>">
            <input type="hidden" id="file_list" name="file_list[]" value="<?=$val->file_id ?>">
        </li>
<?php   } ?>
    </ul>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?=$config_info->title ?></h1>
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
                                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" value="<?=$info->title ?>" placeholder="제목을 입력하세요">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="title" class="col-form-label">공지</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="form-check pt-2">
                                            <input class="form-check-input" type="checkbox" id="notice_yn" name="notice_yn" value="Y">
                                            <label class="form-check-label">상단에 등록</label>
                                        </div>
                                    </div>
                                </div>
<?php   if ($config_info->category_yn== "Y") { ?>
                                <div class="form-group row">
                                    <label for="reg_date" class="col-sm-2 col-form-label">분류</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="category" name="category">
                                            <option value="">선택하세요</option>
<?php       foreach ($config_info->category_arr as $no => $val) { ?>
                                            <option value="<?=$val ?>"><?=$val ?></option>
<?php       } ?>
                                        </select>
                                    </div>
                                </div>
<?php   } ?>

<?php   if ($config_info->reg_date_yn  == "Y") { ?>
                                <div class="form-group row">
                                    <label for="reg_date" class="col-sm-2 col-form-label">등록일</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="reg_date" name="reg_date" value="<?=$info->reg_date ?>">
                                    </div>
                                </div>
<?php   } ?>
                                <div class="form-group row">
                                    <label for="contents" class="col-sm-2 col-form-label">내용</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contents" name="contents">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="attach" class="col-sm-2 col-form-label">파일첨부</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="attach" name="attach" onchange="upload(this.id, 'board')">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="visible_file_list">
<?php   foreach($file_list as $no1 => $val1) { ?>
                                            <li id="<?=$val1->file_id ?>">
                                                <a href="/csl/attach/download/<?=$val1->file_id ?>"><?=$val1->file_name_org ?></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a id="<?=$val1->file_id ?>" href="javascript:void(0)" onclick="file_delete('<?=$val1->file_id ?>')">
                                                    <span class="ml-3">
                                                        <button type="button" id="<?=$val1->file_id ?>" class="btn btn-danger btn-xs" onclick="file_delete('<?=$val1->file_id ?>')">삭제</button>
                                                    </span>
                                                </a>
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
        $("#li-board-config-list").addClass("menu-open");
        $("#upper-board-config-list").addClass("active");
        $("#a-board-manage-list").addClass("active");

        $("#contents").summernote(summernote_settings); // 썸머노트 초기화
        var contents_code = $("#contents_code").val();
        $("#contents").summernote("code",  decodeUnicode(contents_code)); // 내용 넣기

        $("#reg_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd HH:MM:ss"});
        $("#category").val("<?=$info->category ?>").prop("selected", true);
        $("#notice_yn:checkbox[value='<?=$info->notice_yn ?>']").prop('checked', true);
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

    function upload_after(proc_result) {
        var info = proc_result.info;
        var file_id = info.file_id;
        var input_file_id = info.input_file_id;
        var file_name_org = info.file_name_org;

        $("#ul_file_list").append("<li id='ul_"+file_id+"'><input type='hidden' id='file_list' name='file_list[]' value='"+file_id+"'></li>");
        $("#visible_file_list").append("<li id='visible_"+file_id+"'><a href='/download/download/"+file_id+"'>"+file_name_org+"</a><span class='ml-3'><button type='button' id='"+file_id+"' class='btn btn-danger btn-xs' onclick='file_delete(\""+file_id+"\")'>삭제</button></span></li>");
    }

    function delete_after(file_id) {
        // do nothing, reserved function location
    }
</script>
