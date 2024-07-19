<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>레이어 팝업</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item active">레이어 팝업</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">상세보기</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap table-hover">
                                        <tbody>
                                            <tr>
                                                <th style="min-width:130px;">제목</th>
                                                <td><?=$info->title ?></td>
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
                                                <th>좌측 위치</th>
                                                <td><?=$info->position_left ?>px</td>
                                            </tr>
                                            <tr>
                                                <th>상단 위치</th>
                                                <td><?=$info->position_top ?>px</td>
                                            </tr>
                                            <tr>
                                                <th>너비</th>
                                                <td><?=$info->popup_width ?>px</td>
                                            </tr>
                                            <tr>
                                                <th>높이</th>
                                                <td><?=$info->popup_height ?>px</td>
                                            </tr>
                                            <tr>
                                                <th>안보이는 시간</th>
                                                <td><?=$info->disabled_hours ?>시간 / <?=number_format($info->disabled_hours/24, 1) ?>일</td>
                                            </tr>
                                            <tr>
                                                <th>이미지</th>
                                                <td>
                                                    <img src="/csl/file/view/<?=$info->popup_file ?>" class="img-fluid"><br>
                                                    실제크기 : <?=$info->popup_file_info->image_width ?>px * <?=$info->popup_file_info->image_height ?>px
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

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-popup-list").addClass("menu-open");
        $("#upper-popup-list").addClass("active");
        $("#a-popup-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/popup/edit/<?=$info->p_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/popup/list";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/popup/delete/<?=$info->p_idx ?>");
            }
        });
    });

</script>