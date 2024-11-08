<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="c_idx" name="c_idx" value="<?=$info->c_idx ?>">
    <input type="hidden" id="attach_file_hidden" name="attach_file_hidden" value="<?=$info->attach_file ?>">

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>일정등록</h1>
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
                                    <label for="title" class="col-sm-2 col-form-label">내용</label>
                                    <div class="col-sm-10">
                                        <textarea id="contents" class="form-control" name="contents" rows="6"><?=$info->contents ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-2 col-form-label">시작일</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?=$info->start_date ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="end_date" class="col-sm-2 col-form-label">종료일</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="end_date" name="end_date" value="<?=$info->end_date ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="attach_file" class="col-sm-2 col-form-label">첨부파일</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="attach_file" name="attach_file" onchange="upload(this.id, 'general')">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="attach_file_visible">
<?php   if ($info->attach_file_info != null) { ?>
                                            <li id="<?=$info->attach_file_info->file_id ?>">
                                                <a href="/download/download/<?=$info->attach_file_info->file_id ?>"><?=$info->attach_file_info->file_name_org ?></a>
                                                <span class="ml-3"><button type="button" id="<?=$info->attach_file_info->file_id ?>" class="btn btn-danger btn-xs" onclick="file_delete('<?=$info->attach_file_info->file_id ?>')">삭제</button></span>
                                            </li>
<?php   } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-info ml-3" onclick="save()">등록</button>
                                    <button type="button" class="btn btn-default ml-3" onclick="cancel()">취소</button>
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
        $("#li-calendar-list").addClass("menu-open");
        $("#a-calendar-list").addClass("active");

        $("#start_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd HH:MM"});
        $("#end_date").inputmask("datetime", {inputFormat:"yyyy-mm-dd HH:MM"});
    });

    function save() {
        ajax1("/csl/calendar/update", "frm");
    }

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
