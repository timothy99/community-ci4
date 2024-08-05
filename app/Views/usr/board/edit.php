<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="b_idx" name="b_idx" value="<?=$b_idx ?>">
    <input type="hidden" id="board_id" name="board_id" value="<?=$board_id ?>">
    <input type="hidden" id="summernote_code" name="summernote_code">
    <input type="hidden" id="upload_result" name="upload_result">
    <input type="hidden" id="contents_code" name="contents_code" value='<?=base64_encode($info->contents) ?>'>
    <input type="hidden" id="summer_code" name="summer_code">
    <ul id="ul_file_list" name="ul_file_list" style="display:none">
<?php   foreach($file_list as $no => $val) { ?>
        <li id="ul_<?=$val->file_id ?>">
            <input type="hidden" id="file_list" name="file_list[]" value="<?=$val->file_id ?>">
        </li>
<?php   } ?>
    </ul>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?=$title_info->title ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><?=$title_info->bread_crumb ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container">
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
                                        <input type="file" class="form-control" id="attach" name="attach" onchange="upload(this.id, 'general')">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="visible_file_list">
<?php   foreach($info->file_list as $no1 => $val1) { ?>
                                            <li id="visible_<?=$val1->file_id ?>">
                                                <a href="/download/download/<?=$val1->file_id ?>">
                                                    <?=$val1->file_name_org ?>
                                                </a>
                                                <span class="ml-3">
                                                    <button type="button" id="<?=$val1->file_id ?>" class="btn btn-danger btn-xs" onclick="file_delete('<?=$val1->file_id ?>')">
                                                        삭제
                                                    </button>
                                                </span>
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
        $("#li-board-notice-list").addClass("menu-open");
        $("#upper-board-notice-list").addClass("active");
        $("#a-board-<?=$board_id ?>-list").addClass("active");

        $("#title").val("<?=$info->title ?>"); // 내용채우기
        $("#contents").summernote(summernote_settings); // 썸머노트 초기화
        var contents_code = $("#contents_code").val();
        $("#contents").summernote("pasteHTML",  decodeUnicode(contents_code)); // 내용 넣기
    });

    $(function() {
        $("#save").click(function(e) {
            $("#summer_code").val($("#contents").summernote("code"));
            ajax1("/board/<?=$board_id ?>/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });

    function upload_after(proc_result) {
        var file_id = proc_result.file_id;
        var file_name_org = proc_result.file_name_org;

        $("#ul_file_list").append("<li id='ul_"+file_id+"'><input type='hidden' id='file_list' name='file_list[]' value='"+file_id+"'></li>");
        $("#visible_file_list").append("<li id='visible_"+file_id+"'><a href='/download/download/"+file_id+"'>"+file_name_org+"</a><span class='ml-3'><button type='button' id='"+file_id+"' class='btn btn-danger btn-xs' onclick='file_delete(\""+file_id+"\")'>삭제</button></span></li>");
    }
</script>
