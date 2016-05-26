<?php
/**
 * Created by John Huseinovic
 * Date: 28/11/12
 * Time: 11:07 AM
 */


function writeFile($level, $content)
{
    $level == trim(strtolower($level));
    log_message($level, $content);
}

function writeLog($level, $message)
{
    global $SESSION_ID;

    $LogBreaker = "\n";
    $LogDevider = " ][ ";
    if( is_array($message) ) {
        $msg = date('Y-m-d @ H:i:s') . $LogDevider . json_encode($message) . $LogBreaker;
    } else {
        $msg = date('Y-m-d @ H:i:s') . $LogDevider . $message . $LogBreaker;
    }
    writeFile( $level , $msg);
}
