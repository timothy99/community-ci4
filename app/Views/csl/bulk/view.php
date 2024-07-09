<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>벌크 상세</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item active">벌크 상세</li>
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
                                <table class="table table-bordered table-responsive-md text-nowrap table-hover">
                                    <tbody>
                                        <tr>
                                            <th>이름</th>
                                            <td><?=$info->member_name ?></td>
                                        </tr>
                                        <tr>
                                            <th>이메일</th>
                                            <td><?=$info->email ?></td>
                                        </tr>
                                        <tr>
                                            <th>전화</th>
                                            <td><?=$info->phone ?></td>
                                        </tr>
                                        <tr>
                                            <th>성별</th>
                                            <td><?=$info->gender ?></td>
                                        </tr>
                                        <tr>
                                            <th>우편번호</th>
                                            <td><?=$info->post_code ?></td>
                                        </tr>
                                        <tr>
                                            <th>주소1</th>
                                            <td><?=$info->addr1 ?></td>
                                        </tr>
                                        <tr>
                                            <th>주소2</th>
                                            <td><?=$info->addr1 ?></td>
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
        $("#li-slide-list").addClass("menu-open");
        $("#upper-slide-list").addClass("active");
        $("#a-slide-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/bulk/edit/<?=$info->bd_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/bulk/detail/<?=$info->b_idx ?>";
        });

        $("#delete").click(function(e) {
            if(confirm("삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/bulk/delete/<?=$info->b_idx ?>/<?=$info->bd_idx ?>");
            }
        });
    });

</script>