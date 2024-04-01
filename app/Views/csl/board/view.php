<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>게시판</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">홈</a></li>
                        <li class="breadcrumb-item active">게시판</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?=$info->title ?></h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12">
                                <dl class="row">
                                    <dt class="col-sm-2">내용</dt>
                                    <dd class="col-sm-10"><?=$info->contents ?></dd>
                                    <dt class="col-sm-2">등록자</dt>
                                    <dd class="col-sm-10"><?=$info->ins_id ?></dd>
                                    <dt class="col-sm-2">등록일</dt>
                                    <dd class="col-sm-10"><?=$info->ins_date_txt ?></dd>
                                    <dt class="col-sm-2">첨부파일</dt>
                                    <dd class="col-sm-10">
<?php   foreach($file_list as $no => $val) { ?>
                                        <a href="/csl/file/download/<?=$val->file_id ?>"><?=$val->file_name_org ?></a><br>
<?php   } ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-board-notice-list").addClass("menu-open");
        $("#upper-board-notice-list").addClass("active");
        $("#a-board-<?=$board_id ?>-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/board/<?=$board_id ?>/edit/<?=$info->b_idx ?>";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/board/<?=$board_id ?>/delete/<?=$info->b_idx ?>");
            }
        });
    });
</script>