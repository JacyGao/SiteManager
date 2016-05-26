<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */
class WapOptin extends MY_Controller
{
    #var $SiteName = "Please choose the country and the product";
    var $Description = "WAP Opt In";


    /**
     * Main page, redirect TO Integrat
     *
     * @author  John Huseinovic <john@huseinovic.net>
     * @return  bool|void
     */
    public function index()
    {
        /* Pixel Tracking for using wapdoi as landing page*/
        $this->wapdoiPixelTracking();

        $shortcode = $this->siteconfig->getShortcode();
        $keyword = $this->Keyword;

        $higate_product = $this->Product_model->getHigateProduct($shortcode, $keyword);
        if (!$higate_product) {
            log_message("info", "No such product found {$keyword}@{$shortcode}");
            redirect("/");
            return;
        }

        $days = explode(",", $higate_product->days);
        $cost = $higate_product->cost;
        $prod = $higate_product->prodID;

        $key = $this->Product_model->safe_get("Higate_User_Key");
        $host = $this->input->server('HTTP_HOST');
        $header = $this->Product_model->safe_get("Higate_Header_Image");
        $title = $this->siteconfig->safe_get('Sitename');
        $success_url = "wapoptin/success/{$this->CountryKey}/{$keyword}";
        $fail_url = "default";
        $helpline = $this->Product_model->safe_get("Higate_Helpline");
        $subscription_service = "yes";
        $billing_amount = $cost / 100;
        $billing_frequency = 1;
        $billing_currency = "ZAR";

        switch (true) {
            case count($days) == 7:
                $billing_frequency = 1;
                break;
            case count($days) == 1:
                $billing_frequency = 0;
                break;
            case count($days) == 2:
                $billing_frequency = "t";
                break;
            case count($days) == 3:
                $billing_frequency = "r";
                break;
            case true:
                $billing_frequency = count($days) . ":w";
                break;
        }

        require_once("/home/mobivate/public_html/smsgw/libraries/integrat.php");
        $integrat = new Integrat();

        $endpoint = $integrat->getURL($key, $host, $header, $prod, $success_url, $fail_url, $subscription_service, $billing_amount, $billing_frequency, $billing_currency, $helpline);

        log_message('info', "getURL( $key, $host, $header, $prod, $success_url, $fail_url, $subscription_service, $billing_amount, $billing_frequency, $billing_currency, $helpline ) => {$endpoint}");

        if (!$endpoint) {
            echo "Failed to request URL (Is the Account setup correctly?)";
            return false;
        }

        redirect($endpoint);

    }

    /**
     * Success Page - catcher when redirected back from Integrat
     *
     * @author  John Huseinovic <john@huseinovic.net>
     */
    function success()
    {
        log_message("info", "@ Success Page " . $_SERVER['REQUEST_URI']);

        $shortcode = $this->siteconfig->getShortcode();
        $keyword = $this->Keyword;

        // Load ProductCode
        $higate_product = $this->Product_model->getHigateProduct($shortcode, $keyword);
        if (!$higate_product) {
            log_message("info", "No such product found {$keyword}@{$shortcode}");
            redirect("/");
            return;
        }

        $days = explode(",", $higate_product->days);
        $cost = $higate_product->cost;
        $prod = $higate_product->prodID;

        // Check for errors!
        if($this->input->get('error') && strlen($this->input->get('error')) > 0 && !$this->input->get('msisdn'))
        {
            // There was an error, and NO MSISND is passed onto us!
            // Handle IT!
            $this->session->set_userdata('MSISDN_DETECTION_PERFORMED',true);
            $this->session->set_userdata('MSISDN', null);
            log_message("error", "MSISDN detection failed. ". $this->input->get('error'));
            redirect("/?error=". $this->input->get('error') );
        }


        // Load Configuration
        $Subscribe_To_PSS = (int)$this->Product_model->safe_get("Subscribe_To_PSS");
        $Redirect_On_Success = $this->Product_model->safe_get("Redirect_On_Success");

        // Replace Placeholders
        $replacements = array(
            '%COUNTRY' => $this->CountryKey,
            '%KEYWORD' => $keyword
        );
        $Redirect_On_Success = strtr($Redirect_On_Success , $replacements);

        // Grep variables
        $msisdn = $this->input->get('msisdn');
        $networkid = (int)$this->input->get('networkid');
        $optedin = $this->input->get('networkDOI') != 'false';
        $vcrf = $this->input->get('vcrf');

        log_message("info", "Shortcode: {$shortcode} / Keyword: {$keyword} / MSISDN: {$msisdn} / SubscribeToPSS: {$Subscribe_To_PSS} / Redirect: {$Redirect_On_Success}");

        // If number appears invalid, try decrypting it!
        if (substr($msisdn, 0, 2) != "27" || strlen($msisdn) < 10)
        {
            log_message("info", "MSISDN before Decryption: {$msisdn}");
            $msisdn = $this->scrypt($msisdn);
            log_message("info", "MSISDN after Decryption: {$msisdn}");
        }


        // If NetworkID == False, then initiate a custom DOI request.
        if ( !$optedin )
        {
            $this->load->library('srs');
            $response = $this->srs->SendDOIRequest($shortcode,$msisdn,$networkid,$prod,$keyword,'SILENT BILLING MESSAGE',0);
            log_message("info", "SendDOIRequest({$shortcode},{$msisdn},{$networkid},{$prod},...) => {$response}");
            $Subscribe_To_PSS = false;
        }

        // Store Session variables
        $this->session->set_userdata('MSISDN_DETECTION_PERFORMED',true);
        $this->session->set_userdata('MSISDN', $msisdn);

        // If Site Configuration suggests to Subscribe to PSS, and the $optedin = TRUE, then send MO to SRS.
        if ($Subscribe_To_PSS) {
            $this->load->model("Subscription_model");
            log_message("info", "Subscribe({$shortcode},{$msisdn},{$keyword})");
            $this->Subscription_model->Subscribe($shortcode,$msisdn,$keyword . ($vcrf? " (vcrf={$vcrf})":""),$networkid);
        }

        // Initiate Pixel tracking
        $checkVisitor = $this->checkIP();
        if(!empty($checkVisitor))
        {
            $this->load->model('Pixel_model', 'Pixels');
            $this->Pixels->init( $this->siteconfig , $keyword );
            $this->Pixels->save($this->input->get('msisdn'));
            $this->session->set_userdata('waptracking', $checkVisitor);
        }

        log_message("info", "Redirecting to {$Redirect_On_Success}");
        redirect($Redirect_On_Success);
    }

    private function scrypt($Str_Message)
    {
        $Len_Str_Message = strlen($Str_Message);
        $Str_Encrypted_Message = "";
        for ($Position = 0; $Position < $Len_Str_Message; $Position++) {
            $Key_To_Use = (($Len_Str_Message + $Position) + 1);
            $Key_To_Use = (255 + $Key_To_Use) % 255;
            $Byte_To_Be_Encrypted = substr($Str_Message, $Position, 1);
            $Ascii_Num_Byte_To_Encrypt = ord($Byte_To_Be_Encrypted);
            $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;
            $Encrypted_Byte = chr($Xored_Byte);
            $Str_Encrypted_Message .= $Encrypted_Byte;
        }
        return $Str_Encrypted_Message;
    }

    private function saveIP($ip, $subid, $date)
    {
        if (!$this->input->valid_ip($ip))
        {
            # Invalid IP do nothing
        }
        else
        {
            # Valid IP, insert the IP into database
            $this->Product_model->saveVisitor($ip, $subid, $date);
        }
    }

    private function checkIP()
    {
        $ip = $this->input->ip_address();
        $subid = $this->Product_model->checkVisitor($ip);

        if(!empty($subid))
        {
            return $subid;
        }
        else
        {
            return NULL;
        }
    }

    private function wapdoiPixelTracking()
    {
        if(isset($_GET['subid'])){

        $ip = $this->input->ip_address();
        $userAgent = $this->input->user_agent();
        $subid = $_GET['subid'];

        date_default_timezone_set('Australia/Melbourne');
        $date = date('Y-m-d h:i:s a', time());

        $this->saveIP($ip, $subid, $date);

        }
        else
        {
            # do nothing
        }
    }
}
