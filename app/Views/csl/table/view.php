<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>테이블 명세서</h1>
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
                            <h3 class="card-title">상세보기</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
<?php   foreach ($table_arr as $no => $val) { ?>
                                            <tr class="bg-info">
                                                <th>name</th>
                                                <td colspan="6"><?=$val["table_info"]["table_name"] ?></td>
                                            </tr>
                                            <tr>
                                                <th>type</th>
                                                <td colspan="6"><?=$val["table_info"]["table_type"] ?></td>
                                            </tr>
                                            <tr>
                                                <th>comment</th>
                                                <td colspan="6"><?=$val["table_info"]["table_comment"] ?></td>
                                            </tr>
                                            <tr class="bg-success">
                                                <th>name</th>
                                                <th>type</th>
                                                <th>nullable</th>
                                                <th>default</th>
                                                <th>extra</th>
                                                <th>comment</th>
                                                <th>position</th>
                                            </tr>
<?php       foreach ($val["column_list"] as $no2 => $val2) { ?>
                                            <tr>
                                                <td><?=$val2["column_name"] ?></td>
                                                <td><?=$val2["column_type"] ?></td>
                                                <td><?=$val2["is_nullable"] ?></td>
                                                <td><?=$val2["column_default"] ?></td>
                                                <td><?=$val2["extra"] ?></td>
                                                <td><?=$val2["column_comment"] ?></td>
                                                <td><?=$val2["ordinal_position"] ?></td>
                                            </tr>
<?php       } ?>
<?php   } ?>
                                        </tbody>
                                    </table>
                                </div>
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
        $("#li-table-write").addClass("menu-open");
        $("#upper-table-write").addClass("active");
        $("#a-table-write").addClass("active");
    });
</script>
