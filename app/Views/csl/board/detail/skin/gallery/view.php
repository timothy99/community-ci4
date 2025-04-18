<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$config->title ?></h1>
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
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <th style="min-width:150px;">공지여부</th>
                                                <td><?=$info->notice_yn ?></td>
                                            </tr>
<?php   if ($config->category_yn == "Y") { ?>
                                            <tr>
                                                <th>분류</th>
                                                <td><?=$info->category ?></td>
                                            </tr>
<?php   } ?>
<?php   if ($config->reg_date_yn == "Y") { ?>
                                            <tr>
                                                <th>등록일</th>
                                                <td><?=$info->reg_date_txt ?></td>
                                            </tr>
<?php   } ?>
                                            <tr>
                                                <th>내용</th>
                                                <td><?=$info->contents ?></td>
                                            </tr>
                                            <tr>
                                                <th>입력자</th>
                                                <td><?=$info->member_info->member_nickname ?>[<?=$info->ins_id ?>]</td>
                                            </tr>
                                            <tr>
                                                <th>입력일</th>
                                                <td><?=$info->ins_date_txt ?></td>
                                            </tr>
                                            <tr>
                                                <th>첨부파일</th>
                                                <td>
<?php
        foreach ($file_list as $no => $val) {
            if ($val->category == "image") {
?>
                                                    <img src="/download/download/<?=$val->file_id ?>" width="150px"><br>
<?php       } else { ?>
                                                    <a href="/download/download/<?=$val->file_id ?>"><?=$val->file_name_org ?></a><br>
<?php
            }
        }
?>
                                                </td>
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
                                            <form id="frm_<?=$val->bc_idx ?>" name="frm_<?=$val->bc_idx ?>"><input type="hidden" id="ddd" name="ddd" value="123"></form>
                                            <tr id="bc_<?=$val->bc_idx ?>">
                                                <td><?=$val->ins_id ?></td>
                                                <td><?=$val->comment ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger" id="comment_delete" name="comment_delete" onclick="comment_delete(<?=$val->bc_idx ?>)">삭제</button>
                                                    <button type="button" class="btn btn-sm btn-success" id="comment_edit" name="comment_edit" onclick="comment_edit(<?=$val->bc_idx ?>)">수정</button>
                                                </td>
                                            </tr>
<?php       } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <dl class="row">
                                <dd class="col-sm-11 text-right">총 댓글수</td>
                                <dd class="col-sm-1 text-center"><?=count($comment_list) ?></td>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
<?php   } ?>
<?php   if ($config->comment_write == "예") { ?>
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
<?php   } ?>
        </div>
    </section>
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-board-config-list").addClass("menu-open");
        $("#upper-board-config-list").addClass("active");
        $("#a-board-manage-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/board/<?=$board_id ?>/edit/<?=$info->b_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/board/<?=$board_id ?>/list";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/board/<?=$board_id ?>/delete/<?=$info->b_idx ?>");
            }
        });

        $("#comment_insert").click(function(e) {
            ajax1("/csl/comment/insert", "insert_frm");
        });
    });

    function comment_edit(bc_idx) {
        ajax4("/csl/comment/edit/"+bc_idx, "bc_"+bc_idx);
    }

    function comment_update(bc_idx) {
        var update_form = new FormData();
        var comment = $("#comment_"+bc_idx).val();
        update_form.append("bc_idx", bc_idx);
        update_form.append("comment", comment);
        ajax5("/csl/comment/update", update_form);
    }

    function comment_delete(bc_idx) {
        if(confirm("댓글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
            ajax2("/csl/comment/delete/"+bc_idx);
        }
    }
</script>
