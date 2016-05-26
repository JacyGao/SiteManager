<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 27/09/13
 * Time: 2:41 PM
 * To change this template use File | Settings | File Templates.
 */

class Upload_model extends CI_Model
{

    function getImages()
    {
        $images = array();

        foreach(glob('custom/images/*.*') as $filename){

            $tokens = explode('/', $filename);
            $file = $tokens[sizeof($tokens)-1];

            array_push($images, $file);
        }

        return $images;
    }

}