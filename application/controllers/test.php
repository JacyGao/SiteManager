<?php

class Test extends CI_Controller
{

    function index()
    {
        $this->load->library('fiftyonedegrees');

        $this->fiftyonedegrees->detect()->debug();
    }

}
