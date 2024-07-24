<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>슬라이드</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">홈</a></li>
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
                                                <th>제목</th>
                                                <td><?=$info->title ?></td>
                                            </tr>
                                            <tr>
                                                <th>링크</th>
                                                <td><?=$info->http_link ?></td>
                                            </tr>
                                            <tr>
                                                <th>QR용 링크</th>
                                                <td><?=env("app.baseURL") ?>/s/<?=$info->sl_idx ?></td>
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
        $("#li-shortlink-list").addClass("menu-open");
        $("#upper-shortlink-list").addClass("active");
        $("#a-shortlink-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/shortlink/edit/<?=$info->sl_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/shortlink/list";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/shortlink/delete/<?=$info->sl_idx ?>");
            }
        });
    });

</script>
