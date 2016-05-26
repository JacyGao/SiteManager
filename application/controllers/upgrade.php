<?php
    /**
     * Created by John Huseinovic
     * Date: 5/11/12
     * Time: 4:06 PM
     */
class Upgrade extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    function index()
    {

        if ( ! $this->migration->current() )
        {
            show_error($this->migration->error_string());
        }
    }


}