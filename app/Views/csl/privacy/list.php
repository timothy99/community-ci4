<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>개인정보 처리시스템</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item active">개인정보 처리시스템</li>
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
                            <h3 class="card-title">총 <?=number_format($cnt) ?> 건</h3>
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
                                        <option value="member_id">아이디</option>
                                    </select>
                                    <input type="text" id="search_text" name="search_text" class="form-control float-right ml-2" placeholder="검색어">
                                    <button type="button" class="btn btn-sm btn-warning float-right ml-3" id="search_button" name="search_button">검색</button>
                                    <button type="button" class="btn btn-sm btn-success float-right ml-3" id="excel" name="excel">엑셀다운로드</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-responsive-md text-nowrap table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>번호</th>
                                        <th>링크</th>
                                        <th>메모</th>
                                        <th>작업자</th>
                                        <th>입력일</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php   foreach($list as $no => $val) { ?>
                                    <tr>
                                        <td><?=$val->list_no ?></td>
                                        <td><a href="<?=$val->http_link ?>" target="_blank"><?=$val->http_link ?></a></td>
                                        <td><?=$val->memo ?></td>
                                        <td><?=$val->ins_id ?></td>
                                        <td><?=$val->ins_date_txt ?></td>
                                    </tr>
<?php   } ?>
<?php   if (count($list) == 0) { ?>
                                    <tr>
                                        <td colspan="5" class="text-center">데이터가 없습니다.</td>
                                    </tr>
<?php   } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
<?=$paging_info["paging_view"] ?>
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
        $("#upper-privacy-list").addClass("active");
        $("#a-privacy-list").addClass("active");

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

        $("#excel").click(function(e) {
            excel();
        });

        $("#auth_group").change(function(e) {
            search();
        });

        $("#write").click(function(e) {
            location.href = "/csl/member/write";
        });
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        var auth_group = $("#auth_group").val();
        var rows = $("#rows").val();
        location.href = "/csl/member/list?page=1&auth_group="+auth_group+"&search_text="+search_text+"&search_condition="+search_condition+"&rows="+rows;
    }

    function excel() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        var auth_group = $("#auth_group").val();
        location.href = "/csl/member/excel?page=1&auth_group="+auth_group+"&search_text="+search_text+"&search_condition="+search_condition;
    }
</script>