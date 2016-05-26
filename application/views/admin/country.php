<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

<h1>Country Specific Configuration</h1>

    <form method="post" action="" class="form">

        <p>
            <?
            foreach($SiteConfig as $key=>$val)
            {
                showField($key, $val, $SiteConfig);
            }
            ?>
        </p>

        <br clear="all" />
        <p><input type="submit" value=" Save Changes " class="submit" /> <input type="reset" value=" Reset Form " />
        </p>

    </form>


<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>

<?php
function showField($key, $val, &$SiteConfig)
{
    $Host = &$SiteConfig['Host'];
    $Country = &$SiteConfig['Country'];

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

        case "Checkbox":

            echo '<div class="fieldset">';
            echo "<div class=\"label\">Terms and Conditions Checkbox</div>";
            echo "<div class=\"field\">";
            echo "<input type=\"text\" size=60 name=\"{$key}\" value=\"{$val}\" placeholder=\"eg. I agree to terms and conditions\" style=\"margin-bottom:2px;\">";
            echo "<div><small>Leave empty to disable the Checkbox completely!</small></div>";
            echo '</div>';
            echo '</div>';

            break;

        default:

            echo '<div class="fieldset">';
            echo "<div class=\"label\">". humanize($key) ."</div>";
            echo "<div class=\"field\">";

            if( is_array($val) )
            {
                echo "<div class=\"options\">";
                echo showOptions($key, $val, $SiteConfig);
                echo "</div>";
            }
            else if( is_object($val) )
            {
                echo "<div class=\"options\">";
                echo showOptions($key, (array)$val, $SiteConfig);
                echo "</div>";
            }
            else
            {
                switch($key)
                {
                    case "Country_Number":
                        echo "<input type=\"number\" size=3 name=\"{$key}\" value=\"{$val}\" placeholder=\"0\" ><br />";
                        break;

                    case "Sitename":
                        if(!$val)
                            $val = $Host->sitename;
                        echo "<input type=\"text\" size=60 name=\"{$key}\" value=\"{$val}\" placeholder=\"Name of the site (eg. {$Host->sitename})\" ><br />";
                        break;

                    case "Shortcode":
                        echo "<input type=\"number\" size=6 name=\"{$key}\" value=\"{$val}\" placeholder=\"Shortcode?\" ><br />";
                        break;

                    case "Pricing":
                        echo "<input type=\"text\" size=60 name=\"{$key}\" value=\"{$val}\" placeholder=\"eg. 2{$Country->currency} per message\" ><br />";
                        break;

                    case "Header_Note":
                        echo "<input type=\"text\" size=60 name=\"{$key}\" value=\"{$val}\" placeholder=\"Subscription Service ## per message, ##x/week\" ><br />";
                        break;

                    case "Joining_Fee":
                        echo "<input type=\"text\" size=30 name=\"{$key}\" value=\"{$val}\" placeholder=\"eg. 2{$Country->currency} Joining Fee\" ><br />";
                        break;

                    case "Mobile_Detection":
                        echo "<select name=\"{$key}\"><option value=\"1\" ". ($val == 1? "selected":"") .">Yes</option><option value=\"0\"". ($val == 0? "selected":"") .">No</option></select> ";
                        echo "Use MSISDN Detection if available?";
                        break;

                    case "Network_Detection":
                        echo "<select name=\"{$key}\"><option value=\"1\" ". ($val == 1? "selected":"") .">Yes</option><option value=\"0\"". ($val == 0? "selected":"") .">No</option></select> ";
                        echo "Use MNP Lookup before subscribing, if available?";
                        break;


                    default:
                        echo "<input type=\"text\" name=\"{$key}\" value=\"{$val}\" placeholder=\"{$key}\" ><br />";
                        break;
                }

            }
    
            echo '</div>';
            echo '</div>';

            break;
    }
}

function showOptions($parent, $vals, &$SiteConfig)
{

    $type = "text";
    if( $parent == "Subscription_Flow" ) $type = "select";
    if( $parent == "Terms" ) $type = "textarea";


    switch($type)
    {

        case "select":

            $code = "<select>";
            $code .= "";
            $code .= "</select>";

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
                echo "<label for=\"{$id}\">{$key}</label><textarea name=\"{$parent}[{$key}]\"  cols=60 rows=4 id=\"{$id}\" >{$val}</textarea><br />";
            }
            break;

        default:
            foreach($vals as $key=>$val)
            {
                if( $key != "countries")
                {
                    $id = "r". md5($parent.$key.$val);
                    echo "<label for=\"{$id}\">{$key}</label><input type=\"text\" name=\"{$parent}[{$key}]\" id=\"{$id}\" value=\"{$val}\" placeholder=\"not set\" >";
                    if ($parent == "Frequency")
                    {
                        $link = "http://{$SiteConfig['Host']->hostname}/{$key}/index/{$SiteConfig['Country']->iso}/test";
                        echo " <a href=\"{$link}\" target=_blank>[preview]</a>";
                    }
                    echo "<br />";
                }
            }
            break;
    }

}

?>
