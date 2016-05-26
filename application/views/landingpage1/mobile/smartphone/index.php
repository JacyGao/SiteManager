<?php include("inc_head.php"); ?>

<table width="90%" border="0" align="center" class="{profile}">

    <!-- Show logo section if necessary -->
    <?if($ShowLogo == 1):?>
    <tr>
        <td align="center"><img src="/custom/images/header.jpg" width="{LogoWidthMobile}" height=""></td>
    </tr>
    <?endif;?>

    <!-- Show SMS to action section if necessary -->
    <?if($ShowSMSToAction == 1):?>
    <tr>
        <td align="center"><h3 style="text-align:center;">
            SMS <font color=red> {Keyword} </font>to <font color=red>{Shortcode}</font></h3></td>
    </tr>
    <?endif;?>

    <tr>
        <td align="center" style="font-size:11px;">{TextAboveImage}</td>
    </tr>

    <!-- Get body image url -->
    <!-- Images should be uploaded to {host}/custom/images/-->
    <tr>
        <td align="center"><img class="body-image" src="{DocumentRoot}/css/{ProductPath}/images/{BodyImageURL}" width="{BodyImageWidthMobile}" height=""></td>
    </tr>

    <!-- Display different instance for differnt subscription flow -->
    <!-- Show MO only -->
    <?if($SubscriptionFlow == "SUBSCRIBE_FLOW_MO"){?>
    <tr>
        <td><p align="center" style="font-size:14px; font-weight:bold;">SMS <font color=red> {Keyword} </font>to <font color=red>{Shortcode}</font></p></td>
    </tr>

    <!-- Click to SMS -->
    <?}else if($SubscriptionFlow == "SUBSCRIBE_FLOW_CLICK"){?>
    <tr>
        <td>
            <h3><a href="{SMSlink}" style="color: #000000; text-align: center;">CLICK HERE</a></h3>
            <h1><a href="{SMSlink}" style="color: #000000; text-align: center;">SMS <font color=red> {Keyword} </font>to <font color=red>{Shortcode}</font></a></h1>
            <h2><a href="{SMSlink}" style="color: #000000; text-align: center;">TO GET YOUR FREE CREDITS NOW!</a></h2>
        </td>
    </tr>

        <!-- Auto Catching Mobile Fron URL -->
    <?}else if($autoCatchMobile == 1){?>

        <tr>
            <td>
                <form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="" valign="top" align="center">

                                <p align="center" style="font-size:14px; font-weight:bold;">
                                    <input type="hidden" id="mobile" name="mobile" size="25" value="<?=$msisdn;?>" required placeholder=""
                                           pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 45px;" maxlength="10"><br />
                                    <span class="pricing-note">{PricingNote}</span>  
                                    <!-- submit button image -->
                                </p>
                                <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/{SubmitButtonImage}" / height="50" width="170"><br/>
                                </p>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    <!-- Enter number field -->
    <?}else{?>
    <tr>
        <td><form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}" name="FrontPage_Form1" target="_self">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="" valign="top">

                        <p align="center" style="font-size:10px; font-weight:bold;">

                            <span class="enter-phone">Enter your mobile number:</span>
                            <input type="text" id="mobile" name="mobile" size="25" required placeholder="{MobileExample}"
                                   pattern="\d+" style="text-align: left; font-size: 20px; padding-left: 10px; width:208px; height: 25px;" maxlength="10"><br />

                            <!-- <div>{TermsCheckbox}</div> -->
                            <span class="pricing-note">{PricingNote}</span>  
                        </p>
                        <p align="center"><input type="image" src="{DocumentRoot}/css/{ProductPath}/images/{SubmitButtonImage}" / height="50" width="221"><br/>
                        </p>
                    </td>
                </tr>
            </table>
        </form>
        </td>
    </tr>
    <?}?>
</table>

<?php include("inc_foot.php"); ?>