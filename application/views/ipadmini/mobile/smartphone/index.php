<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <title>{TITLE}</title>
    <link rel="stylesheet" type="text/css" href="{DocumentRoot}/css/{ProductPath}/mobile.css">

</head>

<body>
<img src="{DocumentRoot}/css/{ProductPath}/images/left.jpg" width="100%" height=""/>

<form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}" name="FrontPage_Form1" target="_self" onsubmit="return ValidateForm(this);" language="JavaScript">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="280" valign="top" align="center">


                <span style="color:red; font-size: 25px;">WIN A GREAT PRIZE!</span><br><span style="font-size: 25px;">& Get 1000 credits</span><br><br>

                <h2 style="margin:0px; font-size: 15px;">{Question}</h2>
                <?php if( isset($Error) ) echo "<script>alert('{$Error}');</script>"; ?>
                <table width="150" border="0" align="center" cellpadding="4" cellspacing="0">

                    <?php foreach($Answers as $opt): ?>
                    <tr>
                        <td align="left" valign="middle"><input name="answer" type="radio" value="<?=$opt?>" checked /></td>
                        <td align="left" valign="middle" style="font-size:16px;"><strong><?=$opt?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <p align="center" style="font-size:14px; font-weight:bold;">
                    Enter your mobile number:<br />
                    <span style="font-size:11px; color:#999999;">(format eg. {MobileExample})</span>

                    <span style="font-size:11px;">{Pricing}</span><br><br>
                    <input name="MobileNo" type="text" class="input" id="MobileNo" value="" maxlength="10" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" /><br />

                <div>{TermsCheckbox}</div>

                </p>
                <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/submit.jpg" width="220" height="54" /></p></td>
        </tr>
    </table>
</form>
<div class="footer">
<strong>Terms & Conditions:</strong>
{Terms_And_Conditions}

<p align="center"><span>Powered by <a href="http://www.mobivate.com" target="_blank"><strong>Mobivate</strong></a> &copy; <?=date("Y")?></span></p>
</div>

<? require_once(dirname(__FILE__) . "/inc_footer.php");?>