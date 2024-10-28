<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package Practical Test
 * @since 1.0.0
 */

class Practical_Test_Scripts {

	//class constructor
	function __construct()
	{
		
	}
	
	/**
	 * Enqueue Scripts on Admin Side
	 * 
	 * @package Practical Test
	 * @since 1.0.0
	 */
	public function practical_test_admin_scripts(){
	
	}

	/**
	 * Enqueue Scripts on Front-side Side
	 * 
	 * @package Practical Test
	 * @since 1.0.0
	*/
	
	 public function practical_test_front_scripts() {

		wp_enqueue_style('leaflet-css', PRACT_TEST_INC_URL . '/css/leaflet-style.css', array(), '1.0.0');
		wp_register_script('leaflet-js', PRACT_TEST_INC_URL . '/js/leaflet-script.js',array('jquery'),'1.0',true);
        wp_enqueue_script('leaflet-js');
        wp_register_script('custom-map', PRACT_TEST_INC_URL . '/js/custom-map.js', array('leaflet-js'), '1.0', true);
        $maps_data = $this->prac_test_fetch_posts_with_lat_lng();
        wp_localize_script('custom-map', 'MapsData', array(
            'markers' =>  $maps_data,
        ));
        wp_enqueue_script('custom-map');
	 }


    /**
	 * Custom method to call fetch posts associated with Address
	 * 
	 * @package Practical Test
	 * @since 1.0.0
	*/

    function prac_test_fetch_posts_with_lat_lng() {

        $args = array(
            'post_type'      => 'post',  
            'post_status'    => 'publish',
            'posts_per_page' => -1,       
            'meta_query'     => array(
                'relation' => 'AND',    
                array(
                    'key'     => '_prac_test_latitude',
                    'value'   => '',      
                    'compare' => '!=',    
                ),
                array(
                    'key'     => '_prac_test_longitude',
                    'value'   => '',     
                    'compare' => '!=',
                ),
            ),
        );
        $posts = get_posts($args);
        $map_data = array();
        foreach ($posts as $post) {
            $location_lat = get_post_meta($post->ID, '_prac_test_latitude', true);
            $location_lng = get_post_meta($post->ID, '_prac_test_longitude', true);
            if ( !empty( $location_lat ) && !empty( $location_lng ) ) {
                $map_data[] = array(
                    'title'     => get_the_title($post->ID),
                    'permalink' => get_permalink($post->ID),
                    'lat'       => $location_lat,
                    'lng'       => $location_lng,
                );
            }
        }

        return $map_data;
    }


	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the styles and scripts.
	 *
	 * @package Practical Test
	 * @since 1.0.0
	 */	
	function add_hooks(){
		
		//add admin scripts
		add_action('admin_enqueue_scripts', array($this, 'practical_test_admin_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'practical_test_front_scripts'));
	}
}
?>