    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?=$title_info->title ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><?=$title_info->bread_crumb ?></li>
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
                                <h3 class="card-title m-0">회원정보</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>아이디</th>
                                                    <td><?=$info->member_id ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">탈퇴 하시겠습니까? 블라블라</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clear-fix d-flex justify-content-end">
                                <button type="button" class="btn btn-danger ml-3" id="leave" name="leave">탈퇴</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div><!-- /.content -->
    </div><!-- /.content-wrapper -->


<script>
    $(function() {
        $("#edit").click(function(e) {
            location.href = "/member/edit"
        });

        $("#leave").click(function(e) {
            if (confirm("탈퇴하면 모든 데이터가 삭제됩니다. 탈퇴하시겠습니까?")) {
                ajax1("/member/delete", "frm");
            }
        });
    });
</script>
