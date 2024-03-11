<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">게시판</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">쓰기</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                        <form class="user">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="post_code" name="post_code" placeholder="우편번호" readonly="">
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-info btn-user btn-block" onclick="postcode_open()">검색</button>
                                </div>
                            </div>
                        </form>
                </div>

            </div>







            <div class="table-responsive">



            </div>
            <div class="d-flex justify-content-center">
                <a href="/csl/board/<?=$board_id ?>/write" type="button" class="btn btn-info float-right">글쓰기</a>

            </div>
            
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
