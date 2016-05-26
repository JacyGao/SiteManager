<?php
require_once(dirname(__FILE__) . "/inc_head.php");
/***********************
 * Created by Jacy Gao *
 * Date: 11/04/13      *
 * Time: 10:20 AM       *
 **********************/
?>

<!-- enter your number section-->
<section id="content-header">
    <div class="container">
    <div class="row-fluid">
    <div class="span12">
        <hgroup class="content-title welcome">

            <h1>If you are an existing member<br>
                Please enter your number to login</h1>
            <br />
            <form action="{DocumentRoot}/{ProductPath}/do_login/{Country}/{Keyword}/" method="post">
                <input type="text" name="mobile" placeholder="Enter Mobile" value="0" style="height:30px;font-size:15pt;width:90%;"><br>
                e.g.0700000000
                <br><br>
                <input type="submit" name="submit" value="GO!" style="height:25px;font-size:12pt;width:auto;">
            </form>
        </hgroup>
    </div>

    </div>
    </div>
</section>

<?require_once(dirname(__FILE__) . "/inc_foot.php");?>