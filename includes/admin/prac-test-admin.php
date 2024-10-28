<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package Practical Test
 * @since 1.0.0
 */

class Prac_Test_Admin {

	public $scripts;

	//class constructor
	function __construct() {

		global $prac_test_scripts;

		$this->scripts = $prac_test_scripts;
	}

	/**
	 * Admin Class
	 *
	 * Custom method to handle creating meta box for storing address.
	 *
	 * @package Practical Test
	 * @since 1.0.0
	*/

	function prac_test_post_metaboxes() {
		add_meta_box('prac_test_meta_box', 'Address:', array($this, 'prac_test_location_metabox'), 'post', 'side', 'default');
	}


    /**
	 * Admin Class
	 *
	 * Custom method to handle callback method for associated meta-fields.
	 *
	 * @package Practical Test
	 * @since 1.0.0
	*/

    function prac_test_location_metabox( $post ) {
        $saved_address = get_post_meta($post->ID, '_prac_test_address', true);
        ?>
        <label for="prac_test_address"><?php echo esc_html__('Address:', 'practest'); ?></label>
        <input type="text" name="prac_test_address" id="prac_test_address" value="<?php echo esc_attr( $saved_address ); ?>" />
        <?php
    }

    /**
	 * Admin Class
	 *
	 * Custom method to handle saving meta values of back-end fields ( address , lat and long  )
	 *
	 * @package Practical Test
	 * @since 1.0.0
	*/

    function prac_test_save_address_details( $post_id ) {
            if ( isset( $_POST['prac_test_address'] ) ) {
               update_post_meta($post_id, '_prac_test_address', sanitize_text_field( $_POST['prac_test_address'] ));
               $saved_address = sanitize_text_field($_POST['prac_test_address']);
               /**
                * method to call api for fetching lat and long based on address
               */
               $location_details = $this->prac_test_lat_lng_from_address( $saved_address );
               $stored_lat = get_post_meta( $post_id , '_prac_test_latitude' , true );
               $stored_lng = get_post_meta( $post_id , '_prac_test_longitude' , true );
               if ( !empty( $location_details ) && is_array( $location_details ) && empty( $stored_lat ) && empty( $stored_lng ) ) {
                  update_post_meta($post_id, '_prac_test_latitude', $location_details['latitude']);
                  update_post_meta($post_id, '_prac_test_longitude', $location_details['longitude']);
               }  
            }    
    }

    /**
	 * Admin Class
	 *
	 * Custom method to get Lat and Lng from api ( Kindly note LocationIq is ude )
	 *
	 * @package Practical Test
	 * @since 1.0.0
	*/

    function prac_test_lat_lng_from_address ( $address ) {
        
        $api_key = LOCATION_IQ_TOKEN; // replace with your actual API key
        $url = LOCATION_IQ_ENDPOINT.'?key='.$api_key.'&q='.urlencode($address).'&format=json';
    
        $response = wp_remote_get($url);
        if ( is_wp_error($response) ) {
            return false;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);    
        if (!empty($data) && isset($data[0]->lat, $data[0]->lon)) {
            return array(
                'latitude' => $data[0]->lat,
                'longitude' => $data[0]->lon,
            );
        }
        return false;
    }

	/**
	 * Adding Hooks 
	 *
	 * @package Practical Test
	 * @since 1.0.0
	 */
	function add_hooks(){
		add_action('add_meta_boxes', array($this,'prac_test_post_metaboxes'));
        add_action('save_post', array($this,'prac_test_save_address_details'));
	}
}
