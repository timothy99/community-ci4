<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="sl_idx" name="sl_idx" value="<?=$info->sl_idx ?>">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>단축url</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">홈</a></li>
                            <li class="breadcrumb-item active">단축url</li>
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
                                        <input type="text" class="form-control" id="title" name="title"  value="<?=$info->title ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="http_link" class="col-sm-2 col-form-label">링크</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="http_link" name="http_link" value="<?=$info->http_link ?>">
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
        $("#li-shortlink-list").addClass("menu-open");
        $("#upper-shortlink-list").addClass("active");
        $("#a-shortlink-list").addClass("active");

    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/shortlink/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
