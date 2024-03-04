<?php

function uview($view_file, $proc_result = array())
{
    $view_result = null;

    $view_result .= view("/usr/include/header", $proc_result); 
    $view_result .= view("/usr/include/menu", $proc_result); 
    $view_result .= view("/usr/include/top", $proc_result); 
    $view_result .= view($view_file, $proc_result);
    $view_result .= view("/usr/include/footer", $proc_result); 
    $view_result .= view("/usr/include/script", $proc_result); 

    return $view_result;
}