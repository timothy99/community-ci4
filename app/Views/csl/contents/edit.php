<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="c_idx" name="c_idx" value="<?=$info->c_idx ?>">
    <input type="hidden" id="summernote_code" name="summernote_code">
    <input type="hidden" id="contents_code" name="contents_code" value='<?=base64_encode($info->contents) ?>'>
    <input type="hidden" id="summer_code" name="summer_code">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>콘텐츠</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">콘텐츠</li>
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
                                    <label for="contents_id" class="col-sm-2 col-form-label">콘텐츠 아이디</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="contents_id" name="contents_id"  value="<?=$info->contents_id ?>">
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
                                        <input type="text" class="form-control" id="contents" name="contents">
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
        $("#li-contents-list").addClass("menu-open");
        $("#upper-contents-list").addClass("active");
        $("#a-contents-list").addClass("active");

        $("#contents").summernote(summernote_settings); // 썸머노트 초기화
        var contents_code = $("#contents_code").val();
        $("#contents").summernote("code",  decodeUnicode(contents_code)); // 내용 넣기
    });

    $(function() {
        $("#save").click(function(e) {
            $("#summer_code").val($("#contents").summernote("code"));
            ajax1("/csl/contents/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
