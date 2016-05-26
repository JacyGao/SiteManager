<?php
/**
 * Created by John Huseinovic
 * Date: 17/11/12
 * Time: 2:34 PM
 */

class Admin extends CI_Controller
{
    private $User;

    function __construct()
    {
        parent::__construct();

        $this->load->library('Auth');

        $this->load->helper('inflector');
        $this->load->helper(array('form', 'url'));

        $this->load->model('Country_model');
        $this->load->model('Products_model');
        $this->load->model('Config_model');
        $this->load->model('Host_model');
        $this->load->model('User_model');
        $this->load->model('Traffic_model');
        $this->load->model('Upload_model');

        $this->Username = &$this->auth->getUsername();
        $this->UserID = &$this->auth->getUserID();

        $this->Hostname = strtolower($this->input->server('HTTP_HOST'));

        $this->Host_model->load($this->Hostname);

        if( $this->uri->segment(2) == "logout" )
            return true;

        if( !$this->CheckAccess() )
            show_error("You don't have access to this domains!<p>Please contact the Mobivate Support if you think you deserve access to this domain!</p>");
    }

    private function CheckAccess()
    {
        $domainAccess = $this->session->userdata('HasDomainAccess');

        if($domainAccess == "granted" OR $domainAccess == "super") return true;
        if($domainAccess == "no") return false;

        $access = $this->User_model->getHosts($this->UserID);
        if( !$access )
            show_error("You don't have access to any domains!");

        $this->session->set_userdata('HasDomainAccess', "no");
        foreach($access as $rs)
        {
            if($rs->hostid == "*")
            {
                $this->session->set_userdata('HasDomainAccess', "super");
                return true;
            }
            if($rs->hostid == $this->Host_model->id)
            {
                $this->session->set_userdata('HasDomainAccess', "granted");
                return true;
            }
        }

        return false;
    }

    /**
     * Return parsed page in correct template
     */
    private function Display($page, $data=array())
    {
        $template = 'admin/'. $page;
        $data['Username'] = $this->Username;
        $data['UserAccess'] = ucfirst($this->session->userdata('HasDomainAccess'));

        $data['Host'] = (array)$this->Host_model;
        $data['Countries'] = $this->Country_model->getAll();
        $data['Products'] = $this->Products_model->getAll();
        //$data['HostProducts'] = $this->Products_model->getHostProducts();

        if($page == "product")
        {
            $product = $this->uri->segment(3);
            $this->load->model($product."_model", "ProdConf");
        }


        foreach($data['Countries'] as $k=>$c)
        {
            $data['Countries'][$k]['Subs'] = array();

            $configs = $this->Config_model->loadAll($this->Host_model, $c);

            if( $configs )
            {
                foreach($configs as $conf)
                {
                    $config = json_decode($conf['config']);
                    $data['Countries'][$k]['Subs'][ $conf['countrynum'] ] = (array)$config;

                    if($page == "product")
                    {
                        $data['Countries'][$k]['Subs'][ $conf['countrynum'] ]['confid'] = $conf['id'];
                        $data['Countries'][$k]['Subs'][ $conf['countrynum'] ]['keywords'] = $this->Traffic_model->getKeywords($conf['id']);

                        $this->ProdConf->load($this->Host_model, $c, $conf['countrynum'], $product);
                        $data['Countries'][$k]['Subs'][ $conf['countrynum'] ]['properties'] = (array)$this->ProdConf;
                    }

                }
            }
        }

        return $this->parser->parse($template, $data);
    }

    /**
     * @return index page
     */
    function index()
    {

        $data = array();

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            $post = $this->input->post();

            $this->Host_model->hostname = $this->Hostname;
            $this->Host_model->sitename = $post['sitename'];
            $this->Host_model->homepage = $post['homepage'];

            $this->Host_model->save();
        }

        return $this->Display(__FUNCTION__, $data);
    }

    /**
     * @param $iso
     * @param int $num
     * @return display country page
     */
    function country($iso,$num=0)
    {
        $this->Country_model->load($iso);

        $data = array();

        $this->Config_model->load($this->Host_model, $this->Country_model, $num);

        $data['Products'] = $this->Products_model->getall();
        $data['Country'] = (array)$this->Country_model;
        $data['Host'] = (array)$this->Host_model;
        $data['SiteConfig'] = (array)$this->Config_model;

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            $post = $this->input->post();
            unset($post['id'], $post['Host'], $post['Country']);
            foreach($post as $key=>$val)
            {
                #echo "{$key} : ". print_r($val, true) ."<br>";

                $this->Config_model->$key = $val;
            }
            $this->Config_model->save();

            $data['SiteConfig'] = (array)$this->Config_model;
        }

        return $this->display(__function__, $data);

    }

    /**
     * @param $product
     * @return display product page
     *
     * list each country and offer configure / preview for the product in each country
     */
    function product($product)
    {
        $data = array();
        $data['Product'] = array();

        if($this->Products_model->load($product))
        {
            $data['Product'] = (array)$this->Products_model;
        }
        else
        {
            $data['Error'] = "Product not Found!";
        }


        return $this->display(__function__, $data);
    }

    /**
     * @param $path
     * @param $iso
     * @param int $cnum
     * @return display form page
     */
    function productcountry($path, $iso, $cnum=0)
    {
        $data = array();

        $this->load->model("Host_model");
        $this->load->model("Country_model");

        $this->Host_model->load( $this->input->server('HTTP_HOST') );

        $this->Country_model->load($iso);

        $this->load->model($path."_model", "ProdConf");

        $this->ProdConf->load($this->Host_model, $this->Country_model, $cnum, $path);

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            $post = $this->input->post();
            #unset($post['id'], $post['Host'], $post['Country']);
            foreach($post as $key=>$val)
            {
                #echo "{$key} : ". print_r($val, true) ."<br>";

                // TODO: Catch all File uploads, save and update $val to be uniq-filename hosted in location xyz...

                $this->ProdConf->$key = $val;
            }
            $this->ProdConf->save();
        }

        $data['ProductConfig'] = (array)$this->ProdConf;

        $data['Country'] = (array)$this->Country_model;

        $data['CountryPath'] = $iso."/".$cnum;

        return $this->display(__function__, $data);
    }

    /**
     * @param $iso
     * @param int $cnum
     * @return bool
     */
    function setup_portal_item_channel($iso,$cnum=0)
    {
        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');
        $keyword = $this->input->post('keyword');
        $channelid = (int)preg_replace("/[^0-9]/", "", $this->input->post('channelid'));

        $this->load->model("Host_model");
        $this->load->model("Country_model");

        $this->Host_model->load( $this->input->server('HTTP_HOST') );

        $this->Country_model->load($iso);

        $this->load->model("Portal_model", "ProdConf");

        $this->ProdConf->load($this->Host_model, $this->Country_model, $cnum, "portal");

        # load PSS and supply username and password!
        $this->load->library('pss', array('username'=>$usr, 'password'=>$pwd));

        $services = $this->pss->getUserServices(PSS_ALL_SERVICES);

        $this->load->library('siteconfig', array('country'=>$this->Country_model, 'countryKey'=>$cnum));

        $shortcode = $this->siteconfig->getShortcode();

        $billed_service = $services[PSS_BILLED_SERVICES][$shortcode]['id'];
        $free_service = $services[PSS_FREE_SERVICES][$shortcode]['id'];

        if(!$keyword)
        {
            do
            {
                $keyword = chr( rand(97,122) ) . chr( rand(97,122) ) . chr( rand(97,122) );
                $IsKeywordAvailable = $this->pss->IsKeywordAvailable($billed_service, $keyword);
            } while(!$IsKeywordAvailable);

            $channelName = "{$shortcode} MO Order Content Channel ". strtoupper($keyword);

            $orderURL = "http://". $this->Host_model->hostname ."/portal/ordermo/".$iso.$cnum."/join/?[KEYWORD]&[MOBILE]";
            $created = $this->pss->CreateChannel($channelName, $keyword, $billed_service, $free_service, array('{S:1}{R:42}{D:0}{U:'. $orderURL .'}{B:3}'));

            if($created)
            {
                $this->ProdConf->setOrderKeyword($keyword);
                $this->ProdConf->save();

                echo "Channel successfully created \"{$channelName}\"\n\nYou can moderate this channel to send welcome messages and poll scheduled content if you like.";
                return true;
            }
            else
            {
                echo "Failed to create channel! - Please try again.";
                return false;
            }
        }


        // ELSE We have a keyword specified...
        $keyword = preg_replace("/[^a-z0-9,]/", "", strtolower($keyword));
        if(preg_match("/^[0-9]/",$keyword))
        {
            echo "A keyword must start with a letter!\n\nChannel/Keyword not created!";
            return false;
        }

        $IsKeywordAvailable = $this->pss->IsKeywordAvailable($billed_service, $keyword);
        if(!$IsKeywordAvailable)
        {
            echo "It appears this keyword is already in use by another channel!\n\nChannel/Keyword not created!";
            return false;
        }



        if($channelid > 1)
        {
            $chan = $this->pss->getChannelInfo($channelid);
            if(!$chan)
            {
                echo "No channel found with that Channel ID, check the PSS for the valid Channel ID!";
                return false;
            }

            $this->pss->addKeywordToChannel($chan, $keyword);
            echo "Keyword '{$keyword}' added to {$chan->name}";
            return;
        }

        $channelName = "{$shortcode} Portal Campaign Channel ". strtoupper($keyword);

        if($iso == "ke")
        {
            $library = 3897; # MBVT Random password plugin library
            $hitURL = NULL;
        }
        else
        {
            $library = 2789; # Empty SMS Library
            $hitURL = "http://worker.mobivate.com/pssdlr/?[CHANNEL]&[CHANID]&[KEYWORD]&[MOBILE]&[SUBSCRIPTION]&[CARRIER]&[SERVICE]&[TRANS]&host=". $this->Host_model->hostname ."&db=". $this->ProdConf->Database->database;
        }

        $created = $this->pss->CreateChannel($channelName, $keyword, $billed_service, $free_service, array(), $library, $hitURL);

        if($created)
        {
            echo "Channel successfully created \"{$channelName}\"\n\nYou can moderate this channel to send welcome messages and poll scheduled content if you like.";
            return true;
        }
        else
        {
            echo "Failed to create channel! - Please try again.";
            return false;
        }

    }

    /**
     * @return display countries form / list page
     *
     * for super admins only
     */
    function countries()
    {
        if( $this->input->is_ajax_request() )
        {
            list($id, $field) = explode("_", $this->input->post('id'));
            $this->Country_model->update($id, $field, $this->input->post('value'));
            echo $this->input->post('value');
            return;
        }

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            $this->Country_model->create($this->input->post());

            redirect('/admin/countries/');
        }



        $data = array();

        $data['Countries'] = $this->Country_model->getAll();

        return $this->display(__function__, $data);
    }

    /**
     * @return display products form / list page
     *
     * for super admins only
     */
    function products()
    {
        if( $this->input->is_ajax_request() )
        {
            list($id, $field) = explode("_", $this->input->post('id'));
            $this->Products_model->update($id, $field, $this->input->post('value'));
            echo $this->input->post('value');
            return;
        }

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            $this->Products_model->create($this->input->post());

            redirect('/admin/products/');
        }

        $data = array();

        $data['ProductsTable'] = $this->Products_model->getAll();

        return $this->display(__function__, $data);
    }

    /**
     * @return display domains form / list page
     *
     * for super admins only
     */
    function domains()
    {
        if( $this->input->is_ajax_request() )
        {
            list($id, $field) = explode("_", $this->input->post('id'));
            $this->Host_model->update($id, $field, $this->input->post('value'));
            echo $this->input->post('value');
            return;
        }

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            $this->Host_model->create($this->input->post());

            redirect('/admin/domains/');
        }


        $data = array();

        $data['Domains'] = $this->Host_model->getAll();

        return $this->display(__function__, $data);
    }

    /**
     * @return display users form / list page
     *
     * for super admins only
     */
    function users()
    {
        $data = array();


        if( $this->input->is_ajax_request() )
        {
            list($id, $field) = explode("_", $this->input->post('id'));
            $this->User_model->update($id, $field, $this->input->post('value'));
            echo $this->input->post('value');
            return;
        }

        if( $this->input->server('REQUEST_METHOD') == "POST")
        {
            if( $this->input->post('password') == $this->input->post('password2') )
            {
                unset($_POST['password2']);
                $this->User_model->create($this->input->post());
                $data['Message'] = "User created!";
            }
            else
            {
                $data['Error'] = "Invalid password in the repeat field!";

            }

        }


        $data['Users'] = $this->User_model->getAll();

        return $this->display(__function__, $data);
    }

    /**
     * ajax page requests
     *
     * for super admins only
     */
    function usershosts($userid,$hostid=NULL,$action=NULL)
    {
        $data = array();
        $data['UserID'] = $userid;
        if(!$hostid)
        {
            $data['Granted'] = $this->User_model->getHosts($userid);
            $data['IsSuper'] = false;
            $data['Domains'] = $this->Host_model->getAll();
            foreach($data['Domains'] as $i=>$domain)
            {
                $data['Domains'][$i]['granted'] = false;
                if($data['Granted'])
                {
                    foreach($data['Granted'] as $g)
                    {
                        if($g->hostid == "*" || $g->hostid == $domain['id'])
                        {
                            $data['Domains'][$i]['granted'] = true;
                        }

                        if($g->hostid == "*")
                        {
                            $data['IsSuper'] = true;
                        }

                    }
                }
            }
            return $this->display(__function__, $data);
        }
        else
        {
            if($hostid == "super") $hostid = "*";

            switch($action)
            {
                case "grant":
                    $this->User_model->grant($userid,$hostid);
                    break;

                case "revoke":
                    $this->User_model->revoke($userid,$hostid);
                    break;
                default:
                    echo "UNKNOWN ACTION";
                    break;
            }
        }
    }

    /**
     * logout method, redirects back to root
     */
    function logout()
    {
        $this->session->unset_userdata('HasDomainAccess');
        $this->auth->logout();
        redirect("/");
    }


    function productkeyword($confid, $keyword=NULL, $cmd=NULL)
    {
        $keyword = trim($keyword);

        if($cmd == "delete")
        {
            $this->db->delete('traffic', array('configid'=>$confid, 'keyword'=>$keyword));
            echo json_encode(array('ok'=>true,'message'=>'Keyword / Pixel deleted'));
            return;
        }

        if( $this->input->server('REQUEST_METHOD') == "POST" && $cmd == "save" )
        {
            #todo: validate keyword if empty or if it does already exist on this service

            if(!$keyword)
            {
                echo json_encode(array('ok'=>false,'message'=>'Please enter your keyword!'));
                return;
            }

            $pixel = $this->input->post('pixel');
            $pixeltype = $this->input->post('pixeltype');

            $this->Traffic_model->load($confid, $keyword);
            $this->Traffic_model->pixel = trim($pixel);
            $this->Traffic_model->pixeltype = $pixeltype;
            $this->Traffic_model->save();

            echo json_encode(array('ok'=>true,'message'=>'Saved'));

            return;
        }



        $data = array();
        $data['keyword'] = $keyword;
        $data['traffic'] = false;
        $data['configid'] = $confid;

        if($keyword)
        {
            $traffic = $this->Traffic_model->load($confid, $keyword);
            $data['traffic'] = (array)$traffic;
        }

        return $this->Display('productkeyword', $data);

    }

    /**
     * File Upload methods, super user only
     */
    function upload()
    {
        $data = array();

        $data['error'] = "";
        $data['images'] = $this->Upload_model->getImages();

        return $this->display(__function__, $data);
    }

    function upload_success($data)
    {
        return $this->display(__function__, $data);
    }

    public function do_upload()
    {
        //var_dump(is_dir('custom/images/'));
        //exit();
        $config['upload_path'] = 'custom/images/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());

            exit(print_r($error['error']));
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            header('Location: /admin/upload/');
        }
    }

    function deleteImage()
    {
        $filename = end($this->uri->segment_array());
        $path = 'custom/images/'.$filename;
        $this->load->helper("url");

        unlink($path);
        header('Location: /admin/upload/');
    }

    function report()
    {
        $data = array();

        return $this->display(__function__, $data);
    }

    function download()
    {
        $this->load->helper('url');

        $get_start = $this->input->post('start');
        $get_end = $this->input->post('end');
        $type = $this->input->post('type');
        $kw = $this->input->post('keyword');
        $string = $this->input->post('code');
        $product = $this->input->post('product');

        $start = date("Y-m-d", strtotime($get_start));
        $end = date("Y-m-d", strtotime($get_end));
        $this->load->helper('curl');
        header("Content-type: text/plain");

        if($type=="detail")
        {
            $head = "Client IP,Referer Page,Landing Page, Time \n";
        }
        if($type=="total")
        {
            header('Location: /admin/getTotalReport/'.$start.'/'.$end.'/'.$kw.'/'.$string.'/'.$product.'/');
        }
        $data = curl_get(base_url().'admin/getDetailReport/'.$start.'/'.$end.'/'.$type.'/');
        $data = $head.$data;

        $this->load->helper('download');
        force_download('SiteVisitorRep.csv', $data);
    }

    function getDetailReport()
    {
        $this->load->helper('url');

        $start = $this->uri->segment(3);
        $end = $this->uri->segment(4);
        $type = $this->uri->segment(5);

        if($type == 'detail')
        {
            $this->db->select('client_ip, referer_page, request_uri, timestamp');
            $this->db->from('usertracking');
            $this->db->where("timestamp BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59'");
            $this->db->where("base_url LIKE '%".base_url()."%'");
            $query = $this->db->get();
            $rows = $query->result_array();

            foreach ($rows as $row)
            {
                echo $row['client_ip'].",".$row['referer_page'].",".$row['request_uri'].",".$row['timestamp']."\n";
            }
        }
        exit("Invalid Request! Please go back and try again!");

    }

    function getTotalReport()
    {
        $start = $this->uri->segment(3);
        $end = $this->uri->segment(4);
        $kw = $this->uri->segment(5);
        $string = $this->uri->segment(6);
        $product = $this->uri->segment(7);
        $str = $string."/".$kw;

        $uniqueViews = $this->getUniqueViews($start, $end, $str, $product);
        $uniqueVisitors = $this->getUniqueVisitors($start, $end, $str, $product);
        $data = array();
        $data['views'] = $uniqueViews;
        $data['visitors'] = $uniqueVisitors;

        return $this->Display('result', $data);

    }

    function getUniqueViews($start, $end, $kw, $product)
    {
        $this->load->helper('url');

        $this->db->select('timestamp, count(DISTINCT request_uri) AS uri');
        $this->db->from('usertracking');
        $this->db->where("timestamp BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59'");
        $this->db->where("request_uri LIKE '%".$kw."%'");
        $this->db->where("request_uri LIKE '%".$product."%'");
        $this->db->where("base_url LIKE '%".base_url()."%'");
        $this->db->group_by("timestamp");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function getUniqueVisitors($start, $end, $kw, $product)
    {
        $this->load->helper('url');

        $this->db->select('timestamp, count(DISTINCT client_ip) AS ip');
        $this->db->from('usertracking');
        $this->db->where("timestamp BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59'");
        $this->db->where("request_uri LIKE '%".$kw."%'");
        $this->db->where("request_uri LIKE '%".$product."%'");
        $this->db->where("base_url LIKE '%".base_url()."%'");
        $this->db->group_by("timestamp");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

}