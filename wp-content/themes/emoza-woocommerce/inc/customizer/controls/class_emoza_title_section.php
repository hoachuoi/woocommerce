<?php
/**
 * Title section
 *
 * @package Emoza
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Emoza_Title_Section extends WP_Customize_Section {
		
	/**
	 * The type of control being rendered
	 */
	public $type = 'emoza-title-section';

	public $divider = false;

	/**
	 * Render the control in the customizer
	 */
	public function render() {
		?>
		<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="accordion-section emoza-title-section">
			<?php if ( ! empty( $this->divider ) ) { ?>
				<hr />
			<?php } ?>
			<?php if ( ! empty( $this->title ) ) { ?>
				<h3><?php echo esc_html( $this->title ); ?></h3>
			<?php } ?>
			<?php if ( ! empty( $this->description ) ) { ?>
				<span class="description"><?php echo esc_html( $this->description ); ?></span>
			<?php } ?>
		</li>
		<?php
	}
}
