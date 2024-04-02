<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>회원</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">홈</a></li>
                        <li class="breadcrumb-item active">회원</li>
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
                                    <select class="form-control" id="auth_group" name="auth_group">
                                        <option value="">전체</option>
                                        <option value="common">일반</option>
                                        <option value="admin">관리자</option>
                                    </select>
                                    <select class="form-control ml-3" id="search_condition" name="search_condition">
                                        <option value="member_id">아이디</option>
                                        <option value="member_name">이름</option>
                                    </select>
                                    <input type="text" id="search_text" name="search_text" class="form-control float-right ml-2" placeholder="검색어">
                                    <button type="button" class="btn btn-sm btn-warning float-right ml-3" id="search_button" name="search_button">검색</button>
                                    <button type="button" class="btn btn-sm btn-success float-right ml-3" id="excel" name="excel">엑셀다운로드</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>번호</th>
                                        <th>아이디</th>
                                        <th>이름</th>
                                        <th>그룹</th>
                                        <th>연락처</th>
                                        <th>가입일</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php   foreach($list as $no => $val) { ?>
                                    <tr>
                                        <td><?=$val->list_no ?></td>
                                        <td><a href="/csl/member/view/<?=$val->member_id ?>"><?=$val->member_id ?></a></td>
                                        <td><?=$val->member_name ?></td>
                                        <td><?=$val->auth_group ?></td>
                                        <td><?=$val->phone ?></td>
                                        <td><?=$val->ins_date_txt ?></td>
                                    </tr>
<?php   } ?>
<?php   if (count($list) == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">데이터가 없습니다.</td>
                                    </tr>
<?php   } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
<?=$paging_view ?>
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
        $("#upper-member-list").addClass("active");
        $("#a-member-list").addClass("active");

        // 셀렉트 박스 선택
        $("#search_condition").val("<?=$search_arr["search_condition"] ?>").prop("selected", true);
        $("#search_text").val("<?=$search_arr["search_text"] ?>");
        $("#auth_group").val("<?=$search_arr["auth_group"] ?>").prop("selected", true);
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
        location.href = "/csl/member/list?page=1&auth_group="+auth_group+"&search_text="+search_text+"&search_condition="+search_condition;
    }

    function excel() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        var auth_group = $("#auth_group").val();
        location.href = "/csl/member/excel?page=1&auth_group="+auth_group+"&search_text="+search_text+"&search_condition="+search_condition;
    }
</script>