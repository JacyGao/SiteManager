<?php

class Splash extends MY_Controller
{
    var $Description = "Splash Portal";
    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('inflector');

        if(!$this->isLoggedIn() && $this->session->userdata('MSISDN') )
            $this->session->set_userdata('LOGGED_IN', $this->session->userdata('MSISDN') );
    }

    private function homepage_data()
    {
        if( !$this->Country )
            show_error("Splash cannot be shown if country is not specified!");

        $data = array();
        $data['Videos'] = $this->Product_model->GetVideos( $this->Product_model->getItemsPerPage() );
        $data['Games'] = $this->Product_model->GetGames();
        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $data['isLoggedIn']= $this->isLoggedIn();

        return $data;
    }

    public function index()
    {
        $this->number_detection();

        $data = $this->homepage_data();

        $content = "videos";

        $total_items = $this->Product_model->GetItems($content,NULL, NULL);

        $data['Title'] = $content;
        $data['Pagination'] = "";
        $data['Items'] = array();

        if($total_items)
        {
            $this->load->library('pagination');

            $config['base_url'] = $this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/'.'/';
            $config['total_rows'] = count($total_items);
            $config['per_page'] = $this->Product_model->getItemsPerPage();
            $config['uri_segment'] = 5;
            $config['cur_tag_open'] = '<span class="current">';
            $config['cur_tag_close'] = '</span>';
            $config['anchor_class'] = ' class="inactive" ';

            $this->pagination->initialize($config);
            $offset = $this->uri->segment( $config['uri_segment'] );

            $data['Pagination'] = $this->pagination->create_links();
            $data['Items'] = array_slice($total_items,$offset, $config['per_page']);


            for($i=1; $i<=5; $i++)
            {
                $data['Categories'][]['Category'] = anchor($this->DocumentRoot.'/'.$this->Product.'/category/'.$this->CountryKey.'/'.$this->Keyword.'/'. $content .'/'. $i, 'test category '. $i);
            }


            for($i=1; $i<=5; $i++)
            {
                $data['Links'][]['Link'] = anchor('', 'link '. $i);
            }

        }
        $this->Display( __FUNCTION__, $data);
    }

    private function getImageName($pcs)
    {
        $dir = "/home/SHARED/previews";

        $filename = "{$dir}/{$pcs}.cache";
        if( file_exists($filename) AND filesize($filename) > 0 ) return $filename;

        $filename = "{$dir}/{$pcs}.1.cache";
        if( file_exists($filename) AND filesize($filename) > 0 ) return $filename;

        $filename = "{$dir}/{$pcs}.jpg";
        if( file_exists($filename) AND filesize($filename) > 0 ) return $filename;

        $filename = "{$dir}/{$pcs}.1.jpg";
        if( file_exists($filename) AND filesize($filename) > 0 ) return $filename;

        $filename = "{$dir}/{$pcs}.gif";
        if( file_exists($filename) AND filesize($filename) > 0 ) return $filename;

        $filename = "{$dir}/{$pcs}.1.gif";
        if( file_exists($filename) AND filesize($filename) > 0 ) return $filename;

        return false;
    }


    function image()
    {
        $itemcode = $this->uri->segment(3);
        $filename = $this->uri->segment(4);

        $thumb = "/home/SHARED/SiteManager/styles/portal/404.jpg";

        $filepath = $this->getImageName($itemcode);

        if( !$filepath )
        {
            $this->output->set_content_type('jpeg');
            $this->output->set_output( file_get_contents($thumb) );
            return;
        }

        $type = getimagesize($filepath);



        if( $type[2] == IMAGETYPE_GIF)
        {
            header("Content-type: image/gif");
            readfile($filepath);
            return;
        }


        $this->load->library('image_lib');

        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image']	= $filepath;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;

        if( $this->agent->is_mobile() )
        {
            $config['width']	 = 100;
            $config['height']	= 100;
        }
        else
        {
            $config['width']	 = 250;
            $config['height']	= 250;
        }

        $this->image_lib->initialize($config);

        if ( $this->image_lib->resize() )
        {
            $filename = basename($filepath);
            $ext = substr($filename, strrpos($filename, "."));
            $fnamelen = strlen($filename)-strlen($ext);
            $thumbname = substr($filename, 0, $fnamelen) ."_thumb". $ext;

            $new_thumb = dirname( $config['source_image'] )."/{$thumbname}";
            if( file_exists($new_thumb) && filesize($new_thumb) > 0 )
                $thumb = $new_thumb;
        }

        $this->output->set_content_type( "jpeg" );
        $this->output->set_output( file_get_contents($thumb) );


    }

    function artist()
    {

        $query = strtolower( $this->uri->segment(3) );

        if(strstr($query, "ft") == true) $query = substr($query, 0, strpos($query, "ft"));
        if(strstr($query, "feat") == true) $query = substr($query, 0, strpos($query, "feat"));
        if(strstr($query, "&") == true) $query = substr($query, 0, strpos($query, "&"));

        $query = preg_replace("/[^a-z0-9. ]/","",$query);

        $query = urlencode("". $query);

        $uri = "http://www.google.com/search?num=10&hl=en&site=imghp&biw=300&bih=300&q=site%3Alast.fm+{$query}&source=lnms&tbm=isch&sa=X&ei=fiq4UPt1koLxBMqWgKAH&ved=0CAgQ_AUoAQ";
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: Mozilla/5.0 (SymbianOS/9.1; U; [en]; Series60/3.0 NokiaE60/4.06.0) AppleWebKit/413 (KHTML, like Gecko) Safari/413");
        $response = curl_exec($ch);
        curl_close($ch);


        preg_match_all("/\<img src=\"(http:\/\/t([0-9]+)\.gstatic\.com([^\"]+))/", $response, $images);

        if(isset($images[1]))
        {
            $images = $images[1];

            if( sizeof($images) > 0)
            {
                $imgurl = $images[ array_rand($images) ];
                header("Content-type: image/jpeg");
                #header("Location: {$imgurl}", 302);
                readfile($imgurl);
                return;
            }
        }

        echo "[no images found]";

    }


    function item()
    {
        $pcs = $this->uri->segment(5);
        return $this->show_item($pcs);
    }

    private function isLoggedIn()
    {
        return $this->session->userdata('LOGGED_IN');
    }

    private function allow_signup()
    {
        return ($this->Product_model->getSubscriptionFlow() != SUBSCRIBE_FLOW_NONE &&
            $this->Product_model->getSubscriptionFlow() != SUBSCRIBE_FLOW_HIDDEN);
    }

    private function allow_login()
    {
        return ($this->Product_model->getLoginFlow() != LOGIN_FLOW_NO_LOGIN);
    }

    private function show_item($pcs, $note=null, $error=null)
    {

        $data = $this->homepage_data();

        $item = $this->Product_model->GetItem($pcs);

        #$this->Product_model->IncreaseDisplayedCount($item['dbID']);

        if(!$item)
            return $this->sorry("The item you are searching for no longer exists!");

        if( $this->agent->is_mobile() )
        {
            $img_width	 = '40%';
        }
        else
        {
            $img_width	 = 350;
        }


        $data['Item_Preview'] = $item['preview']['protected'];
        $data['Can_Listen'] = in_array(strtolower($item['type']), array("covertones","polyphonics","cover full tracks", "real tones", "sound effects")) && trim($data['Item_Preview']);

        $data['Item_ID'] = $pcs;
        $data['Item_Title'] = $item['title'] .($data['Can_Listen']? " by <b>{$item['artist']}</b>":"");
        $data['Item_Artist'] = $item['artist'];

        if($this->agent->is_mobile())
            $data['Item_Image'] = sprintf($item['preview']['mobile'],$img_width,$img_width);
        else
            $data['Item_Image'] = sprintf($item['image'],$img_width,$img_width);

        $data['Item_Type'] = $item['type'];
        $data['Item_Category'] = $item['category'];
        $data['Item_Cost'] = $item['price'] .' credits';

        $MO_Keyword = $this->Product_model->getOrderKeyword($item['dbID']);

        if(strlen($item['dbID']) > 3)
            $MO_Keyword = "P{$item['dbID']}";


        $singular = $item['type'];
        $flow = $this->Product_model->getOrderFlow();

        $sessionID = $this->session->userdata('session_id');


        if( $this->isLoggedIn() && $this->allow_login() )
        {
            switch($flow)
            {
                case ORDER_FLOW_DLOAD_FOR_CREDITS:
                    if( $this->Product_model->GetCredits() >= $item['price'] )
                    {
                        $data['Item_Note'] = "To get this {$singular} on your phone, press the GET now";
                        $data['Item_Download'] = anchor("{$this->DocumentRoot}/{$this->Product}/download/{$this->CountryKey}/{$this->Keyword}/{$pcs}/{$sessionID}",'<span>GET</span>', array('class'=>'button_link'));
                    }
                    else
                    {
                        $data['Item_Note'] = "You don't have enough credits to get this {$singular} right now, click on 'GET MORE CREDITS' to order more credits!";
                        $data['Item_Download'] = anchor("{$this->DocumentRoot}/{$this->Product}/topup/{$this->CountryKey}/{$this->Keyword}/{$pcs}/",'<span>GET MORE CREDITS</span>', array('class'=>'button_link'));
                    }

                    break;

                case ORDER_FLOW_DLOAD_FOR_FREE:
                    $data['Item_Note'] = "To get this {$singular} on your phone, press the GET now";
                    $data['Item_Download'] = anchor("{$this->DocumentRoot}/{$this->Product}/download/{$this->CountryKey}/{$this->Keyword}/{$pcs}/{$sessionID}",'<span>GET</span>', array('class'=>'button_link'));
                    break;

            }

        }
        else
        {
            switch($flow)
            {
                case ORDER_FLOW_DLOAD_FOR_CREDITS:
                    $data['Item_Note'] = "Please login to get this {$singular} on your phone";
                    $data['Item_Download'] = anchor("{$this->DocumentRoot}/{$this->Product}/login/{$this->CountryKey}/{$this->Keyword}/",'<span>LOGIN</span>', array('class'=>'button_link small'));
                    break;

                case ORDER_FLOW_DLOAD_FOR_FREE:
                    $data['Item_Note'] = "To get this {$singular} on your phone, press the GET now";
                    $data['Item_Download'] = anchor("{$this->DocumentRoot}/{$this->Product}/download/{$this->CountryKey}/{$this->Keyword}/{$pcs}/{$sessionID}",'<span>GET</span>', array('class'=>'button_link'));
                    break;

                case ORDER_FLOW_ENTER_NUMBER:
                    if($this->Country->selectnetwork)
                    {
                        $query = $this->db->get_where('networks', array('country'=>$this->Country->iso));
                        $networks = array();
                        foreach($query->result() as $net)
                        {
                            $networks[] = "<option value=\"{$net->netkey}\">{$net->netlabel}</option>";
                        }
                        $data['Item_Note'] = "<p id=\"orderInstructions\">Please select your network</p>";

                        if($this->agent->is_mobile())
                        {
                            $data['Item_Download'] = "<form action=\"{$this->DocumentRoot}/{$this->Product}/orderselectnetwork/{$this->CountryKey}/{$this->Keyword}/{$pcs}/{$sessionID}\" method=\"POST\"><select name=\"network\"><option selected>-- Select --</option>". implode("", $networks) ."</select><input type=\"submit\" value=\" Continue \" /></form>\n";
                        }
                        else
                        {
                            $data['Item_Download'] = "<select id=\"orderSelectNetwork\"><option selected>-- Select --</option>". implode("", $networks) ."</select>\n";
                            $data['Item_Download'] .= "<form id=\"orderEnterNum\" style=\"display:none;\" method=\"POST\" action=\"{$this->DocumentRoot}/{$this->Product}/order/{$this->CountryKey}/{$this->Keyword}/{$pcs}/{$sessionID}\"><input type=\"text\" name=\"mobile\" placeholder=\"{$this->Country->placeholder}\" value=\"\" size=\"{$this->Country->maxlength}\" maxlength=\"{$this->Country->maxlength}\"> <input type=\"submit\" value=\"Order now\"></form>\n";
                            $data['Item_Download'] .= "<div id=\"orderKeyword\" style=\"display:none;\"><small>sms</small> {$MO_Keyword} <small>to</small> ". $this->siteconfig->getShortcode() ."</div>\n";
                        }

                    }
                    else
                    {
                        $data['Item_Note'] = "Please enter your number in the field below to order this {$singular} now<br />";
                        $data['Item_Download'] = "<form id=\"orderEnterNum\" method=\"POST\" action=\"{$this->DocumentRoot}/{$this->Product}/order/{$this->CountryKey}/{$this->Keyword}/{$pcs}/{$sessionID}\"><input type=\"text\" name=\"mobile\" placeholder=\"{$this->Country->placeholder}\" value=\"\" size=\"{$this->Country->maxlength}\" maxlength=\"{$this->Country->maxlength}\"> <input type=\"submit\" value=\"Order now\"></form>";
                    }

                    break;

                case ORDER_FLOW_SHOW_KEYWORD:
                    $data['Item_Note'] = "<h3>To get this {$singular}</h3>";
                    $data['Item_Download'] = "<small>sms</small> {$MO_Keyword} <small>to</small> ". $this->siteconfig->getShortcode();

                    break;

                default:
                    $data['Item_Note'] = "";
                    $data['Item_Download'] = "";
                    break;
            }
        }

        $data['NOTE'] = "You need a WAP/GPRS enabled phone to download the content. Games require a JAVA enabled device. Covertones require MP3 capable devices. ** Standard Data charges apply!";

        $data['Category'] = $item['category'];

        $flashnote = $this->getItemNote($pcs);

        if(!$note && $flashnote)
            $note = $flashnote;

        if($note)
            $data['Item_Note'] = "<b style=\"color:#FFF; font-weigh:bold;\">{$note}</b>";

        if(!isset($data['Item_Download']))
            $data['Item_Download'] = "Thank you";

        $this->Display( 'item', $data);
    }

    private function getItemNote($pcs)
    {
        return $this->session->flashdata('SHOW_ITEM_NOTE_'.$pcs);
    }

    public function download()
    {
        $pcs = $this->uri->segment(5);

        if( !$this->agent->is_mobile() )
        {
            return $this->show_item($pcs, "Sorry, you can only download this item via mobile device!");
        }

        $validateSession = $this->uri->segment(6);

        $sessionID = $this->session->userdata('session_id');

        #if($validateSession != $sessionID)
        #    return $this->sorry("Your session has expired!");

        $item = $this->Product_model->GetItem($pcs);

        if(!$item)
            return $this->sorry("The item you are searching for no longer exists!");

        $flow = $this->Product_model->getOrderFlow();

        if( $flow == ORDER_FLOW_DLOAD_FOR_CREDITS || $flow == ORDER_FLOW_DLOAD_FOR_FREE )
        {
            if(!$this->isLoggedIn())
                return $this->show_item($pcs, "Sorry, you cannot download this item without logging in first!");

            if($flow == ORDER_FLOW_DLOAD_FOR_CREDITS)
            {
                $availableCredits = $this->Product_model->GetCredits();

                if( $availableCredits < $item['price'] )
                    return $this->show_item($pcs, "You don't have enough credits to download this item. Please request more credits now.");

            }

            $url = $this->Product_model->getDownloadURL($this->session->userdata('LOGGED_IN'), $this->siteconfig->getShortcode(), $pcs);

            $this->Product_model->IncreaseDownloadCount($item['dbID']);

            redirect($url);
        }
        else
        {
            return $this->show_item($pcs, "Sorry, you cannot download this item!");
        }
    }

    public function do_signup()
    {
        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric');

            if( $this->Product_model->getLoginFlow() == LOGIN_FLOW_GOT_PIN )
                $this->form_validation->set_rules('pin', 'Custom PIN Number', 'required|numeric|min_length[4]|max_length[4]');


            if( $this->siteconfig->getTermsCheckbox($this->Product) )
                $this->form_validation->set_rules('terms', 'Terms & Conditions', 'required');


            if ($this->form_validation->run() == FALSE)
            {

                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/splash/index/") == true )
                    return $this->sorry( validation_errors('<p>', '</p>'));
                else
                    return $this->sorry_iframe(validation_errors('<p>', '</p>'));

            }
            else
            {
                $this->realStartSubscription( $this->input->post('mobile'), $this->input->post('pin') );
                return;
            }
        }

        if( $this->agent->is_mobile() )
            redirect($this->DocumentRoot."/splash/signup_form/". $this->CountryKey ."/". $this->Keyword);
        else
            redirect($this->DocumentRoot."/splash/signup/". $this->CountryKey ."/". $this->Keyword);
    }

    protected function realStartSubscription($mobile, $pin)
    {

        $network = $this->input->post('network');

        $result = parent::realStartSubscription($mobile, $network);

        if( $result !== true )
        {
            $this->session->unset_userdata('MSISDN');
            $this->session->unset_userdata('LOGGED_IN');

            return $this->sorry($result);
        }


        # check if user already exists!
        #$this->Product_model->CreateUser($mobile, $pin);

        $this->postSubscription();
    }

}