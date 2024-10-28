<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcodes Class
 *
 * Shortcode Class
 *
 * @package Practical Test
 * @since 1.0.0
 */

class Practical_Test_Shortcodes {

	public $scripts;
	//class constructor
	function __construct() {

		global $prac_test_scripts;
		$this->scripts = $prac_test_scripts;
	}

	/**
	 * Shortcode displaying indivisual details of every country
	 *
	 * @package Practical Test
	 * @since 1.0.0
	*/	

	function prac_test_display_maps() {
		ob_start();
		?>
            <div id="maps" style="height: 500px; width: 100%;"></div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Adding Hooks
	 *
	 * @package Practical Test
	 * @since 1.0.0
	 */
	function add_hooks(){
		add_shortcode('display_map',array($this,'prac_test_display_maps'));	
	}
}
?>