<?php require_once(dirname(__FILE__) . "/inc_head.php");?>


    <div class="header-form-wrap container">
        <div class="header-form header-login-form clearfix">
            <form action="{DocumentRoot}/{ProductPath}/do_login/{Country}/{Keyword}" method="POST">
                <div class="message"></div>
                <div class="field-wrap">
                    <input type="text" name="user_login" value="" placeholder="Username" class="static" />
                </div>
                <div class="field-wrap">
                    <input type="password" name="user_password" value="" placeholder="Password" class="static" />
                </div>
                <a href="#" class="button submit-button">Sign In</a>
                <a href="#" class="button secondary header-password-button" title="Password Recovery">
                    <span class="button-icon icon-lock nomargin"></span>
                </a>
                <input type="hidden" name="user_action" value="login_user" />
                <input type="hidden" class="nonce" value="faea368169" />
                <input type="hidden" class="action" value="themex_update_user" />
            </form>
        </div>
        <div class="header-form header-password-form clearfix">
            <form class="ajax-form formatted-form" action="{DocumentRoot}/{ProductPath}/reset_password/{Country}/{Keyword}" method="POST">
                <div class="message"></div>
                <div class="field-wrap">
                    <input type="text" name="user_login" value="" placeholder="Username" />
                </div>
                <a href="#" class="button submit-button">Reset Password</a>
                <input type="hidden" name="user_action" value="reset_password" />
                <input type="hidden" class="nonce" value="faea368169" />
                <input type="hidden" class="action" value="themex_update_user" />
            </form>
        </div>
    </div>


    <!-- /forms -->
    <div class="header-content-wrap">
        <div class="header-content container">
            <h1 class="page-title">  Profiles</h1>
        </div>
    </div>
    <!-- /content -->
</div>
<div class="content-wrap">
<section class="site-content container clearfix">
<div class="column eightcol">
<div class="profiles-listing clearfix">

<?php
    $i = 1;
    foreach($Profiles as $profile):?>
<?if($i % 3 === 0) {?>
    <div class="column fourcol last">
    <?}else{?>
    <div class="column fourcol ">
    <?} $i++;?>
    <div class="profile-preview">
        <div class="profile-image">
            <a href="{DocumentRoot}/{ProductPath}/profile/{Country}/{Keyword}/<?=$profile['ID']?>"><img src="/custom/images/<?=$profile['imageurl']?>" class="avatar" width="200" alt="" /></a>
        </div>
        <div class="profile-text">
            <h5><span title="Online" class="profile-status online"></span><a href="http://themextemplates.com/demo/lovestory/profile/brian"><?=$profile['name']?></a></h5>
            <p><?=$profile['age']?> years old <?=$profile['gender']?> from <?=$profile['city']?>, <?=$profile['state']?></p>
        </div>
        <div class="profile-options popup-container clearfix">
            <div class="profile-option">
                <a href="{DocumentRoot}/{ProductPath}/profile/{Country}/{Keyword}/<?=$profile['ID']?>" title="Live Chat" class="icon-comment"> Text Me!</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<div class="clear"></div>

</div>

<!-- /profiles -->
<!--
<nav class="pagination"><span class='page-numbers current'>1</span>
    <a class='page-numbers' href='http://themextemplates.com/demo/lovestory/profiles/page/2'>2</a>
    <a class="next page-numbers" href="http://themextemplates.com/demo/lovestory/profiles/page/2"></a></nav>

-->
</div>

    <!-- register -->


    <aside class="sidebar column fourcol last">

    <!-- Register -->
    <?php if(!$IsLoggedIn): ?>
    <div class="widget widget_themex_search">
        <h4 class="widget-title">Register</h4>

        <div class="profile-search-form">
            <form action="{DocumentRoot}/{ProductPath}/do_signup/{Country}/{Keyword}" method="post">
                <div class="message"></div>
                <div class="field-wrap">
                    <input type="text" name="username" value="" placeholder="Username" />
                </div>
                <div class="field-wrap">
                    <input type="text" name="password" value="" placeholder="Password" />
                </div>
                <div class="field-wrap">
                    <input type="text" name="email" value="" placeholder="Email" />
                </div>
                <a href="#" class="button submit-button form-button">Register</a> <p>Register now to receive special chat offers, including free messages</p>
                <div class="loader"></div>
            </form>
        </div>
    </div>

    <div class="clear"></div>
    <?php endif;?>
    <!-- Search Bar -->
    <div class="widget widget_themex_search"><h4 class="widget-title">Profile Search</h4><div class="profile-search-form">
        <form action="{DocumentRoot}/{ProductPath}/search/{Country}/{Keyword}" method="post">
            <table>
                <tbody>
                <tr>
                    <td><h5>I am a</h5></td>
                    <td>
                        <div class="select-field">
                            <span></span>
                            <select id="gender" name="gender" >
                                <option value="man" selected="selected">man</option>
                                <option value="woman" >woman</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><h5>Seeking a</h5></td>
                    <td>
                        <div class="select-field">
                            <span></span>
                            <select id="seeking" name="seeking" >
                                <option value="man" >man</option>
                                <option value="woman" selected="selected">woman</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><h5>Country</h5></td>
                    <td>
                        <div class="select-field">
                            <span></span>
                            <select id="country" name="country" class="countries-list" >
                                <option value="" selected="selected">Any Country</option>
                    </td>
                </tr>
                <tr>
                    <td><h5>City</h5></td>
                    <td>
                        <div class="select-field">
                            <span></span>
                            <select name="city" class="filterable-list" data-filter="countries-list" >
                                <option value="">Any City</option>
                                <option value="Ottawa" class="CA" >Ottawa</option>
                                <option value="Halifax" class="CA" >Halifax</option>
                                <option value="Vancouver" class="CA" >Vancouver</option>
                                <option value="Calgary" class="CA" >Calgary</option>
                                <option value="Toronto" class="CA" >Toronto</option>
                    </td>
                </tr>
                <tr>
                    <td><h5>From</h5></td>
                    <td>
                        <div class="select-field">
                            <span></span>
                            <select id="age_from" name="age_from" ><option value="18" selected="selected">18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option><option value="25" >25</option><option value="26" >26</option><option value="27" >27</option><option value="28" >28</option><option value="29" >29</option><option value="30" >30</option><option value="31" >31</option><option value="32" >32</option><option value="33" >33</option><option value="34" >34</option><option value="35" >35</option><option value="36" >36</option><option value="37" >37</option><option value="38" >38</option><option value="39" >39</option><option value="40" >40</option><option value="41" >41</option><option value="42" >42</option><option value="43" >43</option><option value="44" >44</option><option value="45" >45</option><option value="46" >46</option><option value="47" >47</option><option value="48" >48</option><option value="49" >49</option><option value="50" >50</option><option value="51" >51</option><option value="52" >52</option><option value="53" >53</option><option value="54" >54</option><option value="55" >55</option><option value="56" >56</option><option value="57" >57</option><option value="58" >58</option><option value="59" >59</option><option value="60" >60</option><option value="61" >61</option><option value="62" >62</option><option value="63" >63</option><option value="64" >64</option><option value="65" >65</option><option value="66" >66</option><option value="67" >67</option><option value="68" >68</option><option value="69" >69</option><option value="70" >70</option><option value="71" >71</option><option value="72" >72</option><option value="73" >73</option><option value="74" >74</option><option value="75" >75</option><option value="76" >76</option><option value="77" >77</option><option value="78" >78</option><option value="79" >79</option><option value="80" >80</option><option value="81" >81</option><option value="82" >82</option><option value="83" >83</option><option value="84" >84</option><option value="85" >85</option><option value="86" >86</option><option value="87" >87</option><option value="88" >88</option><option value="89" >89</option><option value="90" >90</option><option value="91" >91</option><option value="92" >92</option><option value="93" >93</option><option value="94" >94</option><option value="95" >95</option><option value="96" >96</option><option value="97" >97</option><option value="98" >98</option><option value="99" >99</option></select>						</div>
                    </td>
                </tr>
                <tr>
                    <td><h5>To</h5></td>
                    <td>
                        <div class="select-field">
                            <span></span>
                            <select id="age_to" name="age_to" ><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option><option value="25" >25</option><option value="26" >26</option><option value="27" >27</option><option value="28" >28</option><option value="29" >29</option><option value="30" >30</option><option value="31" >31</option><option value="32" >32</option><option value="33" >33</option><option value="34" >34</option><option value="35" selected="selected">35</option><option value="36" >36</option><option value="37" >37</option><option value="38" >38</option><option value="39" >39</option><option value="40" >40</option><option value="41" >41</option><option value="42" >42</option><option value="43" >43</option><option value="44" >44</option><option value="45" >45</option><option value="46" >46</option><option value="47" >47</option><option value="48" >48</option><option value="49" >49</option><option value="50" >50</option><option value="51" >51</option><option value="52" >52</option><option value="53" >53</option><option value="54" >54</option><option value="55" >55</option><option value="56" >56</option><option value="57" >57</option><option value="58" >58</option><option value="59" >59</option><option value="60" >60</option><option value="61" >61</option><option value="62" >62</option><option value="63" >63</option><option value="64" >64</option><option value="65" >65</option><option value="66" >66</option><option value="67" >67</option><option value="68" >68</option><option value="69" >69</option><option value="70" >70</option><option value="71" >71</option><option value="72" >72</option><option value="73" >73</option><option value="74" >74</option><option value="75" >75</option><option value="76" >76</option><option value="77" >77</option><option value="78" >78</option><option value="79" >79</option><option value="80" >80</option><option value="81" >81</option><option value="82" >82</option><option value="83" >83</option><option value="84" >84</option><option value="85" >85</option><option value="86" >86</option><option value="87" >87</option><option value="88" >88</option><option value="89" >89</option><option value="90" >90</option><option value="91" >91</option><option value="92" >92</option><option value="93" >93</option><option value="94" >94</option><option value="95" >95</option><option value="96" >96</option><option value="97" >97</option><option value="98" >98</option><option value="99" >99</option></select>						</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <a href="#" class="button medium submit-button"><span class="button-icon icon-search"></span>Find My Matches</a>
            <input type="hidden" name="s" value="" />
        </form>
    </div>
    </div>

    </aside>
</section>
<!-- /site content -->

<?php require_once(dirname(__FILE__) . "/inc_foot.php");?>
