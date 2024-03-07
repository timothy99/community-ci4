<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">공지사항</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">목록</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>등록자</th>
                            <th>날짜</th>
                            <th>조회수</th>
                        </tr>
                    </thead>
                    <tbody>
<?php   foreach($list as $no => $val) { ?>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
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
            <div class="d-flex justify-content-center">
<?=$paging_view ?>
            </div>
        </div>
        <div class="card-footer">
            <form id="frm" name="frm">
                <div class="row">
                    <div class="col-md-3 col-sm-hidden col-xs-hidden"></div>
                    <div class="col-md-6 col-flex d-flex justify-content-center">
                        <select id="search_condition" name="search_condition" class="form-control form-control-inline">
                            <option value="" selected disabled>전체</option>
                            <option value="title">제목</option>
                            <option value="contents">내용</option>
                        </select>
                        <input type="text" id="search_text" name="search_text" class="form-control form-control-inline" value="<?=$search_arr["search_text"] ?>">
                        <button type="button" id="search_button" name="search_button" class="btn btn-info btn-inline">검색</button>
                        <a href="/board/<?=$board_id ?>/list" type="button" id="cancel_button" name="cancel_button" class="btn btn-warning btn-inline">취소</a>
                    </div>
                    <div class="col-md-3 col-sm-hidden col-xs-hidden"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-board-notice-upper").addClass("active");
        $("#a-board-notice").addClass("active");

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
