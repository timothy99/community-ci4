<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>유튜브</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item">유튜브</li>
                        <li class="breadcrumb-item active">쓰기</li>
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
                                                <th>분류</th>
                                                <td><?=$info->category ?></td>
                                            </tr>
                                            <tr>
                                                <th>재생 아이디</th>
                                                <td><?=$info->play_id ?></td>
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

            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">샘플재생목록 - 최근 5개의 영상을 보여줍니다</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th>영상</th>
                                                <th>썸네일</th>
                                                <th>채널명</th>
                                                <th>제목</th>
                                                <th>입력일</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php   foreach ($list as $no => $val) { ?>
                                            <tr>
                                                <td><object type="text/html" data="//www.youtube.com/embed/<?=$val->video_id ?>"></object></td>
                                                <td><img src="<?=$val->thumbnail_default ?>"></td>
                                                <td><?=$val->channel_title ?></td>
                                                <td><?=$val->title ?></td>
                                                <td><?=$val->publish_time ?></td>
                                            </tr>
<?php   } ?>
<?php   if ($result == false) { ?>
                                            <tr>
                                                <td colspan="5">설정이 올바르지 않습니다. 채널 아이디나 분류를 다시 확인해주세요.</td>
                                            </tr>
<?php   } ?>
                                        </tbody>
                                    </table>
                                </div>
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
        $("#li-youtube-list").addClass("menu-open");
        $("#upper-youtube-list").addClass("active");
        $("#a-youtube-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/youtube/edit/<?=$info->y_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/youtube/list";
        });

        $("#delete").click(function(e) {
            if(confirm("글을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/youtube/delete/<?=$info->y_idx ?>");
            }
        });
    });
</script>
