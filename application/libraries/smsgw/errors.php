<?php
/**
 * Created by John Huseinovic
 * Date: 28/11/12
 * Time: 11:03 AM
 */

require_once( dirname(__FILE__) ."/inc_functions.php" );

class errors
{
    static private $errors = array();

    const message_queued = -1;

    const success = 0;
    const invalid_username = 301;
    const invalid_password = 302;
    const site_disabled = 403;
    const generic_failure = 500;
    const network_delivery_failed = 501;
    const network_route_not_found = 502;
    const error_parsing_message = 506;
    const username_password_incorrect = 511;
    const duplicate_message_rejected = 513;
    const invalid_number_format_for_country = 514;
    const country_not_specified = 515;
    const originator_not_specified = 516;
    const originator_same_as_recipient = 518;
    const insufficient_credit = 523;
    const downstream_connection_error = 524;
    const carrier_rejected_message = 529;
    const message_too_large = 530;
    const empty_message = 531;
    const invalid_originator_address = 535;
    const generic_error = 550;
    const already_subscribed = 600;
    const invalid_number_format = 601;
    const carrier_not_supported = 602;
    const too_many_attempts = 603;
    const repeated_message = 604;
    const subscription_loop = 605;
    const optin_requested = 700;
    const undefined_gateway = 750;
    const gateway_timeout = 801;
    const mobile_not_specified = 802;
    const shortcode_not_specified = 803;
    const provider_not_specified = 804;
    const blacklisted_recipient = 805;
    const type_not_specified = 806;


    function explain($code)
    {
        switch ($code)
        {
            case self::success : return "Successful Send";
            case self::invalid_username : return "Invalid Username!";
            case self::invalid_password : return "Invalid Password!";
            case self::site_disabled : return "This site has been temporarily disabled. Please try again later!";
            case self::generic_failure : return "Generic Failure";
            case self::network_delivery_failed : return "Delivery to mobile network failed";
            case self::network_route_not_found : return "Failed to find a route to a valid network";
            case self::error_parsing_message : return "Error parsing the message request";
            case self::username_password_incorrect : return "Username or Password incorrect";
            case self::duplicate_message_rejected : return "Duplicate message rejected";
            case self::invalid_number_format_for_country : return "Mobile number you have entered does not match the pattern of that country. Please enter a valid mobile number.";
            case self::country_not_specified : return "Recipient Country not specified";
            case self::originator_not_specified : return "Originator not specified";
            case self::originator_same_as_recipient : return "The Originator and the Recipient are the same";
            case self::insufficient_credit : return "Insufficient credit in recipient account";
            case self::downstream_connection_error : return "Downstream connection error";
            case self::carrier_rejected_message : return "Upstream server or carrier rejected the message";
            case self::message_too_large : return "Message too large";
            case self::empty_message : return "Message is blank";
            case self::invalid_originator_address : return "Invalid ORIGINATOR Address";
            case self::generic_error : return "Generic Error";
            case self::already_subscribed : return "It appears that this number has already been subscribed once for this service.";
            case self::invalid_number_format : return "Invalid format of the mobile number";
            case self::carrier_not_supported : return "This carrier is not supported at this moment. Please try again later.";
            case self::too_many_attempts : return "This number has requested the PIN for this service too many times. Please contact support@mobivate.com for more information.";
            case self::repeated_message : return "You are trying to send this same message too many times.";
            case self::subscription_loop : return "Possible loop detected. Trying to subscribe too many times!";
            case self::optin_requested : return "Network does not allow PIN Validations! Please proceed to Double Opt-In";
            case self::undefined_gateway : return "Undefined Gateway";
            case self::gateway_timeout : return "We are experiencing difficulties communicating with the SMS gateway. We apologize for the inconvenience. Please try again later.";
            case self::mobile_not_specified : return "The mobile was not specified";
            case self::shortcode_not_specified : return "The shortcode was not specified";
            case self::provider_not_specified : return "The provider was not specified";
            case self::blacklisted_recipient : return "This number was blacklisted by recipient!";
            case self::message_queued : return "Message Queued for delivery!";
            case self::type_not_specified : return "Message Type not specified!";


            default: return "Unknown Error";
        }

    }

}
