<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>단축url</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">홈</a></li>
                        <li class="breadcrumb-item active">단축url</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">목록</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <select class="form-control" id="search_condition" name="search_condition">
                                        <option value="title">제목</option>
                                    </select>
                                    <input type="text" id="search_text" name="search_text" class="form-control float-right ml-2" placeholder="검색">
                                    <div class="input-group-append">
                                    <button type="button" class="btn btn-default" id="search_button" name="search_button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>번호</th>
                                        <th>제목</th>
                                        <th>등록자</th>
                                        <th>날짜</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php   foreach($list as $no => $val) { ?>
                                    <tr>
                                        <td><?=$val->list_no ?></td>
                                        <td><a href="/csl/shortlink/view/<?=$val->sl_idx ?>"><?=$val->title ?></a></td>
                                        <td><?=$val->ins_id ?></td>
                                        <td><?=$val->ins_date_txt ?></td>
                                    </tr>
<?php   } ?>
<?php   if (count($list) == 0) { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">데이터가 없습니다.</td>
                                    </tr>
<?php   } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
<?=$paging_info["paging_view"] ?>
                            <button type="button" class="btn btn-info float-right" id="write" name="write">글쓰기</button>
                        </div>
                    </div>
                    <!-- /.card -->
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
        $("#li-shortlink-list").addClass("menu-open");
        $("#upper-shortlink-list").addClass("active");
        $("#a-shortlink-list").addClass("active");

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
            location.href = "/csl/shortlink/write";
        });
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        location.href = "/csl/shortlink/list?page=1&search_text="+search_text+"&search_condition="+search_condition;
    }
</script>