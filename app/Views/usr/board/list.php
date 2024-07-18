        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
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
                </div><!-- /.container -->
            </section>

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">총 <?=number_format($cnt) ?>건</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm">
                                            목록수
                                            <select class="form-control ml-3" id="rows" name="rows" onchange="search()">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                                <option value="60">60</option>
                                                <option value="70">70</option>
                                                <option value="80">80</option>
                                                <option value="90">90</option>
                                                <option value="100">100</option>
                                            </select>
                                            <select class="form-control ml-3" id="search_condition" name="search_condition">
                                                <option value="title">제목</option>
                                                <option value="contents">내용</option>
                                            </select>
                                            <input type="text" id="search_text" name="search_text" class="form-control float-right ml-3" placeholder="검색어를 입력하세요" value="<?=$data["search_arr"]["search_text"] ?>">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-default" id="search_button" name="search_button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive text-nowrap table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th>#</th>
                                                <th>제목</th>
                                                <th>입력일</th>
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
<?=$paging_info["paging_view"] ?>
<?php   if ($board_id != "notice") { ?>
                                    <button type="button" class="btn btn-info float-right" id="write" name="write">글쓰기</button>
<?php   } ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.content -->
        </div><!-- /.content-wrapper -->

<script>
    $(window).on("load", function() {
        // 셀렉트 박스 선택
        $("#search_condition").val("<?=$data["search_arr"]["search_condition"] ?>").prop("selected", true);
        $("#search_text").val("<?=$data["search_arr"]["search_text"] ?>");
        $("#rows").val("<?=$data["search_arr"]["rows"] ?>").prop("selected", true);
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
        var rows = $("#rows").val();
        location.href = "/board/<?=$board_id ?>/list?page=1&search_text="+search_text+"&search_condition="+search_condition+"&rows="+rows;
    }
</script>
