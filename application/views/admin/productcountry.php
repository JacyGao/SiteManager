<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>
<form method="post" action="" class="form" id="mainfrm" enctype="multipart/form-data">

    <p>
        <?
        foreach($ProductConfig as $key=>$val)
        {
            showField($key, $val, $ProductConfig, $Country);
            echo "\n";
        }
        ?>
    </p>

    <br clear="all" />
    <p><input type="submit" value=" Save Changes " class="submit" /> <input type="reset" value=" Reset Form " />
    </p>

</form>

<script>

    function setupMOChannel()
    {
        if( !confirm("Note: You only need to setup a channel once!\n\nIf you have done this before on this shortcode/service you don't need to set it up again!\n\nWould you like to proceed?"))
            return;

        var $frm = $('#mainfrm'),
            $usr = $frm.find('input[name="PSS_Account[username]"]').val(),
            $pwd = $frm.find('input[name="PSS_Account[password]"]').val();

        if($usr.length == 0)
        {
            alert('Please enter the PSS username!');
            $frm.find('input[name="PSS_Account[username]"]').focus();
        }
        if($pwd.length == 0)
        {
            alert('Please enter the PSS password!');
            $frm.find('input[name="PSS_Account[password]"]').focus();
        }

        $.post('/admin/setup_portal_item_channel/{CountryPath}',
            {username:$usr,password: $pwd},
            function(data)
            {
                alert(data);
            });
    }

    function setupMTChannel()
    {

        var $frm = $('#mainfrm'),
            $usr = $frm.find('input[name="PSS_Account[username]"]').val(),
            $pwd = $frm.find('input[name="PSS_Account[password]"]').val();

        if($usr.length == 0)
        {
            alert('Please enter the PSS username!');
            $frm.find('input[name="PSS_Account[username]"]').focus();
        }
        if($pwd.length == 0)
        {
            alert('Please enter the PSS password!');
            $frm.find('input[name="PSS_Account[password]"]').focus();
        }

        var $keyword = prompt("Please enter the Campaign Keyword you would like to use\n\n(eg. The keyword in the URL)","");

        if( !$keyword )
            return;

        var $chanid = prompt("Enter a Channel ID if you wish to ADD this keyword to an existing channel!\n\nLeave empty if you wish to CREATE a new channel\n\n(Hint: Channel ID can be found at the bottom of PSS Channel Screen)","");

        if( !$chanid )
            $chanid = "-1";


        $.post('/admin/setup_portal_item_channel/{CountryPath}',
            {username:$usr, password: $pwd, keyword: $keyword, channelid: $chanid},
            function(data)
            {
                alert(data);
            });
    }


    function checkOrderFlowSelection()
    {
        var $this = $("#Order_Flow"),
            $val = $this.val();

        if($val == <?=ORDER_FLOW_SHOW_KEYWORD?>)
        {
            $this.next('span.placeholder').html(' <button onclick="event.preventDefault(); setupMOChannel(); return false;"><span>Setup MO Billing Channel in PSS</span></button>');
        }
        else if($val == <?=ORDER_FLOW_DLOAD_FOR_CREDITS?>)
        {
            $this.next('span.placeholder').html(' <button onclick="event.preventDefault(); setupMTChannel(); return false;"><span>Setup MT Billing Channel in PSS</span></button>');
        }
        else
        {
            $this.next('span.placeholder').html('');
        }
    }

    $(document).ready(function()
    {
        checkOrderFlowSelection();

        $("#Order_Flow").change(function(e)
        {
            checkOrderFlowSelection();
        });

        $(".wysiwyg").htmlarea({
            toolbar: ["html", "|",
                "forecolor",  // <-- Add the "forecolor" Toolbar Button
                "|", "bold", "italic", "underline", "|", "h1", "h2", "h3", "|", "link", "unlink"] // Overrides/Specifies the Toolbar buttons to show
        });

        $('select[name="Order_Flow"]').change(function(e)
        {
            e.preventDefault();
            var $this = $(this),
               $val = $this.val(),
               $holder = $this.parent('.field');
               $explain = $holder.siblings('.explain');

            switch($val)
            {
                case '<?=ORDER_FLOW_ENTER_NUMBER?>':
                    $explain.html("Ask the user to enter number for each item they want to download. This will send the content via SMS to the device. (This option does NOT use the Credit System)");
                    break;
                case '<?=ORDER_FLOW_SHOW_KEYWORD?>':
                    $explain.html("Show the MO keyword to the user. Once they SMS IN the keyword, the item will be sent to them via  SMS. (This option does NOT use the Credit System).<br>Note: You need to make sure the MO channel is created, you can use the Setup button available!");
                    break;
                case '<?=ORDER_FLOW_DLOAD_FOR_CREDITS?>':
                    $explain.html("This option requires the Login to be enabled, since the user will need to have sufficient credits in order to download any content.");
                    break;
                case '<?=ORDER_FLOW_DLOAD_FOR_FREE?>':
                    $explain.html("Caution: This option will allow EVERYONE to download ALL the content for FREE!");
                    break;
                default:
                    $explain.html("");
                    break;
            }

        });

        $('select[name="Login_Flow"]').change(function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $val = $this.val(),
                $holder = $this.parent('.field');
            $explain = $holder.siblings('.explain');

            switch($val)
            {
                case '<?=LOGIN_FLOW_NO_LOGIN?>':
                    $explain.html("Disable Login - Users cannot log onto this site - It is not a Credit System!");
                    break;
                case '<?=LOGIN_FLOW_GOT_PIN?>':
                    $explain.html("All users have their OWN pin which they entered upon Signup.");
                    break;
                case '<?=LOGIN_FLOW_SEND_PIN?>':
                    $explain.html("Users are sent brand new 4 digit PIN each time they wish to Log in.");
                    break;
                case '<?=LOGIN_FLOW_SEND_URL?>':
                    $explain.html("Users are sent a brand new LINK each time they wish to Log in");
                    break;
                default:
                    $explain.html("");
                    break;
            }


        });


        $('div.fieldset[rel="Subscription_Flow"] div.field div.options div select').change(function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $val = $this.val(),
                $holder = $('div.fieldset[rel="Subscription_Flow"]').find('.field');
            $explain = $holder.siblings('.explain');

            switch($val)
            {
                case '<?=SUBSCRIBE_FLOW_NONE?>':
                    $explain.html("Disable Sign up - Users cannot signup on this page!");
                    break;
                case '<?=SUBSCRIBE_FLOW_PIN?>':
                    $explain.html("Allow Sign up - Ask user to confirm a 4 digit PIN which was sent to their mobile phone. Once confirmed, user is subscribed to PSS using the keyword from Campaign URL");
                    break;
                case '<?=SUBSCRIBE_FLOW_CLICK?>':
                    $explain.html("Click to sms - User clicks the link to send MO directly. (Mobile site only!)");
                    break;
                case '<?=SUBSCRIBE_FLOW_DOI?>':
                    $explain.html("Sign up user to PSS using keyword from Campaign URL - Trust PSS to handle the Double Opt-In confirmation");
                    break;
                case '<?=SUBSCRIBE_FLOW_DIRECT_MALAWI?>':
                    $explain.html("Direct Billing in Malawi Only");
                    break;
                case '<?=SUBSCRIBE_FLOW_VIA_WAP?>':
                    $explain.html("Send user a URL via SMS. Once clicked, user will be validated and subscribed using the keyword from Campaign URL");
                    break;
                case '<?=SUBSCRIBE_FLOW_MO_MSG?>':
                    $explain.html("Send user a SMS with the content send KEYWORD to SHORTCODE.");
                    break;
                case '<?=SUBSCRIBE_THROUGH_WAP_OPTIN?>':
                    $explain.html("Redirect user to integrat wap optin page");
                    break;
                case '<?=SUBSCRIBE_FLOW_MO?>':
                    $explain.html("Ask user to SMS in a keyword from Campaign URL to Sign Up");
                    break;
                case '<?=SUBSCRIBE_FLOW_HIDDEN?>':
                    $explain.html("Subscription is enabled, but hidden from the page. Mainly used to allow some features otherwise restricted if the Subscription is Disabled");
                    break;
                default:
                    $explain.html("");
                    break;
            }


        });

        $('select').each(function()
        {
            $(this).trigger('change');
        })


    });

</script>

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>

<?php
function showField($key, $val, &$SiteConfig, $Country)
{
    if( strstr($key,"_model") == true ) return;
    if( strstr($key,"*") == true ) return;
    if( substr($key, 0, 1) == "_") return;


    $Host = &$SiteConfig['Host'];
    #$Country = &$SiteConfig['Country'];

    switch($key)
    {
        case "id":
            echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />";
            break;

        case "Host":
            echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$Host->id}\" />";
            break;

        case "Country":
            echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$Country->id}\" />";
            break;

        default:

            echo "<div class=\"fieldset\" rel=\"{$key}\">";
            echo "<div class=\"label\">". humanize($key) ."</div>";
            echo "<div class=\"field\">";

            if( is_array($val) )
            {
                echo "<div class=\"options\">";
                echo showOptions($key, $val, $SiteConfig);
                echo "</div>";
            }
            elseif( is_object($val) )
            {
                echo "<div class=\"options\">";
                echo showOptions($key, (array)$val, $SiteConfig);
                echo "</div>";
            }
            else
            {
                switch($key)
                {
                    case "About_Us_Header":
                        echo "<input type=\"text\" size=60 name=\"{$key}\" value=\"{$val}\" placeholder=\"\" ><br />";
                        break;

                    case "Pin_Message":
                        echo "<input type=\"text\" size=60 name=\"{$key}\" value=\"{$val}\" placeholder=\"[INSTRUCTIONS] for {$Country['name']}s best mobile downloads\" > ".
                            "<small>** Enter <b>[INSTRUCTIONS]</b> to dynamically insert the correct instructions.</small><br />";
                        break;


                    case "About_Us_Text":
                        echo "<textarea rows=10 cols=60 name=\"{$key}\" placeholder=\"\" class=\"wysiwyg\">{$val}</textarea><br />";
                        break;

                    case "Contact_us_Text":
                        echo "<textarea rows=10 cols=60 name=\"{$key}\" placeholder=\"\" class=\"wysiwyg\" >{$val}</textarea><br />";
                        break;

                    case "Order_Flow":
                        echo "<select name=\"{$key}\" id=\"{$key}\">";
                        echo "<option value=\"". ORDER_FLOW_ENTER_NUMBER ."\" ". ($val == ORDER_FLOW_ENTER_NUMBER? "SELECTED":"") .">Enter Number</option>";
                        echo "<option value=\"". ORDER_FLOW_SHOW_KEYWORD ."\" ". ($val == ORDER_FLOW_SHOW_KEYWORD? "SELECTED":"") .">Show MO Keyword</option>";
                        echo "<option value=\"". ORDER_FLOW_DLOAD_FOR_CREDITS ."\" ". ($val == ORDER_FLOW_DLOAD_FOR_CREDITS? "SELECTED":"") .">Download for Credits</option>";
                        echo "<option value=\"". ORDER_FLOW_DLOAD_FOR_FREE ."\" ". ($val == ORDER_FLOW_DLOAD_FOR_FREE? "SELECTED":"") .">Download for Free</option>";
                        echo "</select><span class=\"placeholder\"></span>";
                        break;

                    case "Allow_MO_Optin":
                    echo "<select name=\"{$key}\">";
                    echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                    echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                    echo "</select> <span class=\"placeholder\">** Show 'Keyword' next in the Sign Up Form (Keyword comes from the Campaign URL)</span>";
                    break;

                    case "Subscribe_To_PSS":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select>";
                        break;

                    case "Info_Content":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select> <span class=\"placeholder\">** add information content to the site and replace Home button with Info</span>";
                        break;

                    case "Black_List":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select> <span class=\"placeholder\">** add black list check to the site and block access for suspected users</span>";
                        break;

                    case "Show_Logo":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select> <span class=\"placeholder\">** display logo image on the page</span>";
                        break;

                    case "Auto_SMS":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">Off</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">On</option>";
                        echo "</select> <span class=\"placeholder\">** Activated Auto SMS on Thank you Page</span>";
                        break;

                    case "Show_SMS_To_Action":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select> <span class=\"placeholder\">** display sms to action on the page</span>";
                        break;

                    case "Age_Confirmation_Page":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select> <span class=\"placeholder\">** Add age confirmation page to the site</span>";
                        break;

                    case "Auto_Catch_Mobile":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"0\" ". ($val == 0? "SELECTED":"") .">No</option>";
                        echo "<option value=\"1\" ". ($val == 1? "SELECTED":"") .">Yes</option>";
                        echo "</select> <span class=\"placeholder\">** Activate Auto Catch Keyword From URL Parameter</span>";
                        break;

                    case "Body_Image":
                        echo "<select name=\"{$key}\">";
                        echo "<option value=\"airtime\" ". ($val == "airtime"? "SELECTED":"") .">Airtime</option>";
                        echo "<option value=\"blackberry\" ". ($val == "blackberry"? "SELECTED":"") .">Blackberry</option>";
                        echo "<option value=\"iphone\" ". ($val == "iphone"? "SELECTED":"") .">Iphone</option>";
                        echo "<option value=\"newipad\" ". ($val == "newipad"? "SELECTED":"") .">New Ipad</option>";
                        echo "<option value=\"macbook\" ". ($val == "macbook"? "SELECTED":"") .">Macbook</option>";
                        echo "</select> <span class=\"placeholder\">** add information content to the site and replace Home button with Info</span>";
                        break;

                    case "Background_Colour":
                        echo '<input class="color">';
                        break;

                    default:

                        if( substr(strtoupper($key), 0, 5) == "FILE_" )
                        {
                            echo "<input type=\"file\" name=\"{$key}\" value=\"{$val}\" placeholder=\"{$key}\" >";
                        }
                        else
                        {
                            $len = strlen($val);
                            $size = $len + 5;
                            #if($len > 10) $size = 30;
                            #if($len > 30) $size = 40;
                            if($len > 100) $size = 100;

                            echo "<input type=\"text\" name=\"{$key}\" value=\"{$val}\" size=\"{$size}\" placeholder=\"{$key}\" >";
                        }

                        break;
                }

            }

            echo '</div>';
            echo '<div class="explain"></div>';
            echo '</div>';

            break;
    }
}

function showOptions($parent, $vals, &$SiteConfig)
{

    $type = "text";
    if( $parent == "Subscription_Flow" ) $type = "select";
    if( $parent == "Login_Flow" ) $type = "select";
    if( $parent == "Subscribe_To_PSS" ) $type = "radio";
    if( $parent == "Terms" ) $type = "textarea";
    if( $parent == "Content_Costs" ) $type = "table_text";

    switch($type)
    {

        case "select":
            $code = "";
            if($parent == "Subscription_Flow")
            {
                foreach($vals as $key=>$val)
                {
                    $code .= "<div><label for=\"{$key}\">{$key}</label>";
                    $code .= "<select name=\"{$parent}[{$key}]\">";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_NONE ."\" ". ($val == SUBSCRIBE_FLOW_NONE? "SELECTED":"") .">Disabled (no subscriptions)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_PIN ."\" ". ($val == SUBSCRIBE_FLOW_PIN? "SELECTED":"") .">PIN (send PIN message -> confirm PIN code)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_CLICK ."\" ". ($val == SUBSCRIBE_FLOW_CLICK? "SELECTED":"") .">Click to sms (click link to send MO)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_VIA_WAP ."\" ". ($val == SUBSCRIBE_FLOW_VIA_WAP? "SELECTED":"") .">WAP Link (send PIN link -> auto confirm)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_MO_MSG ."\" ". ($val == SUBSCRIBE_FLOW_MO_MSG? "SELECTED":"") .">MO Message (send SMS with reply keyword to shortcode)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_DOI ."\" ". ($val == SUBSCRIBE_FLOW_DOI? "SELECTED":"") .">Double Opt in (subscribe directly to PSS)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_MO ."\" ". ($val == SUBSCRIBE_FLOW_MO? "SELECTED":"") .">MO Only (show MO Keyword)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_DIRECT_MALAWI ."\" ". ($val == SUBSCRIBE_FLOW_DIRECT_MALAWI? "SELECTED":"") .">Direct Billing (Malawi)</option>";
                    $code .= "<option value=\"". SUBSCRIBE_THROUGH_WAP_OPTIN ."\" ". ($val == SUBSCRIBE_THROUGH_WAP_OPTIN? "SELECTED":"") .">Subscribe through wap opt-in</option>";
                    $code .= "<option value=\"". SUBSCRIBE_FLOW_HIDDEN ."\" ". ($val == SUBSCRIBE_FLOW_HIDDEN? "SELECTED":"") .">Enabled but Hidden</option>";
                    $code .= "</select></div>";
                }
            }
            elseif($parent == "Login_Flow")
            {

                foreach($vals as $key=>$val)
                {
                    $code .= "<div><label for=\"{$key}\">{$key}</label>";
                    $code .= "<select name=\"{$parent}[{$key}]\">";
                    $code .= "<option value=\"". LOGIN_FLOW_NO_LOGIN ."\" ". ($val == LOGIN_FLOW_NO_LOGIN? "SELECTED":"") .">No login</option>";
                    $code .= "<option value=\"". LOGIN_FLOW_GOT_PIN ."\" ". ($val == LOGIN_FLOW_GOT_PIN? "SELECTED":"") .">Enter Own PIN</option>";
                    $code .= "<option value=\"". LOGIN_FLOW_SEND_PIN ."\" ". ($val == LOGIN_FLOW_SEND_PIN? "SELECTED":"") .">Send and Ask for PIN</option>";
                    $code .= "<option value=\"". LOGIN_FLOW_SEND_URL ."\" ". ($val == LOGIN_FLOW_SEND_URL? "SELECTED":"") .">Send Login URL</option>";
                    $code .= "</select></div>";
                }
            }
            else
            {
                $code = "<select>";
                $code .= "";
                $code .= "</select>";
            }

            echo $code;
            break;

        case "table_text":
            $code = "<table cellspacing=2 cellpadding=2>";
            $code .= "<thead><tr>";
            foreach($vals as $key=>$val)
            {
                $code .= "<th>&nbsp;&nbsp; ". humanize($key) ."&nbsp;&nbsp; | </th>";
            }
            $code .= "<tr></thead>";
            $code .= "<tbody><tr align=center>";
            foreach($vals as $key=>$val)
            {
                $code .= "<td><input size=3 type=\"text\" name=\"{$parent}[{$key}]\" value=\"{$val}\"></td>";
            }
            $code .= "</tbody><tr>";
            $code .= "</table>";
            echo $code;
            break;

        case "radio":
            foreach($vals as $key=>$val)
            {
                $id = "r". md5($parent.$key.$val);
                echo "<input type=\"radio\" name=\"{$parent}\" value=\"{$val}\" id=\"{$id}\" > <label for=\"{$id}\">{$val}</label><br />";
            }
            break;

        case "checkbox":
            foreach($vals as $key=>$val)
            {
                $id = "r". md5($parent.$key.$val);
                echo "<input type=\"checkbox\" name=\"{$parent}[{$key}]\" value=\"{$val}\" id=\"{$id}\" > <label for=\"{$id}\">{$val}</label><br />";
            }
            break;

        case "textarea":
            foreach($vals as $key=>$val)
            {
                $id = "r". md5($parent.$key.$val);
                $cols = 60;
                $rows = 5;
                if($parent == "Terms" && $key == "long")
                    $rows=15;

                echo "<div><label for=\"{$id}\">". humanize($key) ."</label><textarea name=\"{$parent}[{$key}]\"  cols={$cols} rows={$rows} id=\"{$id}\" class=\"wysiwyg\" >{$val}</textarea></div>";
            }
            break;

        default:
            foreach($vals as $key=>$val)
            {
                if( $key != "countries")
                {
                    $id = "r". md5($parent.$key.$val);
                    $len = strlen($val);
                    $size = 10;
                    if($len > 10) $size = 30;
                    if($len > 30) $size = 40;
                    if($len > 50) $size = 50;

                    echo "<div><label for=\"{$id}\">". humanize($key) ."</label>";
                    echo "<input type=\"text\" name=\"{$parent}[{$key}]\" id=\"{$id}\" size=\"{$size}\" value=\"{$val}\" placeholder=\"not set\" >";
                    echo "</div>";
                }
            }
            break;
    }

}
