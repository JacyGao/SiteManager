<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log
{
    # If filesize > 2b bytes ~ 1.8gb then rename the file (archive)
    var $maximum_filesize = 2000000000;

    function __construct()
    {
        parent::__construct();

        //updated log levels according to the correct order
        $this->_levels	= array('ERROR' => '1', 'INFO' => '2',  'DEBUG' => '3', 'ALL' => '4');


        $filename = "log";
        if( isset($_SERVER['HTTP_HOST']))
            $filename = strtolower($_SERVER['HTTP_HOST']);

        $this->log_filepath = $this->log_path.$filename.'-'.date('Y-m-d').EXT;

        echo "writing to ".  $this->log_filepath;

    }

    function write_log($level = 'error', $msg, $php_error = FALSE)
    {
        if ($this->_enabled === FALSE)
        {
            return FALSE;
        }

        $level = strtoupper($level);

        if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
        {
            return FALSE;
        }


        $message  = '';

        if ( ! file_exists($this->log_filepath))
        {
            $message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
        }

        if ( ! $fp = @fopen($this->log_filepath, FOPEN_WRITE_CREATE))
        {
            return FALSE;
        }

        $message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);


        #@chmod($filepath, FILE_WRITE_MODE);


        if( filesize($this->log_filepath) > $this->maximum_filesize )
        {
            $this->write_log('info', "LogFile reached maximum file size ({$this->maximum_filesize}b), Rotate now!");
            $this->rotate_logfile();
        }

        return TRUE;
    }

    function rotate_logfile()
    {
        rename($this->log_filepath, $this->log_path.'log-'.date('Y-m-d_His').EXT);
    }

}
