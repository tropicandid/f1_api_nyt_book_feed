<?php
/**
*
* Custom F1 API Feed block
*
**/



$GLOBALS['custom_dash_options_page'] = admin_url('options-general.php?page=f1-api-feed');
?>

<style>
    .f1_api_feed h2 {
        font-size: 24px;
    }
    .f1_api_feed p {
        font-size: 14px;
    }
    .f1_api_feed input[type=input],
    .f1_api_feed input[type=number] {
        height: 2.5rem;
        font-size: 18px;
        width: 70%;
        margin-bottom: 1.5rem;
    }
    .f1_api_feed label {
        display: block;
        font-size: 16=4px;
    }
</style>


<?php 
    if( isset($_POST['f1_api_feed_info'])) {
        update_option( 'f1_api_feed_settings',$_POST['f1_api_feed_info'] );
        update_option( 'f1_api_feed_settings_title',$_POST['f1_api_feed_title'] );
        update_option( 'f1_api_feed_settings_author',$_POST['f1_api_feed_author'] );
        update_option( 'f1_api_feed_settings_contributor',$_POST['f1_api_feed_contributor'] );
        update_option( 'f1_api_feed_settings_publisher',$_POST['f1_api_feed_publisher'] );
        update_option( 'f1_api_feed_settings_price',$_POST['f1_api_feed_price'] );
        update_option( 'f1_api_feed_settings_records',$_POST['f1_api_feed_records'] );
    }
?>
<div class="f1_api_feed">
    <h2>
        <?php 
            _e('F1 API Feed Settings','f1-api-feed'); 
        ?>    
    </h2>
    <p>Edit the settings below to configure preferences for the New York Times History Best Sellers feed. By default, the feed will pull the 4 most recent best sellers from the list. </p> 

    <p>You can curate your feed by adding in more specific criteria. All optional fields permit partial matches. For exmaple, if you enter in "Step" for the Author, the feed will look for entries with authors containing those letters in any format in the author's first or last names. "Stephen, Stephanie, etc."</p>

    <p>Additionally, you can edit the API URL directly, but for convenience, the optional fields have been provided to construct these additions for you. You can find complete details of the additional fields <a href="https://any-api.com/nytimes_com/books_api/docs/_lists_best_sellers_history_json/GET_lists_best_sellers_history_json" target="_blank">here</a></p>

    <form action="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=f1-api-feed" method="post">

        <label>API URL</label>
        <input type="input" id="api_url" name="f1_api_feed_info" value="<?php echo get_option('f1_api_feed_settings'); ?>" placeholder="Example: https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json" required>

        <label>Title (optional)</label>
        <input type="input" id="api_title" name="f1_api_feed_title" value="<?php echo get_option('f1_api_feed_settings_title'); ?>" placeholder="">

        <label>Author (optional)</label>
        <input type="input" id="api_author" name="f1_api_feed_author" value="<?php echo get_option('f1_api_feed_settings_author'); ?>" placeholder="">

        <label>Contributor (optional)</label>
        <input type="input" id="api_contributor" name="f1_api_feed_contributor" value="<?php echo get_option('f1_api_feed_settings_contributor'); ?>" placeholder="">

        <label>Publisher (optional)</label>
        <input type="input" id="api_publisher" name="f1_api_feed_publisher" value="<?php echo get_option('f1_api_feed_settings_publisher'); ?>" placeholder="">

        <label>Price (optional)</label>
        <input type="input" id="api_price" name="f1_api_feed_price" value="<?php echo get_option('f1_api_feed_settings_price'); ?>" placeholder="">

        <label>Number of records to display (optional)</label>
        <input type="number" id="api_records" name="f1_api_feed_records" value="<?php echo get_option('f1_api_feed_settings_records'); ?>" >

        <p class="submit">
            <input name="update_options" class="button-primary" value="<?php _e('Update Settings','f1-api-feed'); ?>" type="submit" />
        </p>

    </form>

</div>

<?php
