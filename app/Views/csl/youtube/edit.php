<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="y_idx" name="y_idx" value="<?=$info->y_idx ?>">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>유튜브</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item">유튜브</li>
                            <li class="breadcrumb-item active">쓰기</li>
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
                                        <input type="text" class="form-control" id="title" name="title"  value="<?=$info->title ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="category" class="col-sm-2 col-form-label">분류</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="category" name="category">
                                            <option value="channel">channel</option>
                                            <option value="playlist">playlist</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="play_id" class="col-sm-2 col-form-label">재상 아이디</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="play_id" name="play_id"  value="<?=$info->play_id ?>">
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
        $("#li-youtube-list").addClass("menu-open");
        $("#upper-youtube-list").addClass("active");
        $("#a-youtube-list").addClass("active");

        $("#category").val("<?=$info->category ?>").prop("selected", true);
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/youtube/update", "frm");
        });

        $("#cancel").click(function(e) {
            history.go(-1);
        });
    });
</script>
