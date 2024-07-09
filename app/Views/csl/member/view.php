<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>회원</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">홈</a></li>
                        <li class="breadcrumb-item active">회원</li>
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
                            <h3 class="card-title">회원정보 보기</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-responsive text-nowrap table-hover">
                                <tbody>
                                    <tr>
                                        <th>아이디</th>
                                        <td><?=$info->member_name ?></td>
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
                                        <th>마지막 접속일</th>
                                        <td><?=$info->last_login_date_txt ?></td>
                                    </tr>
                                    <tr>
                                        <th>마지막IP</th>
                                        <td><?=$info->last_login_ip ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
                                <button type="button" class="btn btn-info ml-3" id="list" name="list">목록</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-member-list").addClass("menu-open");
        $("#a-member-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/member/edit/<?=$info->member_id ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/member/list";
        });

        $("#delete").click(function(e) {
            if(confirm("회원을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/member/delete/<?=$info->member_id ?>");
            }
        });
    });
</script>