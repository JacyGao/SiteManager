<?php require_once( dirname(__FILE__) ."/inc_head.php"); ?>

    <header id="homepage" class="nav-link">

        <!-- background overlay -->
        <span class="mask-overlay"></span>

        <div class="container">
            <div class="row">

                <!-- homepage intro -->
                <section class="intro col-lg-12">

                    <h2>Sorry</h2>
                    <h2>{ErrorMessage}</h2>
                    <br />
                    <a href="javascript:history.go(-1);"><h3>Click here to return to previous page.</h3></a>

                </section> <!-- end homepage intro -->
            </div>
        </div>
    </header> <!-- end header - homepage -->

<?php require_once( dirname(__FILE__) ."/inc_foot.php"); ?>