<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Load_Sample_Config extends CI_Migration
{

    public function up()
    {
        $this->config->load('sites/sm_mobirok_com');

        $ca = $this->config->item(CANADA);

        $this->load->model('Country_model', 'Country');

        $this->Country->Load(CANADA);

        $this->load->model('Config_model');

        $this->load->model('Host_model', 'Host');

        $this->Host->load('sm.mobirok.com');

        $this->Config_model->load($this->Host, $this->Country);

        $this->Config_model->Sitename = $ca['sitename'];
        $this->Config_model->Shortcode = $ca['shortcode'];
        $this->Config_model->Pricing = $ca['pricing'];
        $this->Config_model->HeaderNote = $ca['header_note'];
        $this->Config_model->Checkbox = $ca['checkbox'];
        $this->Config_model->SubscriptionFlow = $ca['subscription_flow'];
        $this->Config_model->PinMessage = $ca['pin_message'];
        $this->Config_model->MobileDetection = $ca['msisdn_detection'];
        $this->Config_model->NetworkDetection = $ca['msisdn_nmp'];
        $this->Config_model->Terms = $ca['terms'];
        $this->Config_model->Frequency = $ca['frequency'];

        $this->Config_model->save();
        return true;


    }

    public function down()
    {
        $this->db->truncate('products');
    }

}