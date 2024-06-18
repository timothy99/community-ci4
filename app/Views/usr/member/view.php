    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>회원정보</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">홈</a></li>
                            <li class="breadcrumb-item active">회원정보</li>
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
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>아이디</th>
                                            <td><?=$info->member_id ?></td>
                                        </tr>
                                        <tr>
                                            <th>이름</th>
                                            <td><?=$info->member_name ?></td>
                                        </tr>
                                        <tr>
                                            <th>별명</th>
                                            <td><?=$info->member_nickname ?></td>
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
                                            <th>우편번호</th>
                                            <td><?=$info->post_code ?></td>
                                        </tr>
                                        <tr>
                                            <th>주소1</th>
                                            <td><?=$info->addr1 ?></td>
                                        </tr>
                                        <tr>
                                            <th>주소2</th>
                                            <td><?=$info->addr2 ?></td>
                                        </tr>
                                        <tr>
                                            <th>권한그룹</th>
                                            <td><?=$info->auth_group ?></td>
                                        </tr>
                                        <tr>
                                            <th>마지막 로그인 날짜</th>
                                            <td><?=$info->last_login_date_txt ?></td>
                                        </tr>
                                        <tr>
                                            <th>마지막 로그인 IP</th>
                                            <td><?=$info->last_login_ip ?></td>
                                        </tr>
                                        <tr>
                                            <th>가입일</th>
                                            <td><?=$info->ins_date_txt ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clear-fix d-flex justify-content-end">
                                <button type="button" class="btn btn-info" id="edit" name="edit">수정</button>
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
            location.href = "/member/leave";
        });
    });
</script>
