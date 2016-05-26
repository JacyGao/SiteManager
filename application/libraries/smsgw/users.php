<?php
/**
 * Created by John Huseinovic
 * Date: 28/11/12
 * Time: 11:03 AM
 */
require_once( dirname(__FILE__) ."/inc_functions.php" );

class users
{

    static function &getUsers()
    {
        $users = array();
        $users['mobivate'] 	= '4Gd3-tDsc';
        $users['smiley'] 	= 'fgt2d-32_';
        $users['cpxsa'] 	= 'dfwsd-43!';
        $users['atrinsic'] 	= 'gj30f-21c';
        $users['strawberry'] = '3512-523dQ';
        $users['peach'] 	= '4-23523-dqA';
        $users['websmart'] 	= 'demo';
        $users['mahalasms'] = 'g02d-qff1';
        $users['ussd'] 		= 'akdf912d1-1';
        $users['bongo']		= 'dkgh203f-a1';
        $users['tdu'] 		= 'dg42-3324!';
        $users['boomsouth'] = '4fa3-gaes_';
        $users['cpxsa'] 	= 'dfwsd-43!';
        $users['cpxca'] 	= 'dfwsd-4gj';
        $users['chiro'] 	= '0h51d30-f';
        $users['dentist'] 	= '0h51d30-f';
        $users['mobigr8quiz'] = 'kgj30gj-1';
        $users['textastar'] = 't29g4-1945!';
        $users['mundo'] 	= 'gj20g-2ss';
        $users['hotxxx'] 	= 'dt3fh3d';
        $users['cmgkenya'] 	= 'gs4@fd5!';
        $users['cmgghana'] 	= '35fgg43f@ge';
        $users['3way'] 	    = 'g20gn48hg';
        $users['monitorus'] = 'jg03fjg';
        $users['sexymango'] = 'g9023ng024$';
        $users['freeworldwide'] = 'bI3FMzJi';

        return $users;
    }

    function validate($username,$password)
    {
        $users = self::getUsers();
        if( !isset($users[ $username ]) )
        {
            writeLog('auth', "Invalid Username {$username}");
            return false;
        }

        if( $users[$username] != $password )
        {
            writeLog('auth', "Invalid Password {$username} : {$password}");
            return false;
        }

        return true;
    }

    function getPassword($username)
    {
        $users = self::getUsers();

        if( !isset($users[$username]) )
            return false;

        return $users[$username];
    }

}
