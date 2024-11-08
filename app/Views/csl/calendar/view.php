<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>일정보기</h1>
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
                            <h3 class="card-title"><?=$info->title ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <th style="width:15%">제목</th>
                                                <td><?=$info->title ?></td>
                                            </tr>
                                            <tr>
                                                <th>내용</th>
                                                <td><?=nl2br_only($info->contents) ?></td>
                                            </tr>
                                            <tr>
                                                <th>시작일</th>
                                                <td><?=$info->start ?></td>
                                            </tr>
                                            <tr>
                                                <th>종료일</th>
                                                <td><?=$info->end ?></td>
                                            </tr>
                                            <tr>
                                                <th>첨부파일</th>
                                                <td><a href="/download/download/<?=$info->attach_file ?>"><?=$info->attach_file_info->file_name_org ?></a></td>
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
                                <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
                                <button type="button" class="btn btn-info ml-3" id="list" name="list">목록</button>
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
        $("#li-calendar-list").addClass("menu-open");
        $("#a-calendar-list").addClass("active");
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/calendar/edit?no=<?=$info->c_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/calendar/list";
        });

        $("#delete").click(function(e) {
            if(confirm("일정을 삭제하나요? 삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/calendar/delete/<?=$info->c_idx ?>");
            }
        });
    });
</script>
