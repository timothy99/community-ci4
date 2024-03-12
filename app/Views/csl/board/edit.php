<form class="user">
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
                        <label for="title">제목</label>
                        <input type="text" class="form-control" id="title" placeholder="제목을 입력하세요">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="title">내용</label>
                        <textarea class="form-control" id="contents" rows="6"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="title">첨부파일</label>
                        <input type="file" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card-footer">

                <div class="d-flex justify-content-end">
                    <a href="/csl/board/<?=$board_id ?>/write" type="button" class="btn btn-danger btn-inline">취소</a>
                    <a href="/csl/board/<?=$board_id ?>/write" type="button" class="btn btn-primary btn-inline">등록</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-board-notice-list").addClass("active");
        $("#div-board-notice-list").addClass("show");
        $("#a-board-notice-list").addClass("active");
        $("#a-board-notice-list-upper").removeClass("collapsed");
    });
</script>
