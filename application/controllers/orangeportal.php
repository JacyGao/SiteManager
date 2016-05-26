<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */

require_once( dirname(__FILE__) ."/portal.php");

class Orangeportal extends Portal
{
    function __construct()
    {
        parent::__construct();
    }

    function content()
    {
        $data = $this->homepage_data();

        $content = $this->uri->segment(5);
        $content = urldecode($content);


        switch ($content)
        {
            case 'Music':
            case 'music':
                $content ="Covertones";
                $total_items = $this->Product_model->GetItems($content,NULL, NULL);

                $data['Title'] = 'Music';
                $data['Pagination'] = "";
                $data['Items'] = array();
                break;
            case 'Info':
            case 'info':
                $content ="Info";
                $total_items = $this->Product_model->GetInfo(NULL,NULL, NULL, false);

                $data['Title'] = 'Information';
                $data['Pagination'] = "";
                $data['Items'] = array();
                break;
            case 'Games':
            case 'games':
                $content ="Games";
                $total_items = $this->Product_model->GetItems($content,NULL, NULL);

                $data['Title'] = 'Games';
                $data['Pagination'] = "";
                $data['Items'] = array();
                break;
            case 'Videos':
            case 'videos':
                $content ="Videos";
                $total_items = $this->Product_model->GetItems($content,NULL, NULL);

                $data['Title'] = 'Videos';
                $data['Pagination'] = "";
                $data['Items'] = array();
                break;
            default:
                header('Location: '.$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/');
        }

        if($total_items)
        {
            $this->load->library('pagination');

            $config['base_url'] = $this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/'. trim($content) .'/';
            $config['total_rows'] = count($total_items);
            $config['per_page'] = $this->Product_model->getItemsPerPage();
            $config['uri_segment'] = 6;
            $config['cur_tag_open'] = '<span class="current">';
            $config['cur_tag_close'] = '</span>';
            $config['anchor_class'] = ' class="inactive" ';

            $this->pagination->initialize($config);

            $offset = $this->uri->segment( $config['uri_segment'] );

            $data['Pagination'] = $this->pagination->create_links();

            $data['Items'] = array_slice($total_items,$offset, $config['per_page']);
        }


        $this->Display('content', $data);
    }

    function homepage_data()
    {
        $data = parent::homepage_data();

        $data['isLoggedIn'] = $this->isLoggedIn();
        $data['sessionID'] = $this->session->userdata('session_id');

        $data['MainMenu'] = array();


        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Signup');
        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/login/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Members');

        $data['LogoutMenu'] = array();
        $data['LogoutMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/logout/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Logout');
        $data['ContentTypes'] =  $this->Product_model->GetContentTypes( $this->Product_model->getItemsPerPage() );
        $data['Videos'] = $this->Product_model->GetVideos( $this->Product_model->getItemsPerPage() );
        $data['Ringtones'] = $this->Product_model->GetRingtones( $this->Product_model->getItemsPerPage() );
        $data['Games'] = $this->Product_model->GetGames( $this->Product_model->getItemsPerPage() );
        $data['Info_Content'] = $this->Product_model->Info_Content;
        if($data['Info_Content'] == 1)
        {
            $data['Infos'] = $this->Product_model->GetInfos( $this->Product_model->getItemsPerPage() );
        }
        //$this->Product_model->sorter( $data['Videos'], 'dbID', false );

        
        // World Cup 2014
        $data['Special'] = array();
        if ($this->uri->segment(5) == 'wcbr14') $this->session->set_userdata('worldcup_keyword', $this->uri->segment(5)); 

        if ($this->session->userdata('worldcup_keyword'))
        {
            if( $results = $this->Product_model->GetItems(NULL, 'World Cup 2014') )
                $data['Special'] = $results;           
        }

        // Html5 games (only greece)
        $data['Html5_Games'] = array();
        if (substr($this->CountryKey, 0,2) == 'gr')
        {
            if( $results = $this->Product_model->GetItems('Html5 Games', NULL, '3') )
                $data['Html5_Games'] = $results;
        }

    // Home, Music , Games and Videos Menu
        $data['SecondMenu'] = array();
        if($data['Info_Content'] == 0)
        {
            $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Home');
        }
        else
        {
            $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Info', 'label'=>'Info');
        }
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Music', 'label'=>'Music');
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Games', 'label'=>'Games');
        $data['SecondMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/content/'.$this->CountryKey.'/'.$this->Keyword.'/Videos', 'label'=>'Videos');

        return $data;
    }

    public function logout()
    {
        $this->session->unset_userdata('worldcup_keyword');
        parent::logout();
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

    function blacklist()
    {
        $blacklist = array();
        $blacklist = $this->Product_model->checkAllNumbers();

        foreach($blacklist as $list)
        {
            $this->Product_model->addToBlacklist($list);
            echo "Mobile Cherry blacklisted ".$list;
        }

        $this->Product_model->resetDailyDownloads();

    }

    public function download()
    {
        if(strpos($this->uri->segment(3),'gr') !== false && !$this->session->userdata('LOGGED_IN'))
        {
            $msisdn = '3011111111';            
            $this->session->set_userdata('LOGGED_IN', $msisdn);
        }

        parent::download();
    }

}// class mobilemojo ends
