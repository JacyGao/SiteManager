<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 9/11/12
 * Time: 11:14 AM
 * To change this template use File | Settings | File Templates.
 */

# got to have a 'undefined' country for generic config rules!
$config['undefined']['sitename'] = 'CoolStuff4U';
$config['undefined']['homepage'] = 'http://sm.coolstuff4u.mobi/countries/';




$country = SOUTH_AFRICA;
$config[$country]['sitename'] = 'CoolStuff4U';
$config[$country]['shortcode'] = 38093;
$config[$country]['pricing'] = "R5/day + Joining Fee R10";
$config[$country]['header_note'] = "Joining Fee R10. Subscription Service R5/day";
$config[$country]['checkbox'] = "<input type=\"checkbox\" name=\"agree\" id=\"agree\"><small style=\"font-size:12px;\">I Agree to the <a href=\"%TERMS_URL%\" target=\"_blank\">Terms and Conditions</a></small>";
$config[$country]['subscription_flow']['mobile'] = SUBSCRIBE_FLOW_DOI;
$config[$country]['subscription_flow']['web'] = SUBSCRIBE_FLOW_DOI;
$config[$country]['pin_message'] = '$2/msg. For %1$s enter ur PIN %2$d on the web. Call 18665973803 for help. Reply STOP to cancel subscription';
$config[$country]['msisdn_detection'] = true;
$config[$country]['msisdn_nmp'] = true;
$config[$country]['terms']['short'] = "
        %SERVICE_DESCRIPTION%
        You may stop this subscription service at any time by texting STOP to 38093.
        This subscription service is available for all networks.
        Bill payer’s permission required. Min. age 18+ or with permission of parent or guardian.
        Mobirok operates according to the South African Wireless Application Service Providers’
        Association Code of Conduct. Helpdesk: <a href='mailto:help@mobirok.com'>help@mobirok.com</a> or 0822350499.
        Please Click here for <a href='http://www.mobirok.com/terms_general.html'>full terms and conditions</a>.";
$config[$country]['terms']['long'] = "long terms and conditions";
$config[$country]['frequency']['portal'] = "daily messages";



$country = KENYA;
$config[$country]['sitename'] = 'CoolStuff4U';
$config[$country]['shortcode'] = 88000;
$config[$country]['pricing'] = "$2.00 per message 5x/week";
$config[$country]['header_note'] = "Subscription service {$config[$country]['pricing']}";
$config[$country]['checkbox'] = "<input type=\"checkbox\" name=\"agree\" id=\"agree\"><small style=\"font-size:12px;\">I Agree to the <a href=\"%TERMS_URL%\" target=\"_blank\">Terms and Conditions</a><br>This is a subscription service where you receive %FREQUENCY% at %PRICING%. Please check to accept</small>";
$config[$country]['subscription_flow']['mobile'] = SUBSCRIBE_FLOW_DOI;
$config[$country]['subscription_flow']['web'] = SUBSCRIBE_FLOW_PIN;
$config[$country]['pin_message'] = '$2/msg. For %1$s enter ur PIN %2$d on the web. Call 18665973803 for help. Reply STOP to cancel subscription';
$config[$country]['msisdn_detection'] = true;
$config[$country]['msisdn_nmp'] = true;
$config[$country]['terms']['short'] = "For customer care, please email help@mobirok.com.
        %SERVICE_DESCRIPTION%
        The Mobirok %PRODUCT_NAME% offer is only for compatible handsets on Fido Solutions, TELUS Mobility, Rogers Wireless, SaskTel Mobility, Aliant Mobility / Bell Mobility, NorthernTel Mobility, MTS Mobility, Virgin Mobile Canada and Telebec Mobilite.
        Customers will receive content at $2.00 per message sent.
        All plans are subject to the Terms and Conditions.
        You may stop this subscription service at any time by sending a text message with STOP or ARRET to 88000.
        Your phone must have text messaging capability.
        You must be a resident of Canada and the owner of this device and either be at least sixteen years old or have the permission of your parent or guardian.
        Standard text messaging rates may apply.
        For information text HELP or AIDE to 88000 or call 1-866-597-3803.
        Please <a href=\"http://www.mobirok.com/terms_general.html\" target=_blank>Click here for full terms and conditions</a>.";
$config[$country]['terms']['long'] = "long terms and conditions";
$config[$country]['frequency']['portal'] = "daily messages";



$country = GHANA;
$config[$country]['sitename'] = 'CoolStuff4U';
$config[$country]['shortcode'] = 85900;
$config[$country]['pricing'] = "*£2 / message";
$config[$country]['header_note'] = "Subscribe to %SERVICE_NAME% for *£2 / message – 4 msgs / week";
$config[$country]['checkbox'] = "<input type=\"checkbox\" name=\"agree\" id=\"agree\"><small style=\"font-size:12px;\">I Agree to the <a href=\"%TERMS_URL%\" target=\"_blank\">Terms and Conditions</a></small>";
$config[$country]['subscription_flow']['mobile'] = SUBSCRIBE_FLOW_DOI;
$config[$country]['subscription_flow']['web'] = SUBSCRIBE_FLOW_DOI;
$config[$country]['pin_message'] = '$2/msg. For %1$s enter ur PIN %2$d on the web. Call 18665973803 for help. Reply STOP to cancel subscription';
$config[$country]['msisdn_detection'] = true;
$config[$country]['msisdn_nmp'] = true;
$config[$country]['terms']['short'] = "This is a subscription service. Cost is £2 per message until you send STOP to 85900.
        %SERVICE_DESCRIPTION%
        You will receive 4 %SERVICE_NAME% messages per week. *The cost is £2 per message. Total weekly cost is £8
        All plans are subject to the Terms and Conditions.
        You may stop this subscription service at any time by sending a text message with STOP, to short code 85900.
        Phone must have text messaging capability.
        You must be the owner of this device and either be at least sixteen years old or have the permission of your parent or guardian.
        Standard text messaging rates may apply. For more Information, contact Mobirok at <a href='mailto:help@mobirok.com'>help@mobirok.com</a> or 08455438729.
        ";
$config[$country]['terms']['long'] = "long terms and conditions";
$config[$country]['frequency']['portal'] = "daily messages";



