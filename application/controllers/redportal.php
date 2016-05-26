<?php

require_once( dirname(__FILE__) ."/portal.php");

class Redportal extends Portal
{
    function __construct()
    {
        parent::__construct();
    }

    function homepage_data()
    {
        $data = parent::homepage_data();

        $data['MainMenu'] = array();

        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Signup');
        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/login/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Members');

        $data['LogoutMenu'] = array();
        $data['LogoutMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/logout/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Logout');

        $data['ContentTypes'] =  $this->Product_model->GetContentTypes( $this->Product_model->getItemsPerPage() );
        $data['Videos'] = $this->Product_model->GetVideos( $this->Product_model->getItemsPerPage() );
        $data['Wallpapers'] = $this->Product_model->GetWallpapers( $this->Product_model->getItemsPerPage() );
        $data['Games'] = $this->Product_model->GetGames( $this->Product_model->getItemsPerPage() );


    // Home, Music , Games and Videos Menu
        $data['SecondMenu'] = array();
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Home');
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Wallpapers', 'label'=>'Wallpapers');
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Games', 'label'=>'Games');
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Videos', 'label'=>'Videos');

        return $data;
    }

    public function index()
    {
        if($this->Product_model->Age_Confirmation_Page==1)
        {
            if($this->session->userdata('AGE_CONFIRMED') == "yes")
            {
                //DO NOTHING
            }
            else
            {
                header('Location: '.$this->DocumentRoot.'/'.$this->Product.'/confirm_age/'.$this->CountryKey.'/'.$this->Keyword);
            }
        }

        $this->number_detection();

        $data = $this->homepage_data();

        $this->Display( __FUNCTION__, $data);
    }

    public function confirm_age()
    {
        $data = $this->homepage_data();

        $this->Display( __FUNCTION__, $data);
    }

    public function age_confirmed()
    {
        $this->session->set_userdata('AGE_CONFIRMED', 'yes');
        header('Location: '.$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword);
    }

    public function joinnow()
    {
        $this->load->helper(array('form', 'url'));

        $data = $this->homepage_data();
        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $this->Display( __FUNCTION__, $data);
    }

    public function validatepin()
    {
        $this->load->helper(array('form', 'url'));

        $pin = $this->input->get_post('pin');
        $key = $this->input->get_post('key');
        $subscribe = false;
        $msisdn = NULL;
        $network = NULL;

        if($key && !$pin)
        {
            $decrypted = $this->encrypt->decode($key);

            $arr = explode(":", $decrypted);

            $msisdn = $arr[0];

            if(isset($arr[1]))
                $network = $arr[1];

            if($msisdn)
            {
                $this->session->set_userdata('MSISDN', $msisdn);
                $this->session->set_userdata('NETWORK', $network);
                $subscribe = true;
            }


        }
        elseif($pin)
        {
            $subscribe = $this->Product_model->check_pin_input($pin);
        }

        if( $subscribe )
        {
            $result = $this->subscribe();
            if( $result )
            {

                if ($this->agent->is_mobile())
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/thankyou/{$this->CountryKey}/{$this->Keyword}");
                }
                else
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/loadnext/{$this->CountryKey}/{$this->Keyword}/thankyou");
                }
            }
            else
            {
                $this->sorry($result);
            }
        }
        else
        {
            $data = $this->homepage_data();
            $this->Display( __FUNCTION__, $data);
        }
    }

    function validate()
    {
        $mobile = $this->input->post('MobileNo');

        if(!$mobile && $this->session->userdata('MSISDN')) $mobile = $this->session->userdata('MSISDN');

        $this->startSubscription($mobile);
    }
// overriding get item for latest contents
    function GetItem($pcs)
    {

        $query = $this->site_db->select("i.id as dbID, i.PCS as id, i.artist, i.title, lower(i.contentType) as type, i.category, downloaded as score, preview_url", false)
            ->from("{$this->tbl_items} i")
            ->where('i.PCS', $pcs)
            ->order_by ('downloaded', 'desc')
            ->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        # Local copy not found, look up MCS
        if( $query->num_rows() > 0 )
        {
            $rs = (array)$query->row(0);
        }
        else
        {
            $url = "http://apps.mobivate.com/mcs/items.php?format=XML&USER=mobivate&PWD=etavibom&ITEMS=". $pcs;

            $content = file_get_contents($url);

            try
            {
                $xml = simplexml_load_string($content);

                if( !$xml->Item1->PCS )
                    return false;

                $rs = array();
                $rs['dbID'] = $xml->Item1->PCS;
                $rs['id'] = $xml->Item1->PCS;
                $rs['artist'] = $xml->Item1->Artist;
                $rs['title'] = $xml->Item1->Title;
                $rs['type'] = strtolower($xml->Item1->Content);
                $rs['category'] = $xml->Item1->Category;
                $rs['price'] = $this->getContentPrice($rs['type']);
                $rs['score'] = 10;
                $rs['preview_url'] = $xml->Item1->File;
            }
            catch(Exception $e)
            {
                return false;
            }

        }


        return $this->formatResult( $rs );

    }

}// class redportal ends
