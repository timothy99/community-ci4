    <form id="frm" name="frm">
        <div id="hd_pop">
            <h2>팝업레이어 알림</h2>
<?php   foreach($popup_list as $no => $val) { ?>
            <div id="popup_<?=$val->p_idx ?>" class="hd_pops" style="top:<?=$val->position_top ?>px;left:<?=$val->position_left ?>px">
                <div class="hd_pops_con" style="width:<?=$val->popup_width ?>px;height:<?=$val->popup_height ?>px">
                    <p><img src="/file/view/<?=$val->popup_file ?>" alt="<?=$val->title ?>" class="img-fluid"></p>
                </div>
                <div class="hd_pops_footer">
                    <button class="hd_pops_reject" onclick="popup_disabled(<?=$val->p_idx ?>, <?=$val->disabled_hours ?>)"><strong><?=$val->disabled_hours ?></strong>시간 동안 다시 열람하지 않습니다.</button>
                    <button class="hd_pops_close" onclick="popup_close(<?=$val->p_idx ?>)">닫기 <i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
            </div>
<?php   } ?>
        </div>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>대시보드</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">홈</a></li>
                                <li class="breadcrumb-item active">대시보드</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container -->
            </section>

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
                                <div class="carousel-inner">
<?php   foreach ($slide_list as $no => $val) { ?>
                                    <div class="carousel-item <?=$val->active_class ?>">
                                        <img src="/file/view/<?=$val->slide_file ?>" class="d-block w-100" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5><?=$val->title ?></h5>
                                            <p><?=$val->contents ?></p>
                                        </div>
                                    </div>
<?php   } ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title m-0">간편문의</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="title" class="col-sm-2 col-form-label">이름</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="이름을 입력하세요">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="contents" class="col-sm-2 col-form-label">연락처</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="agree_yn" name="agree_yn" value="Y">
                                                <label class="form-check-label" for="agree_yn">약관동의</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row d-flex justify-content-end">
                                        <button type="button" class="btn btn-info mt-3 mb-2 mr-5 col-sm-2" id="save" name="save" onclick="ask_write()">등록</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title m-0">최신 공지사항</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap table-hover">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>제목</th>
                                                    <th>입력일</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php   foreach($notice_list as $no => $val) { ?>
                                                <tr>
                                                    <td><a href="/board/<?=$val->board_id ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
                                                    <td><?=$val->ins_date_txt ?></td>
                                                </tr>
<?php   } ?>
<?php   if (count($notice_list) == 0) { ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">데이터가 없습니다.</td>
                                                </tr>
<?php   } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title m-0">최신 자유게시판</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap table-hover">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>제목</th>
                                                    <th>입력일</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php   foreach($free_list as $no => $val) { ?>
                                                <tr>
                                                    <td><a href="/board/<?=$val->board_id ?>/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
                                                    <td><?=$val->ins_date_txt ?></td>
                                                </tr>
<?php   } ?>
<?php   if (count($free_list) == 0) { ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">데이터가 없습니다.</td>
                                                </tr>
<?php   } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title m-0">너튜브</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
<?php   foreach ($video_list as $no => $val) { ?>
                                        <div class="col-md-3 d-flex justify-content-center">
                                            <object type="text/html" data="//www.youtube.com/embed/<?=$val->video_id ?>" style="width:90%"></object>
                                        </div>
<?php   } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.content -->
        </div><!-- /.content-wrapper -->
    </form>

<script>
    $(window).on("load", function() {
        $("#phone").inputmask("9{1,3}-9{1,4}-9{1,4}");
    });

    function popup_close(p_idx) {
        $("#popup_"+p_idx).remove();
    }

    function popup_disabled(p_idx, disabled_hours) {
        ajax7("/popup/disabled/"+p_idx+"/"+disabled_hours);
        $("#popup_"+p_idx).remove();
    }

    function ask_write() {
        ajax1("/ask/write", "frm");
    }
</script>