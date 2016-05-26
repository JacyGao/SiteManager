<?php
/**
 * Created by PhpStorm.
 * User: huseinovic
 * Date: 16/09/13
 * Time: 3:33 PM
 */

class fiftyonedegrees
{

    var $CI;

    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->library('user_agent');
    }

    function &detect()
    {
        $this->CI->load->library('user_agent');

        $ua = $this->CI->agent->agent_string();

        $properties = $this->search(array('ua' => $ua));

        unset($properties['id'], $properties['parent']);

        $properties['Browser'] = $this->CI->agent->browser();
        $properties['UserAgent'] = $ua;
        $properties['Platform'] = $this->CI->agent->platform();
        $properties['IsMobile'] = $this->CI->agent->is_mobile();

        if ($this->CI->agent->is_mobile())
            $properties['Mobile'] = $this->CI->agent->mobile();

        ksort($properties);
        $this->properties = $properties;
        return $this;
    }

    function get($param)
    {
        if (isset($this->properties[$param]))
            return $this->properties[$param];
        else
            return NULL;
    }

    function debug()
    {
        header("Content-type: text/plain");

        foreach ($this->properties as $key => $val) {
            echo "\n{$key}: " . var_export($val, true);
        }
    }


    function search($where = array())
    {
        $db = & $this->CI->db;

        $results = $db->get_where('51degrees_useragents', $where)->result();

        foreach ($results as $rs) {
            if (strstr($rs->parent, "-") == true) {
                return $this->search(array('id' => $rs->parent));
            } else {
                $profile = array();
                $this->profile(array('id' => $rs->parent), $profile);
                return $profile;
            }

        }
    }

    function profile($where = array(), &$profile)
    {
        $db = & $this->CI->db;

        $results = $db->get_where('51degrees_profiles', $where)->result_array();

        foreach ($results as $rs) {
            foreach ($rs as $k => $v) {
                if (!isset($profile[$k])) {
                    switch (true) {
                        case strtolower($v) == "true":
                            $v = TRUE;
                            break;
                        case strtolower($v) == "false":
                            $v = FALSE;
                            break;
                        case is_numeric($v):
                            $v = (int)$v;
                            break;
                    }
                    $profile[$k] = $v;
                }
            }

            if ((int)$rs['parent'] > 1) {
                return $this->profile(array('id' => $rs['parent']), $profile);
            } else {
                return true;
            }

        }
    }
}
