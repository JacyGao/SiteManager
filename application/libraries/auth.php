<?php
/**
 * Created by John Huseinovic
 * Date: 17/11/12
 * Time: 3:15 PM
 */

class Auth
{
    private $auth_realm = "Authentication Required";
    private $auth_method = "basic";
    var $User = false;
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();

        if( !$this->is_loggedin() )
            $this->auth();
    }

    private function auth()
    {

        $username = $password = null;
        if (isset($_SERVER['PHP_AUTH_USER']))
        {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
        }
        elseif (isset($_SERVER['HTTP_AUTHENTICATION']))
        {
            if (strpos(strtolower($_SERVER['HTTP_AUTHENTICATION']),'basic')===0)
            {
                list($username,$password) = explode(':',base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
            }
        }

        if ( !$this->checkLogin($username, $password) )
        {
            $this->forceLogin();
        }
    }

    private function forceLogin()
    {
        if( $this->auth_method  == 'basic')
        {
            header('WWW-Authenticate: Basic realm="'.$this->auth_realm.'"');
        }
        elseif( $this->auth_method == 'digest')
        {
            header('WWW-Authenticate: Digest realm="' . $this->auth_realm . '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($this->auth_realm) . '"');
        }

        header('HTTP/1.0 401 Unauthorized');
        show_error('User authentication required! Reload the page to be prompted again!', 401);
        die();
    }

    private function checkLogin($username, $password)
    {


        $users = $this->CI->db->get_where('users', array('username'=>$username, 'password'=>$password));

        if( $users->num_rows() == 0 )
            return false;

        $user = $users->row(0);

        $this->CI->session->set_userdata('username', $user->username);
        $this->CI->session->set_userdata('userid', $user->id);


        return true;
    }

    private function is_loggedin()
    {
        return $this->CI->session->userdata('username');
    }

    public function logout()
    {
        $_SERVER['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_PW'] = $_SERVER['HTTP_AUTHORIZATION'] = NULL;

        $this->CI->session->unset_userdata('username');
        $this->CI->session->unset_userdata('userid');
    }

    public function getUsername()
    {
        return $this->CI->session->userdata('username');
    }

    public function getUserID()
    {
        return $this->CI->session->userdata('userid');
    }

}

