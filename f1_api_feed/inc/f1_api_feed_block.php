<?php
/**
*
* Custom F1 API Feed block
*
**/

/**
 * Handler for [f1_feed_block] shortcode
 *
 * @param $atts
 *
 * @return string
 */
function f1_api_feed_shortcode_handler($atts)
{
	return f1_api_feed();
}
/**
 * Register Shortcode
 */
add_shortcode('f1_feed_block', 'f1_api_feed_shortcode_handler');


/**
 * Associate Base Styles
 */
function f1_api_feed_styles() {   
    wp_enqueue_style( 'f1_api_styles', plugin_dir_url( __FILE__ ) . 'style.css' );
}
add_action('wp_enqueue_scripts', 'f1_api_feed_styles');


/**
 * Handler for feed block
 * @param $atts
 *
 * @return string
 */
function f1_api_feed_block_handler($atts)
{
	return f1_api_feed();
}

function f1_api_feed()
{
	
	$records 		= get_option('f1_api_feed_settings_records')!= null ? get_option('f1_api_feed_settings_records') :4;
    $title 			= get_option('f1_api_feed_settings_title')!= null ? '&title='.preg_replace('/\s+/', '_', get_option('f1_api_feed_settings_title') ):'';
    $author 		= get_option('f1_api_feed_settings_author')!= null ? '&author='.preg_replace('/\s+/', '_', get_option('f1_api_feed_settings_author') ):'';
    $contributor 	= get_option('f1_api_feed_settings_contributor')!= null ? '&contributor='.preg_replace('/\s+/', '_', get_option('f1_api_feed_settings_contributor') ) :'';
    $publisher 		= get_option('f1_api_feed_settings_publisher')!= null ? '&publisher='.preg_replace('/\s+/', '_', get_option('f1_api_feed_settings_publisher') ):'';
    $price 			= get_option('f1_api_feed_settings_price')!= null ? '&price='.get_option('f1_api_feed_settings_price') :'';
	$option_setting = get_option('f1_api_feed_settings') .'?api-key='. get_option('f1_api_feed_key').$author.$title.$contributor.$publisher.$price;

	$response 		= wp_remote_get( $option_setting );
 
	if ( is_array( $response ) && ! is_wp_error( $response ) ) {

	    $body  = wp_remote_retrieve_body( $response  );
	    $data  = json_decode( $body, true );
	    $block = "";
	    
	    if( ! empty( $data ) && !empty( $data['results'] ) ) {

	    	$block = $block . '<div class="f1-api-feed__wrapper">';

	    	foreach ( $data['results'] as $key => $value ) {

	    		if( $key >= $records ) {
	    			break;
	    		}

	    		$title 			= '<h2>'.$value['title'].'</h2>';
	    		$author 		= '<p><strong>Contributors:</strong> '.$value['contributor'].'</p>';
	    		$description 	= '<p><strong>Summary:</strong>'.$value['description'].'</p>';
	    		$publisher 		= '<p><strong>Publisher:</strong>'.$value['publisher'].'</p>';
	    		$price 			= $value['price'] > 0 ? '<p><strong>Price:</strong> $'.$value['price'].'</p>': '<p><strong>Price:</strong> Not Listed </p>';

	    		$block = $block . '<div class="f1-api-feed__block">'.$title.$author.$publisher.$description.$price.'</div>';
	    	}
	    	$block = $block .  '</div>';
		} else {
			return '<div class"f1-api-feed__error">It appears no results were found for the F1 API Feed. Please verify your API URL is correct.</div>';
		}

		return $block;

	} else {
		return '<div class"f1-api-feed__error">It appears no results were found for the F1 API Feed. Please verify your API URL is correct.</div>';
	}
}


/**
 * Register block
 */
function f1_api_feed_block() {

	wp_register_script(
		'f1-api-feed-script',
		plugins_url('index.js', __FILE__),
		array(
			'wp-editor',
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-components'
		)
	);

	register_block_type( 'f1-api-feed-blocks/f1-api-feed', array(
		'editor_script' => 'f1-api-feed-script',
		'render_callback' => 'f1_api_feed_block_handler',
	));

}

add_action( 'init', 'f1_api_feed_block' );

