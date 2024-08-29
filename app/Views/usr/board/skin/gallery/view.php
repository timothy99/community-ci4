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

            <div class="content">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><?=$info->title ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-sm">
                                            <tbody>
                                                <tr>
                                                    <th>내용</th>
                                                    <td>
<?php   foreach($info->file_list as $no => $val) { ?>
                                                        <img src="/download/view/<?=$val->file_id ?>" class="img-fluid"><br><br>
<?php   } ?>
                                                        <?=$info->contents ?>
                                                    </td>
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
                                                    <th>첨부파일</th>
                                                    <td>
<?php   foreach($info->file_list as $no => $val) { ?>
                                                        <a href="/download/download/<?=$val->file_id ?>"><?=$val->file_name_org ?></a><br>
<?php   } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-warning ml-3" id="list" name="list">목록</button>
<?php   if (getUserSessionInfo("member_id") == $info->ins_id) { ?>
                                        <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                        <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
<?php   } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php   if (count($comment_list) > 0) { ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap table-hover">
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
                                        </div>
                                        <dl class="row">
                                            <dd class="col-sm-11 text-right">총 댓글수</td>
                                            <dd class="col-sm-1 text-center"><?=count($comment_list) ?></td>
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
<?php   if (getUserSessionInfo("member_id") === null) { ?>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="comment" name="comment" rows="4" disabled>댓글은 로그인후 작성이 가능합니다.</textarea>
                                            </div>
                                            <button type="button" class="btn btn-info float-right">등록</button>
<?php   } else { ?>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-info float-right" id="comment_insert" name="comment_insert">등록</button>
<?php   } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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