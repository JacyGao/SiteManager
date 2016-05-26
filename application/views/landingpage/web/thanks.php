<?php
$url = $_SERVER["REQUEST_URI"];
$tokens = explode('/', $url);
$page=$tokens[3];

Switch ($page)
{
    case "sa0":
        $temp='South Africa';
        break;
    case "ke0":
        $temp='Kenya';
        break;
    case "gh0":
        $temp='Ghana';
        break;
    default:
        $temp='Your Country';
        break;
}
?>
<p style="color: black; text-align: center; font-size:36px;"><strong>
Thanks! You have been subscribed to <font color=red>Textplaywin!</font><br />
We will send you a text message shortly, follow the instruction to enjoy the best content in <?php echo $temp; ?>!


</p>