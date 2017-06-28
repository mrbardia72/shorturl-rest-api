<?php
/**
 * Created by: phpstorm
 * programmer: sajjad kazemi
 * Email: sajad.kazemi1993@gmail.com
 * telegram: @sajjadkazemi10
 * Date: 2017-06-10
 * location: iran,gilan,langroud
 */

/* include file(method)*/
include_once 'includes/config.php';
include_once 'includes/function.php';

/*get url and key*/
    if (isset($_GET['url']) && ($_GET['key']))
    {
    $path = $_GET['url'];
    $kay = $_GET['key'];



    /* call class shorturl. */
    $obj= new shorturl();
   $obj->auth_user($kay , $path);
}
