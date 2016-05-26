<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */

require_once( dirname(__FILE__) ."/iq.php");

class IQ2 extends IQ
{
    function __construct()
    {
        parent::__construct();

        $this->Product = "iq2";
    }



}
