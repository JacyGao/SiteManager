<?php require_once(dirname(__FILE__) . "/inc_head.php");?>

<!-- /header -->
<div class="header-content-wrap">
    <div class="header-content container">
        <h1 class="page-title">Memberships  </h1>
    </div>
</div>

<!-- /content -->
</div>
		<div class="content-wrap">
            <section class="site-content container clearfix">
                <aside class="column threecol">

                    <!-- Profile Photo section -->
                    <div class="profile-preview">
                        <div class="profile-image">
                            <img src="{DocumentRoot}/css/{ProductPath}/images/image-114-200x200.png" class="avatar" width="200" alt="" />
                        </div>
                        <div class="profile-options clearfix">
                            <form class="upload-form" enctype="multipart/form-data" method="POST">
                                <label for="user_avatar" class="button small">Change Photo</label>
                                <input type="file" id="user_avatar" name="user_avatar" class="shifted" />
                                <input type="hidden" name="user_action" value="update_avatar" />
                                <input type="hidden" name="nonce" value="22b82f3fc5" />
                            </form>
                        </div>
                    </div>

                    <div class="widget profile-menu">
                        <ul>
                            <li class="current"><a href="{DocumentRoot}/{ProductPath}/member/{Country}/{Keyword}">My Membership</a></li>
                            <li ><a href="{DocumentRoot}/{ProductPath}/edit/{Country}/{Keyword}">Edit Profile</a></li>
                        </ul>
                    </div>

                </aside>

                <div class="full-profile eightcol column">
                    <div class="section-title">
                        <h2>My Membership</h2>
                    </div>
                    <table class="profile-fields">
                        <tbody>
                        <tr>
                            <th>Membership</th>
                            <td>Active</td>
                        </tr>
                        <tr>
                            <th>Member Since</th>
                            <td>29/11/2013</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>jacy</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>abcde@gmail.com</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>674098888076</td>
                        </tr>
                        </tbody>
                    </table>
                </div>


            </section>
        </div>

<?php require_once(dirname(__FILE__) . "/inc_foot.php");?>