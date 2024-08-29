<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$crumb_info->header_title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?=$crumb_info->crumb_title ?></li>
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
                            <h3 class="card-title"><?=$info->title ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <th>제목</th>
                                                <td><?=$info->title ?></td>
                                            </tr>
                                            <tr>
                                                <th>분류1</th>
                                                <td><?=$info->category1 ?></td>
                                            </tr>
                                            <tr>
                                                <th>분류2</th>
                                                <td><?=$info->category2 ?></td>
                                            </tr>
                                            <tr>
                                                <th>내용</th>
                                                <td><?=$info->contents ?></td>
                                            </tr>
                                            <tr>
                                                <th>링크</th>
                                                <td><?=$info->http_link ?></td>
                                            </tr>
                                            <tr>
                                                <th>첨부파일</th>
                                                <td>
<?php   foreach($file_list as $no => $val) { ?>
                                                    <a href="/download/download/<?=$val->file_id ?>"><?=$val->file_name_org ?></a><br>
<?php   } ?>
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
                                <button type="button" class="btn btn-info ml-3" id="list" name="list">목록</button>
                                <button type="button" class="btn btn-danger ml-3" id="delete" name="delete">삭제</button>
                                <button type="button" class="btn btn-success ml-3" id="edit" name="edit">수정</button>
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
        $("#li-book-list").addClass("menu-open");
        $("#upper-book-list").addClass("active");
        $("#a-book-list-<?=$info->b_idx ?>").addClass("active");
<?php   foreach ($menu_arr as $no => $val) { ?>
        $("#li-book-list-<?=$val ?>").addClass("menu-open");
        $("#a-book-list-<?=$val ?>").addClass("active");
<?php   } ?>
    });

    $(function() {
        $("#edit").click(function(e) {
            location.href = "/csl/book/edit/<?=$info->upper_idx ?>/<?=$info->b_idx ?>";
        });

        $("#list").click(function(e) {
            location.href = "/csl/book/list/<?=$info->upper_idx ?>";
        });

        $("#delete").click(function(e) {
            if(confirm("[ <?=$info->title ?> ] 자료를 삭제하시겠습니까?\n삭제하면 복구가 불가능합니다.")) {
                ajax2("/csl/book/delete/<?=$info->upper_idx ?>/<?=$info->b_idx ?>");
            }
        });
    });
</script>
