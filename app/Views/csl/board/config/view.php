<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>게시판</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?=$info->title ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <th>게시판 아이디</th>
                                                <td><?=$info->board_id ?></td>
                                            </tr>
                                            <tr>
                                                <th>스킨</th>
                                                <td><?=$info->type ?></td>
                                            </tr>
                                            <tr>
                                                <th>제목</th>
                                                <td><?=$info->title ?></td>
                                            </tr>
                                            <tr>
                                                <th>분류</th>
                                                <td><?=$info->category ?></td>
                                            </tr>
                                            <tr>
                                                <th>분류 사용여부</th>
                                                <td><?=$info->category_yn ?></td>
                                            </tr>
                                            <tr>
                                                <th>사용자 글쓰기</th>
                                                <td><?=$info->user_write ?></td>
                                            </tr>
                                            <tr>
                                                <th>댓글쓰기</th>
                                                <td><?=$info->comment_write ?></td>
                                            </tr>
                                            <tr>
                                                <th>줄 수</th>
                                                <td><?=$info->base_rows ?></td>
                                            </tr>
                                            <tr>
                                                <th>등록일 기능</th>
                                                <td><?=$info->reg_date_yn ?></td>
                                            </tr>
                                            <tr>
                                                <th>첨부파일 수</th>
                                                <td><?=number_format($info->file_cnt) ?></td>
                                            </tr>
                                            <tr>
                                                <th>개별 최대 용량</th>
                                                <td><?=number_format($info->file_upload_size_limit) ?>MB</td>
                                            </tr>
                                            <tr>
                                                <th>첨부 최대 용량</th>
                                                <td><?=number_format($info->file_upload_size_total) ?>MB</td>
                                            </tr>
                                            <tr>
                                                <th>입력자</th>
                                                <td><?=$info->ins_id ?></td>
                                            </tr>
                                            <tr>
                                                <th>입력일</th>
                                                <td><?=$info->ins_date_txt ?></td>
                                            </tr>
                                            <tr>
                                                <th>수정자</th>
                                                <td><?=$info->upd_id ?></td>
                                            </tr>
                                            <tr>
                                                <th>수정일</th>
                                                <td><?=$info->upd_date_txt ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
        </div>
    </section>
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
