            <ul class="pagination pagination-sm m-0">
                <li class="page-item"><a class="page-link" href="<?=$href_link ?>?page=1&<?=$http_query ?>"> &laquo; </a></li>
                <li class="page-item"><a class="page-link" href="<?=$href_link ?>?page=<?=$paging["prev_page"] ?>&<?=$http_query ?>"> &lt; </a></li>
<?php
    foreach ($paging["page_arr"] as $no => $val) :
?>
                <li class="page-item <?=$val["active_class"] ?>">
                    <a class="page-link" href="<?=$href_link ?>?page=<?=$val["page_num"] ?>&<?=$http_query ?>"><?=$val["page_num"] ?></a>
                </li>
<?php
    endforeach;
?>
                <li class="page-item"><a class="page-link" href="<?=$href_link ?>?page=<?=$paging["next_page"] ?>&<?=$http_query ?>"> &gt; </a></li>
                <li class="page-item"><a class="page-link" href="<?=$href_link ?>?page=<?=$paging["max_page"] ?>&<?=$http_query ?>"> &raquo; </a></li>
            </ul>
