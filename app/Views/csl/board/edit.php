<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">게시판</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">쓰기</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">



            </div>
            <div class="d-flex justify-content-center">

            </div>
            <a href="/csl/board/<?=$board_id ?>/write" type="button" class="btn btn-info float-right">글쓰기</a>
        </div>
    </div>
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-board-notice-list").addClass("active");
        $("#div-board-notice-list").addClass("show");
        $("#a-board-notice-list").addClass("active");
        $("#a-board-notice-list-upper").removeClass("collapsed");
    });
</script>
