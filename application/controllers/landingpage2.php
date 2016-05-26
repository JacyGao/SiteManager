<?php
/**
 * Created by PhpStorm.
 * User: Jacy Gao
 * Date: 31/03/14
 * Time: 3:21 PM
 */
require_once( dirname(__FILE__) ."/landingpage1.php");

class Landingpage2 extends Landingpage1
{
    public function index()
    {
        $this->load->library('usertracking');
        $this->usertracking->track_this();

        $data['TermsCheckbox'] = $this->siteconfig->getTermsCheckbox($this->Product);
        $profile = $this->uri->segment(5);
        $data['Pro'] = $profile;
        switch($profile)
        {
            case "jane":
                $data['wordings'] = "I'm feeling flirty, <br>Text me honey!";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "suzy":
                $data['wordings'] = "I'm feeling naughty,<br>Text me babes!";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "carol":
                $data['wordings'] = "I'm alone and need attention,<br>Text me babes!";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "lisa":
                $data['wordings'] = "Come on, I'm waiting for you.<br>Text me honey! ";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "babes":
                $data['wordings'] = "Chat and connect with local girls now!";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "chat1":
                $data['wordings'] = "Chat with local girls waiting to connect with you now!";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "chat2":
                $data['wordings'] = "i'm available now and need some attention...<br>text me babes";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "chat3":
                $data['wordings'] = "i'm bored and ready to have some fun ;) <br>text me now honey";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "chat4":
                $data['wordings'] = "This is me when i get home from the gym.. i'm always in need of a soapy shower.. <br>come and join me ;)";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "chat5":
                $data['wordings'] = "HOT naughty girls online and available for you, <br>connect now!";
                $data['profile'] = $profile.".gif";
                $this->session->set_userdata('auto_sms', 1);

                if($this->agent->is_mobile())
                {
                    $data['background'] = "bg_black.jpg";
                }
                else
                {
                $data['background'] = "chat.jpg";
                }
                break;

            case "horochat":
                $data['wordings'] = "Want to know what's in your future? <br>Text us now, we have the answers..";
                $data['profile'] = "horo.png";
                $data['background'] = "horoscope.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            case "psychic":
                $data['wordings'] = "Want to know what's in your future? <br>Text us now, we have the answers..";
                $data['background'] = "psychic.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            case "funchat":
                $data['wordings'] = "Connect, chat and have fun online now!";
                $data['background'] = "funchat.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            case "funchat2":
                $data['wordings'] = "Want to have a fun chat? <br>She is waiting for you!";
                $data['background'] = "funchat2.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            case "funchat3":
                $data['wordings'] = "Want to have a fun chat? <br>She is waiting for you!";
                $data['background'] = "funchat3.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            case "relationships":
                $data['wordings'] = "Make that connection today and find your perfect match";
                $data['background'] = "relationships.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            case "datingtips":
                $data['wordings'] = "";
                $data['background'] = "datingtips.jpg";
                $this->session->set_userdata('auto_sms', 1);
                break;

            default:
                $data['wordings'] = "I'm bored and want some fun.<br>Text me honey!";
                break;
        }


        $this->_index($data);
    }

    public function doi()
    {
        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $shortcode = $this->siteconfig->getShortcode();
        $text = "YES (Press send to start your chat)";
        $link = $this->url_sms($shortcode, $text);
        $data = array();
        $data['pixels'] = $this->Pixels->get(PIXELTYPE_HTML);

        $data['Link'] = $link;
        $data['seconds'] = 3;
        if($this->Product_model->Auto_SMS==1)
        {
            if($this->session->userdata('auto_sms') && $this->session->userdata('auto_sms')==1)
            {
                $data['AutoSMS'] = 'on';
            }
            $this->session->unset_userdata('auto_sms');
        }
        $this->Display( __FUNCTION__, $data);
    }

}