<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- http://lygon.net/pure_admin/# -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>The SiteManager | Admin</title>
    <link rel="stylesheet" type="text/css" href="/css/admin/main.css"/>
    <!-- script src="http://code.jquery.com/jquery-latest.min.js"></script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="/css/admin/jscolor/jscolor.js"></script>


    <script type="text/javascript" src="/css/admin/jquery/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="/css/admin/jquery/jquery-ui-1.7.2.custom.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="/css/admin/jqueryui/ui-lightness/jquery-ui-1.7.2.custom.css" />

    <script type="text/javascript" src="/css/admin/wysiwyg/jHtmlArea-0.7.5.js"></script>
    <link rel="Stylesheet" type="text/css" href="/css/admin/wysiwyg/jHtmlArea.css" />

    <script type="text/javascript" src="/css/admin/wysiwyg/jHtmlArea.ColorPickerMenu-0.7.0.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="/css/admin/wysiwyg/jHtmlArea.ColorPickerMenu.css" />

    <style type="text/css">
            /* body { background: #ccc;} */
        div.jHtmlArea .ToolBar ul li a.custom_disk_button
        {
            background: url(/css/admin/wysiwyg/images/disk.png) no-repeat;
            background-position: 0 0;
        }

        div.jHtmlArea { border: solid 1px #ccc; }

        .explain { clear:left; font-size:11px; font-weight:normal; margin-bottom:10px; }
        
    </style>

    <script>
        $(document).ready(function (){
            $("#type").change(function() {
                // foo is the id of the other select box
                if ($(this).val() == "total") {
                    $("#foo").show();
                }else{
                    $("#foo").hide();
                }
            });
        });
    </script>

</head>
<body>
<div id="header"> <!-- This div contains both menus, information bars, the logo and slogan. -->
    <div id="logo"><img src="/css/admin/img/mobivate.png" alt="The SiteManager | Admin"/><br/>

        <div id="slogan">Setup and Manage your site</div>
    </div>
    <div id="user-info"><p><img src="/css/admin/img/user.gif" alt=""/> Welcome, <strong>{Username}</strong> |
        <a href="/admin/logout">Logout</a></p>
        <div id="login-info"><p>Login Access : {UserAccess}</p></div>
    </div>
    <div id="menu">
        <ul>
            <? $currPage = $this->uri->rsegments[2]; ?>

            <li <? if($currPage == "index") echo "class=\"selected\""; ?>><a href="/admin/">Dashboard</a></li>

            <?php if($UserAccess == "Super"): ?>
            <li <? if($currPage == "countries") echo "class=\"selected\""; ?>><a href="/admin/countries/">Countries</a></li>
            <li <? if($currPage == "products") echo "class=\"selected\""; ?>><a href="/admin/products/">Products</a></li>
            <li <? if($currPage == "domains") echo "class=\"selected\""; ?>><a href="/admin/domains/">Domains</a></li>
            <li <? if($currPage == "users") echo "class=\"selected\""; ?>><a href="/admin/users/">Users</a></li>
            <li <? if($currPage == "upload") echo "class=\"selected\""; ?>><a href="/admin/upload/">Uploader</a></li>
            <li <? if($currPage == "report") echo "class=\"selected\""; ?>><a href="/admin/report/">Report</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div id="master">

    <div id="sidebar-container">

        <div class="sidebar">
            <div class="title"><p>Countries</p></div>

            <ul>
                <? foreach($Countries as $country): ?>


                    <? if(sizeof($country['Subs']) == 0): ?>
                        <li><a href="/admin/country/<?=$country['iso']?>/0"><?=$country['name']?></a> <span style="color:#666666; font-style:italic;">Not configured</span></li>
                    <? else: ?>
                        <li><?=$country['name']?>
                            <ul>
                        <? foreach($country['Subs'] as $num=>$sc): ?>
                            <li><a href="/admin/country/<?=$country['iso']?>/<?=$num?>"><b><?=$sc['Shortcode']?></b> <small><?= "\"{$sc['Sitename']}\" ({$sc['Pricing']})" ?></small></a></li>
                        <? endforeach; ?>
                            <li><a href="/admin/country/<?=$country['iso']?>/<?=$num+1?>"><b>Add Another</b></a></li>
                            </ul>
                        </li>
                    <? endif; ?>

                <? endforeach; ?>
            </ul>
            <div class="sidebar-bottom"></div>
        </div>

        <div class="sidebar">
            <div class="title"><p>Products</p></div>
            <ul>
                {Products}
                <li><a href="/admin/product/{path}">{name}</a></li>
                {/Products}
            </ul>
            <div class="sidebar-bottom"></div>
        </div>

    </div>
    <div id="page">

    <? if(isset($Error)): ?>
    <div class="notice notice-error">{Error}</div>
    <? endif;?>

    <? if(isset($Message)): ?>
    <div class="notice notice-ok">{Message}</div>
    <? endif;?>

