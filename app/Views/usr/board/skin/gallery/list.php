<div class="content-wrapper">
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
        </div>
    </section>

    <div class="content">
        <div class="container">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">총 <?=number_format($cnt) ?>건</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    목록수
                                    <select class="form-control ml-3" id="rows" name="rows" onchange="search()">
                                        <option value="8">8</option>
                                        <option value="16">16</option>
                                        <option value="24">24</option>
                                    </select>
                                    <select class="form-control ml-3" id="search_condition" name="search_condition">
                                        <option value="title">제목</option>
                                        <option value="contents">내용</option>
                                    </select>
                                    <input type="text" id="search_text" name="search_text" class="form-control float-right ml-3" placeholder="검색어를 입력하세요" value="<?=$data["search_arr"]["search_text"] ?>">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-default" id="search_button" name="search_button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-4">
<?php   foreach ($list as $no => $val) { ?>
                                <div class="col-md-3">
                                    <a href="/board/<?=$val->board_id ?>/view/<?=$val->b_idx ?>">
                                        <img src="/download/view/<?=$val->file_arr[0] ?>" alt="<?=$val->title ?>" class="img-fluid"><br>
                                        <p class="text-center"><?=$val->title ?></p>
                                    </a>
                                </div>
<?php   } ?>
                            </div>
                        </div>

                        <div class="card-footer clear-fix">
<?=$paging_info["paging_view"] ?>
<?php   if ($config_info->user_write == "Y") { ?>
                            <button type="button" class="btn btn-info float-right" id="write" name="write">글쓰기</button>
<?php   } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(window).on("load", function() {
        // 셀렉트 박스 선택
        $("#search_condition").val("<?=$data["search_arr"]["search_condition"] ?>").prop("selected", true);
        $("#search_text").val("<?=$data["search_arr"]["search_text"] ?>");
        $("#rows").val("<?=$data["search_arr"]["rows"] ?>").prop("selected", true);
    });

    $(function() {
        $("#search_text").keydown(function(e) {
            if(e.keyCode == 13) {
                search();
            }
        });

        $("#search_button").click(function(e) {
            search();
        });

        $("#write").click(function(e) {
            location.href = "/board/<?=$board_id ?>/write";
        });
    });

    function search() {
        var search_text = $("#search_text").val();
        var search_condition = $("#search_condition").val();
        var rows = $("#rows").val();
        location.href = "/board/<?=$board_id ?>/list?page=1&search_text="+search_text+"&search_condition="+search_condition+"&rows="+rows;
    }
</script>
