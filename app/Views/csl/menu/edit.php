<form class="form-horizontal" id="frm" name="frm">
    <input type="hidden" id="m_idx" name="m_idx" value="<?=$info->m_idx ?>">
    <input type="hidden" id="upper_idx" name="upper_idx" value="<?=$info->upper_idx ?>">
    <input type="hidden" id="idx1" name="idx1" value="<?=$info->idx1 ?>">
    <input type="hidden" id="idx2" name="idx2" value="<?=$info->idx2 ?>">
    <input type="hidden" id="idx3" name="idx3" value="<?=$info->idx3 ?>">
    <input type="hidden" id="menu_position" name="menu_position" value="<?=$info->menu_position ?>">

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>메뉴생성</h1>
                    </div>
                    <div class="col-sm-8">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">메뉴생성</li>
                        </ol>
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
                                    <label for="title" class="col-sm-2 col-form-label">메뉴명</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?=$info->menu_name ?>" placeholder="메뉴명을 입력하세요">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">링크</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="http_link" name="http_link" value="<?=$info->http_link ?>" placeholder="링크를 입력하세요">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="order_no" class="col-sm-2 col-form-label">정렬순서</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="order_no" name="order_no" value="<?=$info->order_no ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-info ml-3" id="save" name="save">등록</button>
                                    <button type="button" class="btn btn-default ml-3" id="cancel" name="cancel">취소</button>
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
        $("#li-menu-list").addClass("menu-open");
        $("#upper-menu-list").addClass("active");
        $("#a-menu-list").addClass("active");
    });

    $(function() {
        $("#save").click(function(e) {
            ajax1("/csl/menu/update", "frm");
        });

        $("#cancel").click(function(e) {
            location.href = "";
        });
    });
</script>
