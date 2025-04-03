<?php
/**
 * Repeater control
 *
 * @package Emoza
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Emoza_Tab_Control extends WP_Customize_Control {
		
	/**
	 * The type of control being rendered
	 */
	public $type = 'emoza-tab-control';

	public $controls_general;

	public $controls_design;

	
	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
	?>

	<div class="control-tabs">
		<div class="control-tab control-tab-general active" data-connected="<?php echo esc_attr( $this->controls_general ); ?>"><?php echo esc_html__( 'General', 'emoza-woocommerce' ); ?></div>
		<div class="control-tab control-tab-design" data-connected="<?php echo esc_attr( $this->controls_design ); ?>"><?php echo esc_html__( 'Style', 'emoza-woocommerce' ); ?></div>
	</div>
	<?php
	}
}
