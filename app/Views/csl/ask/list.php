<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>간편문의</h1>
                </div>
            </div>
        </div>
    </section>

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
                                        <option value="name">이름</option>
                                        <option value="phone">전화</option>
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>번호</th>
                                            <th>이름</th>
                                            <th>전화</th>
                                            <th>입력일</th>
                                            <th>작업</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php   foreach($list as $no => $val) { ?>
                                        <tr>
                                            <td><?=$val->list_no ?></td>
                                            <td><?=$val->name ?></td>
                                            <td><?=$val->phone ?></td>
                                            <td><?=$val->ins_date_txt ?></td>
                                            <td><button type="button" class="btn btn-danger btn-xs" id="delete" name="delete" onclick="ask_delete(<?=$val->a_idx ?>)">삭제</button></td>
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
                        </div>
                        <div class="card-footer clearfix">
<?=$paging_info["paging_view"] ?>
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
        $("#li-ask-list").addClass("menu-open");
        $("#upper-ask-list").addClass("active");
        $("#a-ask-list").addClass("active");

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
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        var rows = $("#rows").val();
        location.href = "/csl/slide/list?page=1&search_text="+search_text+"&search_condition="+search_condition+"&rows="+rows;
    }

    function ask_delete(a_idx) {
        if (confirm("삭제하시겠습니까?")) {
            ajax2("/csl/ask/delete/"+a_idx);
        }
    }
</script>
