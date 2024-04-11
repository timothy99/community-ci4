        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>대시보드</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">홈</a></li>
                                <li class="breadcrumb-item active">대시보드</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container -->
            </section>

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row mt-3">
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
<?php   if (getUserSessionInfo("member_id") == $info->ins_id) { ?>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-warning ml-3" id="list" name="list">목록</button>
                                        <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                        <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
                                    </div>
                                </div>
<?php   } ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
<?php   if (count($comment_list) > 0) { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12">
                                        <table class="table">
                                            <tbody>
<?php       foreach($comment_list as $no => $val) { ?>
                                                <form id="frm_<?=$val->bc_idx ?>" name="frm_<?=$val->bc_idx ?>"></form>
<?php           if (getUserSessionInfo("member_id") == $info->ins_id) { ?>
                                                <tr id="bc_<?=$val->bc_idx ?>">
                                                    <td><?=$val->comment ?></td>
                                                    <td style="width:70px"><button type="button" class="btn btn-xs btn-danger" id="comment_delete" name="comment_delete" onclick="comment_delete(<?=$val->bc_idx ?>)">삭제</button></td>
                                                    <td style="width:70px"><button type="button" class="btn btn-xs btn-success" id="comment_edit" name="comment_edit" onclick="comment_edit(<?=$val->bc_idx ?>)">수정</button></td>
                                                </tr>
<?php           } else { ?>
                                                <tr id="bc_<?=$val->bc_idx ?>">
                                                    <td colspan="3"><?=$val->comment ?></td>
                                                </tr>
<?php           } ?>
<?php       } ?>
                                            </tbody>
                                        </table>
                                        <dl class="row">
                                            <dd class="col-sm-11 text-right">총 댓글수</dd>
                                            <dd class="col-sm-1 text-center"><?=count($comment_list) ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php   } ?>
                    <form id="insert_frm" name="insert_frm">
                        <input type="hidden" id="b_idx" name="b_idx" value="<?=$info->b_idx ?>">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-warning">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="comment" class="col-sm-1 col-form-label">댓글</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-info float-right" id="comment_insert" name="comment_insert">등록</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.container-fluid -->
            </div><!-- /.content -->
        </div><!-- /.content-wrapper -->

<script>
    $(function() {
        $("#list").click(function(e) {
            location.href = "/board/<?=$board_id ?>/list";
        });

        $("#edit").click(function(e) {
            location.href = "/board/<?=$board_id ?>/edit/<?=$info->b_idx ?>";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/board/<?=$board_id ?>/delete/<?=$info->b_idx ?>");
            }
        });

        $("#comment_insert").click(function(e) {
            ajax1("/comment/insert", "insert_frm");
        });
    });

    function comment_edit(bc_idx) {
        ajax4("/comment/edit/"+bc_idx, "bc_"+bc_idx);
    }

    function comment_update(bc_idx) {
        var update_form = new FormData();
        var comment = $("#comment_"+bc_idx).val();
        update_form.append("bc_idx", bc_idx);
        update_form.append("comment", comment);
        ajax5("/comment/update", update_form);
    }

    function comment_delete(bc_idx) {
        if(confirm("댓글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
            ajax2("/comment/delete/"+bc_idx);
        }
    }
</script>