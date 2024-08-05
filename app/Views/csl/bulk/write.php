<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="bulk_file_hidden" name="bulk_file_hidden">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>벌크</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">벌크</li>
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
                                    <label for="title" class="col-sm-2 col-form-label">제목</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bulk_file" class="col-sm-2 col-form-label">엑셀파일</label>
                                    <div class="col-sm-5">
                                        <input type="file" class="form-control" id="bulk_file" name="bulk_file" onchange="upload(this.id, 'general')">
                                    </div>
                                    <div class="col-sm-5">
                                        <ul class="list-unstyled" id="bulk_file_visible"></ul>
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
            ajax1("/csl/bulk/excel/upload", "frm");
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
