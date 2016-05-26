<?php
/**
 Landing page 3 - Controller
 */
require_once( dirname(__FILE__) ."/landingpage1.php");

class Landingpage3 extends Landingpage1
{
    public function index()
    {
    	$this->load->library('usertracking');
        $this->usertracking->track_this();

    	$shortcode = $this->siteconfig->getShortcode();
    	$Keyword = str_replace('_', ' ', $this->Keyword);  
        $text = "$Keyword";

        $data = array();
        $data['Keyword'] = $Keyword;
        $data['sms_link'] = $this->url_sms($shortcode, $text);

        $this->_index($data);
    }
}