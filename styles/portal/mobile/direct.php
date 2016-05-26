<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 3/12/12
 * Time: 4:56 PM
 * To change this template use File | Settings | File Templates.
 */

$link = $_POST["navigation"];
#echo $link;
header("location: {$link}");