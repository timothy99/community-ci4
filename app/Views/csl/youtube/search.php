<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
                        <li class="breadcrumb-item active">검색</li>
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
                                <div class="form-group row">
                                    <label for="search_text" class="col-sm-2 col-form-label">검색</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="search_text" name="search_text"  value="<?=$data["search_text"] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-info ml-3" id="search" name="search">검색</button>
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
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th>영상</th>
                                                <th>썸네일</th>
                                                <th>영상ID</th>
                                                <th>채널ID</th>
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
                                                <td><?=$val->video_id ?></td>
                                                <td><?=$val->channel_id ?></td>
                                                <td><?=$val->channel_title ?></td>
                                                <td><?=$val->title ?></td>
                                                <td><?=$val->publish_time ?></td>
                                            </tr>
<?php   } ?>
<?php   if (count($list) == 0) { ?>
                                            <tr>
                                                <td colspan="5">검색어를 입력하시거나 정확한 검색어를 넣어주세요.</td>
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

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-youtube-list").addClass("menu-open");
        $("#upper-youtube-list").addClass("active");
        $("#a-youtube-search").addClass("active");
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
        location.href = "/csl/youtube/search?search_text="+search_text;
    }

</script>