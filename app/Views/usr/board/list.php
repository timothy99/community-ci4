        <div class="container">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">총 <?=number_format($cnt) ?>건</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <select class="form-control" id="search_condition" name="search_condition">
                                        <option value="title">제목</option>
                                        <option value="contents">내용</option>
                                    </select>
                                    <input type="text" id="search_text" name="search_text" class="form-control float-right ml-3" placeholder="검색어를 입력하세요" value="<?=$search_arr["search_text"] ?>">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-default" id="search_button" name="search_button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>제목</th>
                                        <th>등록일</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php   foreach ($list as $no => $val) { ?>
                                    <tr>
                                        <td class="text-center"><?=$val->list_no ?></td>
                                        <td><a href="/board/<?=$board_id ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></td>
                                        <td><?=$val->ins_date_txt ?></td>
                                    </tr>
<?php   } ?>
<?php   if (count($list) == 0) { ?>
                                    <tr>
                                        <td colspan="5" class="text-center">데이터가 없습니다</td>
                                    </tr>
<?php   } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clear-fix">
<?=$paging_view ?>
<?php   if ($board_id != "notice") { ?>
                            <button type="button" class="btn btn-info float-right" id="write" name="write">글쓰기</button>
<?php   } ?>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
    $(window).on("load", function() {
        // 셀렉트 박스 선택
        $("#search_condition").val("<?=$search_arr["search_condition"] ?>").prop("selected", true);
        $("#search_text").val("<?=$search_arr["search_text"] ?>");
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

        $("#write").click(function(e) {
            location.href = "/board/<?=$board_id ?>/write";
        });
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        location.href = "/board/<?=$board_id ?>/list?page=1&search_text="+search_text+"&search_condition="+search_condition;
    }
</script>
