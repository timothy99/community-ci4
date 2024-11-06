<input type="hidden" id="search_open" name="search_open" value="<?=$data["search_arr"]["search_open"] ?>">
<input type="hidden" id="category" name="category" value="<?=$data["search_arr"]["category"] ?>">

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
                <div class="col-md-12">
                    <div class="card card-success shadow-sm <?=$data["search_arr"]["collapsed_card"] ?>">
                        <div class="card-header">
                            <h3 class="card-title">검색</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <button type="button" class="btn btn-primary btn-sm ml-3" data-card-widget="collapse" onclick="change_collapse()">
<?php   if ($data["search_arr"]["search_open"] == "Y") { ?>
                                        <i class="fas fa-minus"></i>
<?php   } else { ?>
                                        <i class="fas fa-plus"></i>
<?php   } ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display:<?=$data["search_arr"]["display_type"] ?>;">
                            <div class="d-flex mb-3">
                                <div class="col-md-6">
                                    <select class="form-control" id="search_condition" name="search_condition">
                                        <option value="title">제목</option>
                                        <option value="contents">내용</option>
                                    </select>
                                </div>
                                <div class="col-md-6 ml-2">
                                    <input type="text" id="search_text" name="search_text" class="form-control" value="<?=$data["search_arr"]["search_text"] ?>" placeholder="검색어를 입력하세요">
                                </div>
                            </div>
                            <div class="d-flex">
<?php   if ($config->category_yn == "Y") { ?>
                                <div class="col-md-12 input-group input-group-sm">
                                    분류 : 
<?php       foreach ($config->category_arr as $no => $val) { ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm ml-3" onclick="search_category('<?=$val ?>')" value="<?=$val ?>"><?=$val ?></button>
<?php       } ?>
                                </div>
<?php   } ?>
                            </div>
                            <div class="d-flex mt-3 justify-content-end">
                                <a href="/csl/board/<?=$data["board_id"] ?>/list" class="btn btn-secondary">초기화</a>
                                <button type="button" class="btn btn-info ml-3" id="search_button" name="search_button">검색</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap table-hover">
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
<?php       if ($config->category_yn == "Y") { ?>
                                            <td><?=$val->category ?></td>
<?php       } ?>
                                            <td><a href="/csl/board/<?=$data["board_id"] ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
                                            <td><?=$val->member_info->member_nickname ?></td>
<?php       if ($config->reg_date_yn == "Y") { ?>
                                            <td><?=$val->reg_date_txt ?></td>
<?php       } ?>
                                            <td><?=$val->ins_date_txt ?></td>
                                        </tr>
<?php   } ?>

<?php   foreach($list as $no => $val) { ?>
                                        <tr>
                                            <td><?=$val->list_no ?></td>
<?php       if ($config->category_yn == "Y") { ?>
                                            <td><?=$val->category ?></td>
<?php       } ?>
                                            <td><a href="/csl/board/<?=$data["board_id"] ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
                                            <td><?=$val->member_info->member_nickname ?></td>
<?php       if ($config->reg_date_yn == "Y") { ?>
                                            <td><?=$val->reg_date_txt ?></td>
<?php       } ?>
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
                        </div>
                        <div class="card-footer clearfix">
<?=$paging_info["paging_view"] ?>
                            <button type="button" class="btn btn-info float-right" id="write" name="write">글쓰기</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        $("button[value='<?=$data["search_arr"]["category"] ?>']").removeClass("btn-outline-primary");
        $("button[value='<?=$data["search_arr"]["category"] ?>']").addClass("btn-primary");
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
        var search_open = $("#search_open").val();
        location.href = "/csl/board/<?=$data["board_id"] ?>/list?page=1&search_text="+search_text+"&search_condition="+search_condition+"&rows="+rows+"&category="+category+"&search_open="+search_open;
    }

    function change_collapse() {
        var search_open = $("#search_open").val();
        if (search_open == "Y") {
            $("#search_open").val("N");
        } else {
            $("#search_open").val("Y");
        }
        search();
    }

    function search_category(category) {
        $("#category").val(category);
        search();
    }
</script>
