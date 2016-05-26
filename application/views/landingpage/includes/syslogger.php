<?php
error_reporting(E_ALL);
$old_error_handler = set_error_handler("userErrorHandler");
define("U_DEBUG", 128);
define("LOG_DIR", dirname(__FILE__) . "/../../logs/");

// user defined error handling function
function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars) {
	if($errmsg == "Only variables should be assigned by reference")
        return;

	switch($errno) {
		case E_ERROR: 
			syslogger::error($errmsg);
			break;
		case E_WARNING:
			syslogger::warn($errmsg);
		default:
			syslogger::warn($errmsg);
	}
}


define("LOGGER_ALL_FILE", "all");
class syslogger {

	var $debug = false;
	var $screen = false;
	
	static function &getLogger() {
		static $instance;
		if(!isset($instance)) {
			$instance = new syslogger();
		}
		return $instance;
	}
	
	function outputToScreen($onoff) {
		$logger = &syslogger::getLogger();
		$logger->screen = true;
	}

	// Static methods
	function turnDebugOn($on)
    {
        $this->debug = $on;
    }
	function write($text, $file = LOGGER_ALL_FILE) {
		$logger = &syslogger::getLogger();
		$logger->writeToFile($text, $file);
	}

	static function debug($text, $file = "debug") {		
		$logger = &syslogger::getLogger();
		$logger->writeToFile("DEBUG:  {$text}", $file);
	}

	static function info($text, $file = "info") {
		$logger = &syslogger::getLogger();
		$logger->writeToFile("INFO:  {$text}", $file);
	}
	
	static function warn($text, $file = "warn") {
		$logger = &syslogger::getLogger();
		$logger->_warn($text, $file);
	}

	static function error($text, $file = "error") {
		$logger = &syslogger::getLogger();
		$logger->_error($text, $file);
	}
	
	static function fatal($text, $file = "fatal") {
		$logger = &syslogger::getLogger();
		$logger->_fatal($text, $file);
	}
	// Instance methods
	
	function _warn($text, $file) {
		$this->writeToFile("WARN:  {$text}", LOGGER_ALL_FILE);
		$text = $this->formatBacktrace($text);
				$file = "{$file}.warn";
		$this->writeToFile($text, $file);	
	}

	function _error($text, $file) {
		$this->writeToFile("ERROR: {$text}", LOGGER_ALL_FILE);
		$text = $this->formatBacktrace($text);
				$file = "{$file}.error";
		$this->writeToFile($text, $file);	
	}
	
	function _fatal($text, $file) {
		$this->writeToFile("FATAL: {$text}", LOGGER_ALL_FILE);
		$text = $this->formatBacktrace($text);
		$file = "{$file}.fatal";
		$this->writeToFile($text, $file);	
	}		
	
	function _debug($text, $file) {
		if(!$this->debug)
			return false;
		$this->writeToFile("DEBUG: {$text}", LOGGER_ALL_FILE);
		$text = $this->formatBacktrace($text);
		
		$file = "{$file}.debug";
		$this->writeToFile($text, $file);	
	}
	
	function formatBacktrace($text) {
		$text = explode("\n", $text);
		$text = implode("\n\t", $text) . "\n\t" . implode("\n\t", $this->getBacktrace());
		return $text;
	}
	
	function writeToFile($text, $file) {
		
		$dt = date("Y-m-d H:i:s");
		$output  = "--[ $dt ] {$text}\n";    	    

		$logfile = LOG_DIR . $file . "." . date("Y-m-d");  

		//if filesize is more than 1.8 GB, add to a new file with '-overflow' suffix
		if(file_exists($logfile)) {
			$size = filesize($logfile);
			if($size >= 1800000000) $logfile = $logfile."-overflow";

			//if still exceeds the limit..something is not right..how come there's such a large amount of log in one day
			//alert via email
			if(file_exists($logfile)) {
				$size = filesize($logfile);
				if($size >= 1800000000) {
					mail("pss.alerts@rawmobility.com","Logging too many entries ({$file})","Log file is getting too big ({$size}), please have a look at entries for $logfile. Something is not right");
					return false;
				}
			}
		}
		error_log($output, 3, $logfile);		
		if($this->screen) echo $output . "\n";
		//@chmod($logfile, 0666);
		if($file == LOGGER_ALL_FILE)
		if(strpos(strtolower($text), "mysql") !== FALSE) {
		//	mail("pss.alerts@rawmobility.com","Mysql error in PSS", $text);
		//	$this->smsAlert($text);
		}		

		return $logfile;
	}
	
	function smsAlert($message) {
		$message = urlencode($message);
		$url = "http://localhost/srs/enterprise/sendsmsv2?USER_NAME=mobileapps.any&PASSWORD=appl1cat10ns&ORIGINATOR=RawMobility&RECIPIENT=61417188345&PROVIDER=default&CAMPAIGN=default&MESSAGE_TEXT={$message}";
		file($url);
	}	
	
	
	function &getBacktrace($maxlines = -1) {
	    $out = "";
	    $caller = "";
	    $calls = array();
	    $files = "";
	    $backtrace = debug_backtrace();    
	    
	    
	    $backtrace = $backtrace;
	    $mincn = 2;
	    $c = 0;
	    $cn = count($backtrace) - 1;
	    
	    $me_filename = __FILE__;
	    $me_filename = strtr($me_filename, array(dirname($me_filename) . '/' => ''));
	    
	    $i = 1;
	    $bt = array();
	    
	    for($c=$cn;$c>$mincn;--$c) {
	        $bt = $backtrace[$c];
	
	        //$args = $this->formatArgs($bt, 50);
	        $type = isset($bt['type']) ? $bt['type'] : "";
	        $class = isset($bt['class']) ? $bt['class'] : "";
	        $line = isset($bt['line']) ? $bt['line'] : "?";
	        $realfile = isset($bt['file']) ? $bt['file'] : "/unknown";

                $argmaxlen = (($class == "dblogic") ? 900 : 50);
                $args = $this->formatArgs($bt, $argmaxlen);

	        $file = explode("/", $realfile);
	        $file = array_pop($file);
		if($file == $me_filename) {
			continue;
	            }
	        $curcaller = "";
	
	        if($c == $cn) {
	            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "console";
	            $cfile = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $realfile;            
	
	            if(!empty($_POST)) {
	                $calls[] = "[POST] {$cfile}\n" . _print_r($_POST, true);
	            }
	            
	            if(isset($_SERVER['HTTP_REFERER'])) {
	                $calls[] = "[REF] {$_SERVER['HTTP_REFERER']}";
	            }
	            
	            $calls[] = "({$ip}) [{$cfile}]";
	        }
	
	        if(($bt['function'] == 'userErrorHandler') || ($bt['function'] == 'trigger_error')) {
	            $calls[] = "[{$file}:{$line}] Error raised";
	            break;
	        } else {
	            $calls[] = "[{$file}:{$line}] {$class}{$type}{$bt['function']}( {$args} )";
	        } 
	
	        if($maxlines != -1) {            
	            if(--$maxlines <=0) {              
	                break;
	            }
	        }
	    }
	
	    $return = array_reverse($calls);
	    return $return;
	}
	
	function formatArgs($bt, $maxchars = 30) {
		$args = '';
		if (!isset($bt['args'])) $bt['args'] = array();
		$cur = 0;
		foreach ($bt['args'] as $a) {
			++$cur;
			if (!empty($args)) {
					$args .= ', ';
			}
			
			switch (gettype($a)) {
				case 'integer':
				case 'double':
					$args .= $a;
					break;
				case 'string':
					$a = (substr($a, 0, $maxchars)).((strlen($a) > $maxchars) ? '...' : '');
					$args .= "\"$a\"";
					break;
				case 'array':
					$args .= 'Arr('.count($a).')';
					break;
				case 'object':
					if(is_subclass_of($a, "Objectify_EntityBase"))
						$args .= 'Ent('.$a->GetEntityID().')'; 
					else 
						$args .= 'Obj('.get_class($a).')';
					break;
				case 'resource':
					$args .= 'Res('.strstr($a, '#').')';
					break;
				case 'boolean':
					$args .= $a ? 'True' : 'False';
					break;
				case 'NULL':
					$args .= 'Null';
					break;
				default:
					$args .= 'N/A';
			}
		}
		return $args;
	}
}
function safeget($array, $index, $default=null) {
        if (isset($array[$index]))
        return $array[$index];
        else
        return $default;
}


function log_error($errmsg, $file = LOGGER_ALL_FILE) {
	syslogger::error($errmsg, $file);
}   
function log_text($output, $file = "text") {
	syslogger::info($output, $file);
}
function logProcess($msg, $filename){
    syslogger::info($msg, $filename);
}

function _print_r($arr, $return=false)
{
	$out = array();
	$out[] = "Array[ ";
	foreach($arr as $key=>$val)
	{
		if( is_array($val) ) $out[] = "\t{$key} = ". _print_r($arr, $return);
		else $out[] = "\t{$key} = {$val}";
	}
	$out[] = "];";
	return implode(",", $out);
}

?>
