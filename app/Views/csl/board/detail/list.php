<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$config->title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item active">게시판</li>
                        <li class="breadcrumb-item active"><?=$config->title ?></li>
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
                            <h3 class="card-title">총 <?=number_format($data["cnt"]) ?> 건</h3>
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
<?php   if ($config->category_yn == "Y") { ?>
                                    <select class="form-control ml-3" id="category" name="category" onchange="search()">
                                        <option value="">분류</option>
<?php       foreach ($config->category_arr as $no => $val) { ?>
                                        <option value="<?=$val ?>"><?=$val ?></option>
<?php       } ?>

                                    </select>
<?php   } ?>
                                    <select class="form-control ml-3" id="search_condition" name="search_condition">
                                        <option value="title">제목</option>
                                        <option value="contents">내용</option>
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
<?php   if ($config->category_yn == "Y") { ?>
                                        <th>분류</th>
<?php   } ?>
                                        <th>제목</th>
                                        <th>입력자</th>
<?php   if ($config->reg_date_yn == "Y") { ?>
                                        <th>등록일</th>
<?php   } ?>
                                        <th>입력일</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php   foreach($notice_list as $no => $val) { ?>
                                    <tr>
                                        <td>공지</td>
<?php   if ($config->category_yn == "Y") { ?>
                                        <td><?=$val->category ?></td>
<?php   } ?>
                                        <td><a href="/csl/board/<?=$data["board_id"] ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
                                        <td><?=$val->ins_id ?></td>
<?php   if ($config->reg_date_yn == "Y") { ?>
                                        <td><?=$val->reg_date_txt ?></td>
<?php   } ?>
                                        <td><?=$val->ins_date_txt ?></td>
                                    </tr>
<?php   } ?>

<?php   foreach($list as $no => $val) { ?>
                                    <tr>
                                        <td><?=$val->list_no ?></td>
<?php   if ($config->category_yn == "Y") { ?>
                                        <td><?=$val->category ?></td>
<?php   } ?>
                                        <td><a href="/csl/board/<?=$data["board_id"] ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
                                        <td><?=$val->ins_id ?></td>
<?php   if ($config->reg_date_yn == "Y") { ?>
                                        <td><?=$val->reg_date_txt ?></td>
<?php   } ?>
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
        $("#li-board-config-list").addClass("menu-open");
        $("#upper-board-config-list").addClass("active");
        $("#a-board-manage-list").addClass("active");

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
            location.href = "/csl/board/<?=$data["board_id"] ?>/write";
        });
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        var category = $("#category").val();
        var rows = $("#rows").val();
        location.href = "/csl/board/<?=$data["board_id"] ?>/list?page=1&search_text="+search_text+"&search_condition="+search_condition+"&rows="+rows+"&category="+category;
    }
</script>