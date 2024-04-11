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
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title m-0">최신 공지사항</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th>제목</th>
                                                <th>날짜</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php   foreach($notice_list as $no => $val) { ?>
                                            <tr>
                                                <td><a href="/board/notice/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
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
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title m-0">최신 자유게시판</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th>제목</th>
                                                <th>날짜</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php   foreach($free_list as $no => $val) { ?>
                                            <tr>
                                                <td><a href="/board/free/view/<?=$val->b_idx ?>"><?=$val->title ?></a></td>
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
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.content -->
        </div><!-- /.content-wrapper -->
