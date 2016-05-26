<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:06 PM
 */
class Countries extends MY_Controller
{
    var $GProduct;
    #var $SiteName = "Please choose the country and the product";
    var $Description = "Select Country and Product";

    function __construct()
    {
        parent::__construct(false);
    }

    public function index()
    {
        $data = array();


        $this->load->model('Host_model', 'Host');
        $this->Host->load( $this->input->server('HTTP_HOST') );

        $this->load->model("Countries_model", "Countries");

        $data["Countries"] = $this->Countries->getCountriesProducts(  $this->Host, $this->DocumentRoot );
        list($first, $mid, $last) = explode(".", $_SERVER['HTTP_HOST']);
        $data['Pro']= $mid;
        $GProduct=$mid;
        switch($mid)
        {
            case "mintmonkey":
                $data['Prod_path'] = "redportal";
                $data['Landing_Keyword'] = "hot";
                break;
            case "mobilemojo":
                $data['Prod_path'] = "orangeportal";
                $data['Landing_Keyword'] = "mojo";
                break;
            case "textplaywin":
                $data['Prod_path'] = "orangeportal";
                $data['Landing_Keyword'] = "tpwdefault";
                break;
            case "fizzmobi":
                $data['Prod_path'] = "info";
                $data['Landing_Keyword'] = "default";
                break;
            default:

                $data['Prod_path'] = "Please Configure content product ";
                $data['Landing_Keyword'] = "Keyword is missing ";
                break;
        }

        $this->Display( __FUNCTION__, $data);
    }



}
