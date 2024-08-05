<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>슬라이드</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item active">슬라이드</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">상세보기</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap table-hover">
                                        <tbody>
                                            <tr>
                                                <th style="min-width:150px;max-width:170px;">정렬순서</th>
                                                <td><?=$info->order_no ?></td>
                                            </tr>
                                            <tr>
                                                <th>제목</th>
                                                <td><?=$info->title ?></td>
                                            </tr>
                                            <tr>
                                                <th>내용</th>
                                                <td><?=$info->contents ?></td>
                                            </tr>
                                            <tr>
                                                <th>링크</th>
                                                <td><?=$info->http_link ?></td>
                                            </tr>
                                            <tr>
                                                <th>게시기간</th>
                                                <td><?=$info->start_date_txt ?> ~ <?=$info->end_date_txt ?></td>
                                            </tr>
                                            <tr>
                                                <th>노출여부</th>
                                                <td><?=$info->display_yn ?></td>
                                            </tr>
                                            <tr>
                                                <th>이미지</th>
                                                <td>
                                                    <img src="/download/view/<?=$info->slide_file ?>" class="img-fluid"><br>
                                                    실제크기 : <?=$info->slide_file_info->image_width ?>px * <?=$info->slide_file_info->image_height ?>px
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>입력자</th>
                                                <td><?=$info->ins_id ?></td>
                                            </tr>
                                            <tr>
                                                <th>입력일</th>
                                                <td><?=$info->ins_date_txt ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-warning ml-3" id="list" name="list">목록</button>
                                <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
                            </div>
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
        $("#li-slide-list").addClass("menu-open");
        $("#upper-slide-list").addClass("active");
        $("#a-slide-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/slide/edit/<?=$info->s_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/slide/list";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/slide/delete/<?=$info->s_idx ?>");
            }
        });
    });
</script>
