<form class="form-horizontal" id="frm" name="frm" action="/csl/table/view" method="post">
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
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">쓰기</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    select
                                        a.table_name,
                                        a.table_type,
                                        a.table_comment,
                                        b.column_name,
                                        b.column_type,
                                        b.is_nullable,
                                        b.column_default,
                                        b.extra,
                                        b.column_comment,
                                        b.ordinal_position
                                    from information_schema.tables a
                                        join information_schema.columns b on a.table_name = b.table_name
                                    where 1=1
                                        and a.TABLE_SCHEMA = '스키마 이름'
                                    order by a.TABLE_NAME, b.ordinal_position
                                </div>
                                <div class="form-group row">
                                    <label for="order_no" class="col-sm-2 col-form-label">컬럼 목록</label>
                                    <div class="col-sm-10">
                                        <textarea id="table_tab" name="table_tab" class="form-control" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-info ml-3">생성</button>
                                    <button type="button" class="btn btn-default ml-3" onclick="history.back()">취소</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</form>

<script>
    $(window).on("load", function() {
        // 메뉴강조
        $("#li-table-write").addClass("menu-open");
        $("#upper-table-write").addClass("active");
        $("#a-table-write").addClass("active");
    });
</script>
