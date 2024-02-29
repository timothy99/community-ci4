<?php

function redirect_alert($message, $url)
{
    echo '<script>alert("'.$message.'"); location.href="'.$url.'" </script>';
}