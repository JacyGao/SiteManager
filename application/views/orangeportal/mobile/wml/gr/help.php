<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>



<div class="page-content">

    <div class="content-panel">

        <div class="two_third" id="comments">

            <div id="respond">

                <h3 id="reply-title">Contact Us</h3>

                <form action="#" method="post" id="commentform">

                    <div class="comment-form-author">

                        <div class="label">

                            <label for="author">Name</label> <span class="required">(required)</span>

                        </div>

                        <div class="input-wrapper">

                            <div class="shadow">

                                <div class="icon">

                                    <input id="author" name="author" type="text" value="">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="comment-form-email">

                        <div class="label">

                            <label for="email">Email</label> <span class="required">(required)</span>

                        </div>

                        <div class="input-wrapper">

                            <div class="shadow">

                                <div class="icon">

                                    <input id="email" name="email" type="text" value="">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="comment-form-mobile">

                        <div class="label">

                            <label for="mobile">Mobile</label> <span class="required">(required)</span>

                        </div>

                        <div class="input-wrapper">

                            <div class="shadow">

                                <div class="icon">

                                    <input id="mobile" name="mobile" type="text" value="{Placeholder}">

                                </div>

                            </div>

                        </div>

                    </div>

                    <br class="clearer">

                    <div class="comment-form-comment">

                        <div class="label">

                            <label for="comment">Comment</label>

                        </div>

                        <div class="input-wrapper">

                            <div class="shadow">

                                <div class="icon">

                                    <textarea id="comment" name="comment" aria-required="true"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    <br class="clearer">

                    <input name="submit" type="submit" id="submit" value="Post Comment" style="opacity: 1;">

                </form>

            </div>

        </div>

        <div class="one_third last">
            <h6>For more information, please contact</h6>
            <p>{Contact_us_Text}</p>

            <div class="contact_bottom"></div>
        </div>

    </div>

</div>


<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>