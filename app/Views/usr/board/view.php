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
<?php   if (count($comment_list) > 0) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <table class="table">
                                    <tbody>
<?php       foreach($comment_list as $no => $val) { ?>
<form id="frm_<?=$val->bc_idx ?>" name="frm_<?=$val->bc_idx ?>"><input type="hidden" id="ddd" name="ddd" value="123"></form>
                                        <tr id="bc_<?=$val->bc_idx ?>">
                                            <td><?=$val->comment ?></td>
                                            <td style="width:70px"><button type="button" class="btn btn-xs btn-danger" id="comment_delete" name="comment_delete" onclick="comment_delete(<?=$val->bc_idx ?>)">삭제</button></td>
                                            <td style="width:70px"><button type="button" class="btn btn-xs btn-success" id="comment_edit" name="comment_edit" onclick="comment_edit(<?=$val->bc_idx ?>)">수정</button></td>
                                        </tr>
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
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
    $(window).on("load", function() {
        // 셀렉트 박스 선택
        $("#search_condition").val("<?=$search_arr["search_condition"] ?>").prop("selected", true);
    });

    $(function() {
        $("#search_text").keydown(function(e) {
            if(e.keyCode == 13) {
                search();
            }
        });

        $("#search_button").click(function(e) {
            search();
        });
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        location.href = "/board/<?=$board_id ?>/list?page=1&search_text="+search_text+"&search_condition="+search_condition;
    }
</script>
