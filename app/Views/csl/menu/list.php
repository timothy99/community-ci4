<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>메뉴관리</h1>
                </div>
                <div class="col-sm-8">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">홈 > 메뉴관리</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">메뉴</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered" style="white-space: nowrap;">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width:50px">정렬</th>
                                        <th>메뉴명1</th>
                                        <th>메뉴명2</th>
                                        <th>메뉴명3</th>
                                        <th style="width:30px">1차</th>
                                        <th style="width:30px">2차</th>
                                        <th style="width:30px">3차</th>
                                        <th style="width:30px">위치</th>
                                        <th style="width:130px">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php   foreach($list as $no => $val) { // 1차 메뉴 ?>
                                    <tr>
                                        <td class="text-center"><?=$val->order_no ?></td>
                                        <td><a href="/csl/book/list/<?=$val->m_idx ?>"><?=$val->menu_name ?></a></td>
                                        <td></td>
                                        <td></td>
                                        <td><?=$val->idx1 ?></td>
                                        <td><?=$val->idx2 ?></td>
                                        <td><?=$val->idx3 ?></td>
                                        <td><?=$val->menu_position ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" id="info" name="info" value="<?=$val->m_idx ?>" onclick="menu_add(this.value)">하위추가</button>
                                            <button type="button" class="btn btn-sm btn-success" id="edit" name="edit" value="<?=$val->m_idx ?>" onclick="menu_edit(this.value)">수정</button>
                                            <button type="button" class="btn btn-sm btn-danger" id="delete" name="delete" value="<?=$val->m_idx ?>" onclick="menu_delete(this.value)">삭제</button>
                                        </td>
                                    </tr>
<?php       foreach($val->list as $no2 => $val2) { // 2차 메뉴 ?>
                                    <tr>
                                        <td class="text-center"><?=$val2->order_no ?></td>
                                        <td></td>
                                        <td><a href="/csl/book/list/<?=$val2->m_idx ?>"><?=$val2->menu_name ?></a></td>
                                        <td></td>
                                        <td><?=$val2->idx1 ?></td>
                                        <td><?=$val2->idx2 ?></td>
                                        <td><?=$val2->idx3 ?></td>
                                        <td><?=$val2->menu_position ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" id="info" name="info" value="<?=$val2->m_idx ?>" onclick="menu_add(this.value)">하위추가</button>
                                            <button type="button" class="btn btn-sm btn-success" id="edit" name="edit" value="<?=$val2->m_idx ?>" onclick="menu_edit(this.value)">수정</button>
                                            <button type="button" class="btn btn-sm btn-danger" id="delete" name="delete" value="<?=$val2->m_idx ?>" onclick="menu_delete(this.value)">삭제</button>
                                        </td>
                                    </tr>
<?php           foreach($val2->list as $no3 => $val3) { // 3차 메뉴 ?>
                                    <tr>
                                        <td class="text-center"><?=$val3->order_no ?></td>
                                        <td></td>
                                        <td></td>
                                        <td><a href="/csl/book/list/<?=$val3->m_idx ?>"><?=$val3->menu_name ?></a></td>
                                        <td><?=$val3->idx1 ?></td>
                                        <td><?=$val3->idx2 ?></td>
                                        <td><?=$val3->idx3 ?></td>
                                        <td><?=$val3->menu_position ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" id="edit" name="edit" value="<?=$val3->m_idx ?>" onclick="menu_edit(this.value)">수정</button>
                                            <button type="button" class="btn btn-sm btn-danger" id="delete" name="delete" value="<?=$val3->m_idx ?>" onclick="menu_delete(this.value)">삭제</button>
                                        </td>
                                    </tr>
<?php           } ?>
<?php       } ?>
<?php   } ?>
<?php   if (count($list) == 0) { ?>
                                    <tr>
                                        <td colspan="9" class="text-center">데이터가 없습니다.</td>
                                    </tr>
<?php   } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-info float-right" id="write" name="write">최상위 등록</button>
                        </div>
                    </div>
                    <!-- /.card -->
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
        $("#li-menu-list").addClass("menu-open");
        $("#upper-menu-list").addClass("active");
        $("#a-menu-list").addClass("active");
    });

    $(function() {
        $("#write").click(function(e) {
            location.href = "/csl/menu/write/0";
        });
    });

    function menu_add(m_idx) {
        location.href = "/csl/menu/write/"+m_idx;
    }

    function menu_edit(m_idx) {
        location.href = "/csl/menu/edit/"+m_idx;
    }

    function menu_delete(m_idx) {
        if(confirm("삭제하면 하위 메뉴의 데이터도 모두 삭제됩니다. 진행하시겠습니까?")) {
            ajax2("/csl/menu/delete/"+m_idx);
        }
    }
</script>