<?php require_once(dirname(__FILE__) . "/inc_head.php"); ?>



<div style="width:100%; margin:10px auto;">
    <form method="post" action="/admin/download" id="searchform" class="form">

        <div class="field">
            <label>Start Date</label>
            <input type="date" name="start"/>
        </div>
        <div class="field">
            <label>End Date</label>
            <input type="date" name="end"/>
        </div>
        <div class="field">
            <label>Report Type</label>
            <select name="type" id="type">
                <option value="detail">Site Visitor Detailed Report</option>
                <option value="total">Site Visitor Total Report</option>
            </select>
        </div>
        <div id="foo" style="display:none;">
            <div class="field">
                <label>Product</label>
                <input type="text" name="product"/>
                <small>(i.e.landingpage1 or landingpage2)</small>
            </div>
            <div class="field">
                <label>Keyword</label>
                <input type="text" name="keyword"/>
                <small>Keyword for the page</small>
            </div>
            <div class="field">
                <label>Country Code</label>
                <input type="text" name="code"/>
                <small>Country code for the page URL.(i.e. the highlighted wording is the country code for the URL http://www.abc.com/landingpage1/index/<span style="font-weight: bold; color: red;">ca1</span>/real)</small>
            </div>
        </div>
        <div class="field">
            <label></label>
            <button class="btn btn-large">Submit</button>
        </div>
    </form>
</div>

<?php require_once(dirname(__FILE__) . "/inc_foot.php"); ?>