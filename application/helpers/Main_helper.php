<?php
/**
 * by  Makoto Haba
 */


if ( ! function_exists('h'))
{
    function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }
}

if ( ! function_exists('public_url'))
{
    function public_url($url = '')
    {
        return base_url('public/'.$url);
    }
}

if ( ! function_exists('upload_url'))
{
    function upload_url($url = '')
    {
        return base_url('upload/'.$url);
    }
}


