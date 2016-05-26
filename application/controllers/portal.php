<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */
class Portal extends MY_Controller
{
    var $Description = "Content Portal";
    private $RingtoneTypes = array('covertones','polyphonics','cover full tracks','true tones');

    public function __construct($country_required=true)
    {
        parent::__construct($country_required);

        $this->load->helper('url');
        $this->load->helper('inflector');

        if(!$this->isLoggedIn() && $this->session->userdata('MSISDN') )
            $this->session->set_userdata('LOGGED_IN', $this->session->userdata('MSISDN') );
    }

    protected function homepage_data()
    {
        $data = array();

        $data['Top10'] = $this->Product_model->GetTop10();

        if($this->agent->is_mobile())
            $data['LatestContent'] = array();
        else
            $data['LatestContent'] = $this->Product_model->GetLatestContent();

        $data['TextServices'] = $this->siteconfig->getTextServices();

        $data['ContentTypes'] =  $this->Product_model->GetContentTypes( $this->Product_model->getItemsPerPage() );

        $data['Ringtones'] = $this->Product_model->GetRingtones( $this->Product_model->getItemsPerPage() );

        $data['Videos'] = $this->Product_model->GetVideos( $this->Product_model->getItemsPerPage() );

        $data['MainMenu'] = array();

        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Home');
        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/about/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'About Us');
        $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/help/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Help');

        if( $this->allow_signup() && !$this->isLoggedIn() )
        {
            if( $this->agent->is_mobile() )
            {
                $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/signup_form/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Sign Up');
            }
            else
            {
                $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/signup/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Sign Up');
            }
        }

        if( $this->allow_login() )
        {
            if( $this->isLoggedIn() )
                $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/logout/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Logout');
            else
                $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/login/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Login');

            $data['MainMenu'][] = array('url'=>$this->DocumentRoot.'/'.$this->Product.'/credits/'.$this->CountryKey.'/'.$this->Keyword, 'label'=>'Credits Info');
        }

        $data['IsLoggedIn'] = $this->isLoggedIn();
        $data['CreditsAvailable'] = $this->Product_model->GetCredits();

        $data['Allow_Signup'] = $this->allow_signup();
        $data['Allow_Login'] = $this->allow_login();
        $data['Allow_MO_Optin'] = $this->Product_model->Allow_MO_Optin;

        if( $this->isLoggedIn() )
        {
            $data['Allow_Signup'] = $data['Allow_Login'] = $data['Allow_MO_Optin'] = false;
        }

        $data['Signup_Flow'] = $this->Product_model->getSubscriptionFlow();

        $data['Login_Flow'] = $this->Product_model->getLoginFlow();

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $data['SelectNetwork'] = false;

        if($this->Country->selectnetwork)
        {
            $query = $this->db->get_where('networks', array('country'=>$this->Country->iso));
            $networks = array();
            foreach($query->result() as $net)
            {
                $networks[] = "<option value=\"{$net->netkey}\">{$net->netlabel}</option>";
            }

            $data['SelectNetwork'] = "<select id=\"networkselect\" name=\"network\"><option selected value = ''>-- Select Your Network --</option>". implode("", $networks) ."</select>\n";


        }

        return $data;
    }

    protected  function isLoggedIn()
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

    public function index()
    {
        $this->number_detection();
        $data = $this->homepage_data();

        $this->Display( __FUNCTION__, $data);

    }

    function Display($page, $data=array())
    {
        $data['Content'] = $this->uri->segment(5);

        $data['Frequency'] = $this->Product_model->getMessageFrequency();

        $country = $this->uri->segment(3);

        switch($country)
        {

            case 'gr0':
                parent::Display('gr/'.$page, $data);
                break;

            default:
                parent::Display($page, $data);
        }
    }

    function content()
    {
        $data = $this->homepage_data();

        $content = $this->uri->segment(5);
        $content = urldecode($content);
        $total_items = $this->Product_model->GetItems($content,NULL, NULL);

        $data['Title'] = $content;
        $data['Pagination'] = "";
        $data['Items'] = array();
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

    function contenthome()
    {
        $data = $this->homepage_data();

        $content = $this->uri->segment(5);
        $content = urldecode($content);

        $total_items = $this->Product_model->GetItems($content,NULL, NULL);

        $data['Title'] = $content;
        $data['Pagination'] = "";
        $data['Items'] = array();
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

        $data['ShowMemberSection'] = true;

        $this->Display('content', $data);
    }

    function category()
    {
        $data = $this->homepage_data();

        $content = $this->uri->segment(5);
        $content = urldecode($content);

        $category = $this->uri->segment(6);
        $category = urldecode($category);

        if($content == "info" || $content == "Info")
        {
            $total_items = $this->Product_model->GetInfo($category, NULL, NULL);
        }
        else{
        $total_items = $this->Product_model->GetItems($content,$category, NULL);
        }
        $data['Title'] = $category ." ". $content;
        $data['Pagination'] = "";
        $data['Items'] = array();
        if($total_items)
        {
            $this->load->library('pagination');

            $config['base_url'] = $this->DocumentRoot.'/'.$this->Product.'/category/'.$this->CountryKey.'/'.$this->Keyword.'/'. trim($content) .'/'. trim($category) .'/';
            $config['total_rows'] = count($total_items);
            $config['per_page'] = $this->Product_model->getItemsPerPage();
            $config['uri_segment'] = 7;
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

    function search()
    {
        $data = $this->homepage_data();

        $search = $this->input->get('s');

        $total_items = $this->Product_model->SearchItems($search);

        $data['Title'] = 'Search Results - "'. $search .'"';
        $data['Pagination'] = "";
        $data['Items'] = array();
        if($total_items)
        {

            $this->load->library('pagination');

            $config['base_url'] = $this->DocumentRoot.'/'.$this->Product.'/search/'.$this->CountryKey.'/'.$this->Keyword.'/?s='. $search;
            $config['total_rows'] = count($total_items);
            $config['per_page'] = $this->Product_model->getItemsPerPage();
            $config['uri_segment'] = 5;
            $config['cur_tag_open'] = '<span class="current">';
            $config['cur_tag_close'] = '</span>';
            $config['anchor_class'] = ' class="inactive" ';
            $config['page_query_string'] = TRUE;

            $this->pagination->initialize($config);

            $offset = $this->uri->segment( $config['uri_segment'] );



            $data['Pagination'] = $this->pagination->create_links();

            $data['Items'] = array_slice($total_items,$offset, $config['per_page']);
        }


        $this->Display('content', $data);
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


        preg_match_all("/src=\"((http|https):\/\/([a-z\-]*)t([a-z]*)([0-9]+)\.gstatic\.com\/([^\"]+))/", $response, $images);


        if(isset($images[1]))
        {
            $images = $images[1];

            if( sizeof($images) > 0)
            {
                $imgurl = $images[1];
                header("Content-type: image/jpeg");
                #header("Location: {$imgurl}", 302);
                readfile($imgurl);
                return;
            }
        }

        echo "[no images found]";

    }

    function info_item()
    {

        $id = $this->uri->segment(5);
        return $this->show_infoItem($id);
    }

    function show_infoItem($id, $note=null, $error=null)
    {

        $data = $this->homepage_data();
        $item = $this->Product_model->GetInfoItem($id);
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

        $imageurl="/css/info/mobile/img/".strtolower($item['title']).".jpg";
        if($this->agent->is_mobile())
            $data['Item_Image'] = sprintf($imageurl,$img_width,$img_width);
        else
            $data['Item_Image'] = sprintf($imageurl,$img_width,$img_width);
        $data['Item_Title'] = $item['title'];
        $data['Item_Artist'] = $item['artist'];
        $data['Item_Type'] = $item['type'];
        $data['Item_Category'] = $item['category'];
        $data['Item_Content'] = $item['content'];

        $this->Display( 'info_item', $data);
    }

    function item()
    {
        $pcs = $this->uri->segment(5);
        return $this->show_item($pcs);
    }

    function terms()
    {
        $data = array();
        $data = $this->homepage_data();
        $data['Long_Terms_And_Conditions'] = $this->Product_model->getFullTerms();

        $this->Display( __FUNCTION__, $data);
    }

    private function show_item($pcs, $note=null, $error=null)
    {

        $data = $this->homepage_data();

        $item = $this->Product_model->GetItem($pcs);

        $this->Product_model->IncreaseDisplayedCount($item['dbID']);

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


        $singular = singular($item['type']);
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
                    if(strpos($this->uri->segment(3),'gr') !== false)
                    {
                        $data['Item_Note'] = "Για να πάρετε αυτό το στο τηλέφωνό σας, πατήστε το GET τώρα";
                    }
                    else
                    {
                    $data['Item_Note'] = "To get this {$singular} on your phone, press the GET now";
                    }
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
            $data['Item_Note'] = "<b style=\"color:black; font-weigh:bold;\">{$note}</b>";

        if(!isset($data['Item_Download']))
            $data['Item_Download'] = "Thank you";

        $this->Display( 'item', $data);
    }

    # TODO : Implement orderselectnetwork for mobile devices (select network, show enter number form)
    public function orderselectnetwork()
    {
        $pcs = $this->uri->segment(5);

        $item = $this->Product_model->GetItem($pcs);

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        $this->form_validation->set_rules('network', 'Network', 'required');

        $data = array();

        if ($this->form_validation->run() == FALSE)
        {
            return $this->show_item($pcs, "Please select your mobile network from the list!");
        }
        else
        {
            $network = $this->input->post('network');

            $MO_Keyword = "ITEM{$item['dbID']}";

            if(strlen($item['dbID']) > 3)
                $MO_Keyword = "P{$item['dbID']}";

            if($network == "airtelmw" || substr($network, -2) == "ke")
            {
                $data = $this->homepage_data();
                $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);
                $data['pcs'] = $pcs;
                $data['MOKeyword'] = $MO_Keyword;
                $data['SelNetwork'] = $network;

                return $this->Display('orderenternumber', $data);
            }
            else
            {
                return $this->show_item($pcs, "To get this item, sms <b>{$MO_Keyword}</b> to <b>". $this->siteconfig->getShortcode() ."</b>");
            }

        }
    }

    private function getItemNote($pcs)
    {
        return $this->session->flashdata('SHOW_ITEM_NOTE_'.$pcs);
    }
    private function setItemNote($pcs, $note)
    {
        $this->session->set_flashdata('SHOW_ITEM_NOTE_'. $pcs, $note);
        redirect( $this->DocumentRoot."/{$this->Product}/item/{$this->CountryKey}/{$this->Keyword}/{$pcs}/sent");
    }

    public function topup()
    {
        $pcs = $this->uri->segment(5);

        $flow = $this->Product_model->getSubscriptionFlow();

        if( $flow == SUBSCRIBE_FLOW_NONE)
        {
            return $this->setItemNote($pcs, "This service does not allow for top ups!");
        }

        if( $flow == SUBSCRIBE_FLOW_DIRECT_MALAWI)
        {
            # TODO : Implement TopUp Billing for Malawi
            return $this->setItemNote($pcs, "Not yet implemented!");
        }
        else
        {
            $this->session->set_userdata('MSISDN', $this->isLoggedIn() );
            $subscribed = $this->subscribe();
            if($subscribed === true)
                return $this->setItemNote($pcs, "Your new credits should be available shortly...");
            else
            {
                return $this->setItemNote($pcs, $subscribed);
            }
        }

    }

    public function download()
    {

        $pcs = $this->uri->segment(5);
        $msisdn = $this->session->userdata('LOGGED_IN');
        if( !$this->agent->is_mobile() )
        {
            if(strpos($this->uri->segment(3),'gr') !== false)
            {
                return $this->show_item($pcs, "Συγγνώμη, μπορείτε να κατεβάσετε μόνο αυτό το στοιχείο μέσω κινητής συσκευής!");
            }
            else
            {
            return $this->show_item($pcs, "Sorry, you can only download this item via mobile device!");
            }
        }

        $validateSession = $this->uri->segment(6);

        $sessionID = $this->session->userdata('session_id');

        #if($validateSession != $sessionID)
        #    return $this->sorry("Your session has expired!");

        $item = $this->Product_model->GetItem($pcs);

        if(!$item)
            return $this->sorry("The item you are searching for no longer exists!");

        $flow = $this->Product_model->getOrderFlow();

        if(!$this->allow_login())
        {
            $url = $this->Product_model->getDownloadURL($this->session->userdata('LOGGED_IN'), $this->siteconfig->getShortcode(), $pcs);
            $this->Product_model->IncreaseDownloadCount($item['dbID']);

            if(isset($this->Product_model->Black_List))
            {
                if($this->Product_model->Black_List == 1)
                {
                    $this->Product_model->addDailyDownloads();
                }
            }
            $this->Product_model->recordDownloads($pcs, $msisdn);

            redirect($url);
        }
        else
        {
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

                //echo $this->Product_model->getDownloadURL($this->session->userdata('LOGGED_IN'), $this->siteconfig->getShortcode(), $pcs);

                $url = $this->Product_model->getDownloadURL($this->session->userdata('LOGGED_IN'), $this->siteconfig->getShortcode(), $pcs);

                $this->Product_model->IncreaseDownloadCount($item['dbID']);
                if($flow == ORDER_FLOW_DLOAD_FOR_CREDITS)
                {
                    $this->Product_model->DeductCredits($item['price']);
                }

                if(isset($this->Product_model->Black_List))
                {
                    if($this->Product_model->Black_List == 1)
                    {
                        $this->Product_model->addDailyDownloads();
                    }
                }
                $this->Product_model->recordDownloads($pcs, $msisdn);

                redirect($url);
            }
            else
            {
                return $this->show_item($pcs, "Sorry, you cannot download this item!");
            }
        }
    }

    public function help_thanks()
    {
        $data = $this->homepage_data();

        $data['Contact_Email'] = $this->Product_model->getContactEmail();
        $data['Contact_us_Text'] = $this->Product_model->GetContactUsText();
        $this->Display( __FUNCTION__, $data);
    }

    public function help()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $msg = $this->input->post('comment')."\n\n".
                    $this->input->post('author')."\n".
                    "email : ". $this->input->post('email')."\n".
                    "mobile : ". $this->input->post('mobile')."\n".
                    "ip : ". $this->input->ip_address() ;

            $this->load->library('email');

            $this->email->from($this->input->post('email'), $this->input->post('author'));
            $this->email->to( $this->Product_model->getContactEmail() );
            $this->email->bcc('john.huseinovic@mobivate.com');

            $this->email->subject('Contact us form request '. $_SERVER['HTTP_HOST']);
            $this->email->message( $msg );
            $this->email->send();


            redirect( $this->DocumentRoot.'/'.$this->Product.'/help_thanks/'.$this->CountryKey.'/'.$this->Keyword );
        }

        $data = $this->homepage_data();
        $data['Contact_us_Text'] = $this->Product_model->GetContactUsText();
        $this->Display( __FUNCTION__, $data);
    }

    public function about()
    {
        $data = $this->homepage_data();
        $data['About_Us_Header'] = $this->Product_model->getAboutUsHeader();
        $data['About_Us_Text'] = $this->Product_model->getAboutUsText();

        $this->Display( __FUNCTION__, $data);
    }

    public function credits()
    {
        $data = $this->homepage_data();

        $data['Contact_us_Text'] = $this->Product_model->GetContactUsText();
        $data['Prices'] = $this->Product_model->GetPrices();

        $this->Display( __FUNCTION__, $data);
    }

    public function order()
    {
        $pcs = $this->uri->segment(5);

        #$validateSession = $this->uri->segment(6);
        #$sessionID = $this->session->userdata('session_id');
        #if($validateSession != $sessionID)
        #    return $this->sorry("Your session has expired!");

        $this->load->helper('shorturl');

        if( $this->Product_model->OrderContent( $pcs ) )
        {
            $result = $this->sendorderpin($pcs);
            if( $result === true )
            {
                return $this->setItemNote($pcs, "We have sent you a message. Please follow the instructions inside.");
            }
            else
            {
                return $this->sorry($result);
            }
        }
        else
        {
            return $this->sorry("Unfortunately, the content couldn't be requested at this moment! Please try again later.");
        }
    }

    private function sendorderpin($attr=null)
    {

        $shortcode = $this->siteconfig->getShortcode();


        $msisdn = $this->Product_model->getMSISDN( $this->input->post('mobile') );

        $this->session->set_userdata('MSISDN', $msisdn);

        $this->session->set_userdata('NETWORK', $this->input->post('network') );


        $message = $this->Product_model->getOrderPinMessage($this->Keyword,$msisdn,$attr);

        $response = srs::free_mt($shortcode,$msisdn,$message);

        if ($response === true) return true;

        return $this->srs->get_error($response);
    }

    public function orderpin()
    {
        $pcs = $this->uri->segment(5);

        $key = $this->input->get('key');

        $key = $this->encrypt->decode($key);

        $key = explode(":", $key);

        $msisdn = $key[0];
        $network = $key[1];

        $shortcode = $this->siteconfig->getShortcode();


        $result = parent::realStartSubscription($msisdn, $network);

        #var_dump($result);
        # check if user already exists!
        #$this->Product_model->CreateUser($mobile, $pin);

        #$this->postSubscription();

        $cost = $this->siteconfig->getPricing();
        $cost = preg_replace("/[^0-9]/","", $cost);


        $sent = $this->Product_model->SendContent($msisdn, $shortcode, $pcs, $cost);

        if( $sent === true )
        {
            $item = $this->Product_model->GetItem($pcs);
            $this->Product_model->IncreaseDownloadCount($item['dbID']);
            return $this->setItemNote($pcs, 'We have sent you your content via SMS. Please check your phone!');
        }
        else
            $this->sorry($sent);

    }

    public function ordermo()
    {
        $keyword = $this->input->get('keyword');
        $channel = $this->input->get('channel');
        $chanid = $this->input->get('chanid');
        $msisdn = $this->input->get('mobile');
        $subscription = $this->input->get('subscription');
        $carrier = $this->input->get('carrier');
        $service = $this->input->get('service');
        $trans = $this->input->get('trans');
        $cost = $this->input->get('cost');

        if(!$cost)
        {
            $cost = $this->siteconfig->getPricing();
            $cost = preg_replace("/[^0-9]/","", $cost);
        }

        $itemid = preg_replace("/[^0-9]/","", $keyword);

        $item = $this->Product_model->GetItemByID($itemid);

        $shortcode = $this->siteconfig->getShortcode();

        if( $this->Product_model->OrderContent( $item->id ) )
        {
            echo "Send Content #{$item->id} via {$shortcode} to {$msisdn} : ";
            $response = $this->Product_model->SendContent($msisdn, $shortcode , $item->id, $cost);

            if ($response === true)
            {
                $this->Product_model->IncreaseDownloadCount($item->dbID);
                echo "SUCCESS";
            }
            else
            {
                echo $response;
            }

        }
        else
        {
            echo "FAIL";
        }

    }

    public function do_signup()
    {

        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules('mobile', 'Mobile Number','Mobile', 'required|numeric');

            if( $this->Product_model->getLoginFlow() == LOGIN_FLOW_GOT_PIN )
                $this->form_validation->set_rules('pin', 'Custom PIN Number', 'required|numeric|min_length[4]|max_length[4]');


            if( $this->siteconfig->getTermsCheckbox($this->Product) )
                $this->form_validation->set_rules('terms', 'Terms & Conditions', 'required');


            if ($this->form_validation->run() == FALSE)
            {

                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/portal/index/") == true )
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
            redirect($this->DocumentRoot."/portal/signup_form/". $this->CountryKey ."/". $this->Keyword);
        else
            redirect($this->DocumentRoot."/portal/signup/". $this->CountryKey ."/". $this->Keyword);
    }

    protected function realStartSubscription($mobile, $pin)
    {

        $network = $this->input->post('network');

        $result = parent::realStartSubscription($mobile, $network);

        if( $result !== true )
        {
            $this->session->unset_userdata('MSISDN');
            $this->session->unset_userdata('LOGGED_IN');
            if( $this->agent->is_mobile() ){
                return $this->sorry($result);
            }
            else{
                return $this->sorry_iframe($result);
            }
        }


        # check if user already exists!
        $this->Product_model->CreateUser($mobile, $pin);
        $this->postSubscription();
    }

    public function signup_form()
    {
        $this->load->helper(array('form', 'url'));

        $data = $this->homepage_data();
        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $this->Display( __FUNCTION__, $data);
    }

    public function signup()
    {
        $this->load->helper(array('form', 'url'));

        $data = $this->homepage_data();
        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);

        $this->Display( __FUNCTION__, $data);
    }

    public function sorry($msg)
    {
        $data = $this->homepage_data();
        $data['ErrorMessage'] = $msg;
        $this->Display( __FUNCTION__, $data);
    }

    protected  function sorry_iframe($msg)
    {
        $data = $this->homepage_data();
        $data['ErrorMessage'] = $msg;
        $this->Display( __FUNCTION__, $data);
    }

    public function login()
    {
        if(!$this->allow_login())
            return $this->sorry("The Login has been disabled on this site!");

        $flow = $this->Product_model->getLoginFlow();

        $this->load->helper(array('form', 'url'));

        $data = $this->homepage_data();

        $data['EnterPINField'] = ($flow == LOGIN_FLOW_GOT_PIN);

        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric');

            if( $flow == LOGIN_FLOW_GOT_PIN )
                $this->form_validation->set_rules('pin', 'PIN Code', 'required|numeric');

            if ($this->form_validation->run() == FALSE)
            {
                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/portal/index/") == true )
                    return $this->sorry( validation_errors('<p>', '</p>'));
                else
                    return $this->sorry_iframe(validation_errors('<p>', '</p>'));
            }
            else
            {
                switch( $flow )
                {
                    case LOGIN_FLOW_GOT_PIN:
                        if( $this->Product_model->ValidateUser( $this->input->post('mobile'), $this->input->post('pin') ) )
                        {
                            $this->session->set_userdata('LOGGED_IN', $this->input->post('mobile'));
                            redirect($this->DocumentRoot.'/'.$this->Product.'/home/'.$this->CountryKey.'/'.$this->Keyword.'/');
                        }
                        else
                        {
                            $data['Error'] = $this->Product_model->Error;
                        }
                        break;
                    case LOGIN_FLOW_SEND_PIN:
                        if( $this->Product_model->SendLoginPIN( $this->input->post('mobile') ) )
                        {
                            redirect($this->DocumentRoot.'/'.$this->Product.'/login_pin/'.$this->CountryKey.'/'.$this->Keyword.'/');
                        }
                        else
                        {
                            $data['Error'] = $this->Product_model->Error;
                        }

                        break;
                    case LOGIN_FLOW_SEND_URL:
                        if( $this->Product_model->SendLoginURL( $this->input->post('mobile'), $this->CountryKey, $this->Keyword ) )
                        {
                            redirect("{$this->DocumentRoot}/{$this->Product}/loginsuccess/{$this->CountryKey}/{$this->Keyword}");
                            $data['Message'] = "We have sent you a text message to your phone, please check that message and follow the link provided!";
                        }
                        else
                        {
                            $data['Error'] = $this->Product_model->Error;
                        }
                        break;
                }

            }

        }

        $this->Display( __FUNCTION__, $data);
    }

    public function login_form()
    {
        if(!$this->allow_login())
            return $this->sorry("The Login has been disabled on this site!");

        $flow = $this->Product_model->getLoginFlow();

        $this->load->helper(array('form', 'url'));

        $data = $this->homepage_data();

        $data['EnterPINField'] = ($flow == LOGIN_FLOW_GOT_PIN);

        if( $_SERVER['REQUEST_METHOD'] == "POST")
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric');

            if(isset($this->Product_model->Black_List))
            {
                if($this->Product_model->Black_List == 1)
                {
                    $checked_mobile = $this->Country->prefix.substr($this->input->post('mobile'),1);

                    $this->Product_model->checkBlackList($checked_mobile);
                }
            }
            if( $flow == LOGIN_FLOW_GOT_PIN )
                $this->form_validation->set_rules('pin', 'PIN Code', 'required|numeric');

            if ($this->form_validation->run() == FALSE)
            {
                /* Modified by Jacy 23/01/2013 */
                #$data['validation_errors'] = validation_errors();
                if( $this->agent->is_mobile() || strstr($this->agent->referrer(), "/portal/index/") == true )
                    return $this->sorry( validation_errors('<p>', '</p>'));
                else
                    return $this->sorry_iframe(validation_errors('<p>', '</p>'));
            }
            else
            {
                switch( $flow )
                {
                    case LOGIN_FLOW_GOT_PIN:
                        if( $this->Product_model->ValidateUser( $this->input->post('mobile'), $this->input->post('pin') ) )
                        {
                            if( $this->agent->is_mobile() ){
                                $this->session->set_userdata('LOGGED_IN', $this->input->post('mobile'));
                            }
                            else{
                                $this->session->set_userdata('LOGGED_IN', $this->Country->prefix.$this->input->post('mobile'));
                            }

                            redirect("{$this->DocumentRoot}/{$this->Product}/pinsuccess/{$this->CountryKey}/{$this->Keyword}");
                        }
                        else
                        {
                            redirect("{$this->DocumentRoot}/{$this->Product}/pinfail/{$this->CountryKey}/{$this->Keyword}");
                        }
                        break;
                    case LOGIN_FLOW_SEND_PIN:
                        if( $this->Product_model->SendLoginPIN( $this->input->post('mobile') ) )
                        {
                            redirect($this->DocumentRoot.'/'.$this->Product.'/login_pin/'.$this->CountryKey.'/'.$this->Keyword.'/');
                        }
                        else
                        {
                            $data['Error'] = $this->Product_model->Error;
                        }

                        break;
                    case LOGIN_FLOW_SEND_URL:
                        if( $this->Product_model->SendLoginURL( $this->input->post('mobile'), $this->CountryKey, $this->Keyword ) )
                        {
                            redirect("{$this->DocumentRoot}/{$this->Product}/loginsuccess/{$this->CountryKey}/{$this->Keyword}");
                            $data['Message'] = "We have sent you a text message to your phone, please check that message and follow the link provided!";
                        }
                        else
                        {
                            $data['Error'] = $this->Product_model->Error;
                        }
                        break;
                }

            }

        }

        $this->Display( __FUNCTION__, $data);
    }

    public function login_pin()
    {
        $data = $this->homepage_data();

        $this->load->helper(array('form', 'url'));
        $pin = $this->input->get_post('pin');

        if( $this->Product_model->ValidateLoginPIN($pin) )
        {


            $this->session->set_userdata('LOGGED_IN' , $this->session->userdata('TEMP_MSISDN'));
            redirect($this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/');
        }
        else
        {
            if($pin)
                $data['Error'] = "The PIN you entered was incorrect. Please check your mobile phone for message containing valid PIN!";
            else
                $data['Error'] = "Please check your mobile phone for message containing valid PIN!";

            $this->Display( __FUNCTION__, $data);
        }
    }

    public function login_url()
    {
        $data = $this->homepage_data();


        $msisdn = $this->input->get('msisdn');
        $key = $this->input->get('key');
        $decoded = $this->encrypt->decode($key);

        if( $msisdn == $decoded )
        {
            $this->session->set_userdata('LOGGED_IN' , $msisdn);
            redirect($this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/');
        }
        else
        {
            $this->load->helper(array('form', 'url'));
            $flow = $this->Product_model->getLoginFlow();
            $data['EnterPINField'] = ($flow == LOGIN_FLOW_GOT_PIN);
            $data['Error'] = "The URL seems tempered with. Please check your mobile phone for message containing valid URL!";
            $this->Display('login', $data);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('MSISDN');
        $this->session->unset_userdata('LOGGED_IN');

        $content = $this->uri->segment(5);
        redirect($this->DocumentRoot.'/'.$this->Product.'/index/'.$this->CountryKey.'/'.$this->Keyword.'/'.$content);
    }


    public function test_pixels()
    {
        $type = (int)$this->uri->segment(5);

        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        header("Content-type: text/plain");
        echo $this->Pixels->get($type);
    }

    // http://DOMAIN/portal/once/gh0/keyword/{$Address}/{$pwd}
    public function once()
    {

        $Address = $this->uri->segment(5);
        $pwd = $this->uri->segment(6);

        if(!$Address)
            show_error("Missing Mobile Number. Please use the link from the message!");
        if(!$pwd)
            show_error("Missing Password. Please use the link from the message!");

        $curr = strtotime("-1 month");
        $now = $t1 = time();

        $matched = NULL;

        do
        {
            $tmp = date("m",$curr) . substr($Address,4,1) . date("d",$curr) . substr($Address, 6,1) . substr($Address, -1);
            #echo "testing : {$tmp} / " . substr($pwd,2) ."\n";
            if( $tmp == substr($pwd,2) )
            {
                $matched = date("Y-m-d", $curr);
                #	echo "match\n";
                break;
            }
            #echo "nope\n";
            $curr = strtotime("+1 day", $curr);
        } while( $curr <= $now );

        if(!$matched ) die("This password is not valid / Expired!");

        if($this->Product_model->hasClaimedPoints($Address, $matched))
            show_error("This password has already been used.");

        $this->Product_model->recordClaimedPoints($Address, $matched);

        $data = array('pixels'=>'');

        $this->session->set_userdata('LOGGED_IN' , $Address);
        $this->Display('thankyou', $data);

    }

    // http://DOMAIN/portal/pushItem/gh0
    public function pushItem()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('PCS', 'PCS', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('contentType', 'contentType', 'required');
        $this->form_validation->set_rules('category', 'category', 'required');
        $this->form_validation->set_rules('filename', 'filename', 'required');
        $this->form_validation->set_rules('preview_url', 'preview_url', 'required');
        $this->form_validation->set_rules('preview_html', 'preview_html', 'required');

        $data = array();

        if ($this->form_validation->run() == FALSE)
        {
            show_error("You are missing some required parameters!");
        }

        $this->Product_model->pushItem( $this->input->post() );

        echo "OK";

    }
}
