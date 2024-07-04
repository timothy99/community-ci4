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
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
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
                                    <dt class="col-sm-2">게시판 아이디</dt>
                                    <dd class="col-sm-10"><?=$info->board_id ?></dd>
                                    <dt class="col-sm-2">제목</dt>
                                    <dd class="col-sm-10"><?=$info->title ?></dd>
                                    <dt class="col-sm-2">분류 사용여부</dt>
                                    <dd class="col-sm-10"><?=$info->category_yn ?></dd>
                                    <dt class="col-sm-2">분류</dt>
                                    <dd class="col-sm-10"><?=$info->category ?></dd>
                                    <dt class="col-sm-2">줄 수</dt>
                                    <dd class="col-sm-10"><?=$info->base_rows ?></dd>
                                    <dt class="col-sm-2">등록일 기능</dt>
                                    <dd class="col-sm-10"><?=$info->reg_date_yn ?></dd>
                                    <dt class="col-sm-2">첨부파일 수</dt>
                                    <dd class="col-sm-10"><?=number_format($info->file_cnt) ?></dd>
                                    <dt class="col-sm-2">개별 최대 용량</dt>
                                    <dd class="col-sm-10"><?=number_format($info->file_upload_size_limit) ?>MB</dd>
                                    <dt class="col-sm-2">첨부 최대 용량</dt>
                                    <dd class="col-sm-10"><?=number_format($info->file_upload_size_total) ?>MB</dd>
                                    <dt class="col-sm-2">등록자</dt>
                                    <dd class="col-sm-10"><?=$info->ins_id ?></dd>
                                    <dt class="col-sm-2">등록일</dt>
                                    <dd class="col-sm-10"><?=$info->ins_date_txt ?></dd>
                                    <dt class="col-sm-2">수정자</dt>
                                    <dd class="col-sm-10"><?=$info->upd_id ?></dd>
                                    <dt class="col-sm-2">수정일</dt>
                                    <dd class="col-sm-10"><?=$info->upd_date_txt ?></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
                                <button type="button" class="btn btn-info ml-3" id="list" name="list">목록</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-board-config-list").addClass("menu-open");
        $("#upper-board-config-list").addClass("active");
        $("#a-board-config-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/board/config/edit/<?=$info->bc_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/board/config/list";
        });

        $("#delete").click(function(e) {
            if(confirm("게시판 정보를 삭제하면 해당 게시판의 게시물들도 모두 삭제됩니다. 계속 하시겠습니까?")) {
                ajax2("/csl/board/config/delete/<?=$info->bc_idx ?>");
            }
        });
    });
</script>