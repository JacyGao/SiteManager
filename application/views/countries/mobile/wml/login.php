<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>

<p>
<h1>LOGIN NOW</h1>

Enter mobile :
<input name="mobile" type="text" id="input_phone" value=""><br />

<anchor>
    <go method="post" href="{DocumentRoot}/{ProductPath}/login/{Country}/{Keyword}/">
        <postfield name="mobile" value="$(mobile)"/>
        [ Continue ]
    </go>
</anchor>
<br />
</p>

<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>