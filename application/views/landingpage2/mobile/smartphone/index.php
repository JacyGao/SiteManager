<?php include("inc_head.php"); ?>

<!-- scroll down navigation bar -->
<nav class="navbar navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <a href="#"><span>TOP</span></a>
            </button>

            <!-- logo navigation bar -->
            <?if(isset($profile)){?>
            <a class="navbar-brand logo" href="#"><img src="{DocumentRoot}/css/{ProductPath}/images/{profile}" alt="Mobile Mojo" width="60px" height=""></a>
            <?}?>
        </div>

        <!-- navigation links -->
        <!--
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#homepage">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#screenshots">Screenshots</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        --><!-- end navigation links -->
    </div>
</nav> <!-- end scroll down navigation bar -->

<!-- header - homepage -->
<header id="homepage" class="nav-link" style="background: url({DocumentRoot}/css/{ProductPath}/images//parallax-bg/{background}) 50% 0 no-repeat;">

    <!-- background overlay -->
    <span class="mask-overlay"></span>

    <div class="container">
        <div class="row">

            <!-- homepage intro -->
            <section class="intro col-lg-12">

                <!-- homepage logo - write your site name -->
                <h1 class="intro-brand animate" data-animate="bounceInDown">
                    <?if(isset($profile)){?>
                        <img src="{DocumentRoot}/css/{ProductPath}/images/{profile}" alt="Mobirok" class="main_image">
                    <?}?>
                </h1>
                <!-- homepage slogan - write a cool slogan -->
                <h1 class="animate" data-animate="bounceIn">{wordings}</h1>

                <!-- homepage button links -->
                <form method="post" action="{DocumentRoot}/{ProductPath}/validate/{Country}/{Keyword}/{Pro}">
                <ul class="list-inline">
                    <li class="animate" data-animate="fadeInRight"><p>Enter your number here:</p></li>
                    <li class="animate" data-animate="fadeInRight"><input type="text" name="mobile" placeholder="647XXXXXXXX" style="width: 200px;height: 40px;font-size: 20px;padding: 5px 10px 0px 10px;"/></li>
                    <li class="animate" data-animate="fadeInRight"><p style="font-size:14px;">$1.50 per message</p></li>
                    <li class="animate" data-animate="fadeInLeft"><button type="submit" class="btn btn-default btn-lg bg-filler" style="font-size: 20px;">CHAT NOW</button></li>
                </ul>
                </form>
            </section> <!-- end homepage intro -->
        </div>
    </div>
</header> <!-- end header - homepage -->

<?php include("inc_foot.php"); ?>