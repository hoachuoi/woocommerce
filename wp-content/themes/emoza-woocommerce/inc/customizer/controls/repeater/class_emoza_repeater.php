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

class Emoza_Repeater_Control extends WP_Customize_Control {
		
	/**
	 * The type of control being rendered
	 */
	public $type = 'emoza-sortable_repeater';

	/**
	 * Button labels
	 */
	public $button_labels = array();

	/**
	 * Regular field
	 */
	public $regular_field = false;

	/**
	 * Constructor
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		parent::__construct( $manager, $id, $args );
		// Merge the passed button labels with our default labels
		$this->button_labels = wp_parse_args( $this->button_labels,
			array(
				'add' => esc_html__( 'Add', 'emoza-woocommerce' ),
			)
		);
	}

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
	?>
		<div class="emoza-sortable_repeater_control">
			<?php if( !empty( $this->label ) ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>
			<?php if( !empty( $this->description ) ) { ?>
				<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php } ?>
			<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-repeater" <?php $this->link(); ?> />
			<div class="emoza-sortable_repeater sortable<?php echo ( $this->regular_field ? ' regular-field' : '' ); ?>">
				<div class="repeater">
					<input type="text" value="" class="repeater-input"/><span class="dashicons dashicons-menu"></span><a class="customize-control-sortable-repeater-delete" href="#"><span class="dashicons dashicons-no-alt"></span></a>
				</div>
			</div>
			<button class="button customize-control-sortable-repeater-add" type="button"><?php echo esc_html( $this->button_labels['add'] ); ?></button>
		</div>

	<?php
	}
}
