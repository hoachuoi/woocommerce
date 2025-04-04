<?php
class Emoza_Typography_Control extends WP_Customize_Control {
	/**
	 * The type of control being rendered
	 */
	public $type = 'emoza-google_fonts';
	/**
	 * The list of Google Fonts
	 */
	private $fontList = false;
	/**
	 * The saved font values decoded from json
	 */
	private $fontValues = array();
	/**
	 * The index of the saved font within the list of Google fonts
	 */
	private $fontListIndex = 0;
	/**
	 * The number of fonts to display from the json file. Either positive integer or 'all'. Default = 'all'
	 */
	private $fontCount = 'all';
	/**
	 * The font list sort order. Either 'alpha' or 'popular'. Default = 'alpha'
	 */
	private $fontOrderBy = 'alpha';
	/**
	 * Get our list of fonts from the json file
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		parent::__construct( $manager, $id, $args );
		// Get the font sort order
		if ( isset( $this->input_attrs['orderby'] ) && strtolower( $this->input_attrs['orderby'] ) === 'popular' ) {
			$this->fontOrderBy = 'popular';
		}
		// Get the list of Google fonts
		if ( isset( $this->input_attrs['font_count'] ) ) {
			if ( 'all' !== strtolower( $this->input_attrs['font_count'] ) ) {
				$this->fontCount = ( abs( (int) $this->input_attrs['font_count'] ) > 0 ? abs( (int) $this->input_attrs['font_count'] ) : 'all' );
			}
		}
		$this->fontList = $this->get_google_fonts( 'all' );
		// Decode the default json font value
		$this->fontValues = json_decode( $this->value( 'family' ) );
		// Find the index of our default font within our list of Google fonts
		$this->fontListIndex = $this->get_font_index( $this->fontList, $this->fontValues->font );
	}
	/**
	 * Enqueue our scripts and styles
	 */
	public function enqueue() {
		wp_enqueue_script( 'emoza-select2', get_template_directory_uri() . '/assets/vendor/select2/select2.full.min.js', array( 'jquery' ), '4.0.13', true );
		wp_enqueue_style( 'emoza-select2', get_template_directory_uri() . '/assets/vendor/select2/select2.min.css', array(), '4.0.13', 'all' );
	}
	/**
	 * Export our List of Google Fonts to JavaScript
	 */
	public function to_json() {
		parent::to_json();
		$this->json['emozafontslist'] = $this->fontList;
	}
	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
		$fontCounter = 0;
		$isFontInList = false;
		$fontListStr = '';

		if( !empty($this->fontList) && $this->fontList !== 'error' ) {
			?>
			<?php if( !empty( $this->label ) ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>	
			<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>							
			<div class="google_fonts_select_control popover-block">
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value( 'family' ) ); ?>" class="customize-control-google-font-selection" <?php $this->link( 'family' ); ?> />
				<div class="google-fonts">
					<div class="customize-control-title"><?php esc_html_e( 'Font family', 'emoza-woocommerce' ) ?></div>
					<select class="google-fonts-list" control-name="<?php echo esc_attr( $this->id ); ?>">
						<?php
							foreach( $this->fontList as $key => $value ) {
								++$fontCounter;
								$fontListStr .= '<option value="' . $value->family . '" ' . selected( $this->fontValues->font, $value->family, false ) . '>' . $value->family . '</option>';
								if ( $this->fontValues->font === $value->family ) {
									$isFontInList = true;
								}
								if ( is_int( $this->fontCount ) && $fontCounter === $this->fontCount ) {
									break;
								}
							}
							if ( !$isFontInList && $this->fontListIndex ) {
								// If the default or saved font value isn't in the list of displayed fonts, add it to the top of the list as the default font
								$fontListStr = '<option value="' . $this->fontList[$this->fontListIndex]->family . '" ' . selected( $this->fontValues->font, $this->fontList[$this->fontListIndex]->family, false ) . '>' . $this->fontList[$this->fontListIndex]->family . ' (default)</option>' . $fontListStr;
							}
							// Display our list of font options
							echo $fontListStr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</select>
				</div>

				<div class="range-slider-wrapper cols2-control">
				<div class="customize-control-title"><?php esc_html_e( 'Font weight', 'emoza-woocommerce' ) ?></div>
				<?php if ( $this->input_attrs['disableRegular'] == false ) : ?>
					<select class="google-fonts-regularweight-style w50">
						<?php
							foreach( $this->fontList[$this->fontListIndex]->variants as $key => $value ) {
								echo '<option value="' . esc_attr( $value ) . '" ' . selected( $this->fontValues->regularweight, $value, false ) . '>' . esc_html( $value ) . '</option>';
							}
						?>
					</select>
				<?php endif; ?>
				</div>				

				<input type="hidden" class="google-fonts-category" value="<?php echo esc_html( $this->fontValues->category ); ?>">
			</div>
			<?php
		} elseif( $this->fontList == 'error' ) {
			$error_message = sprintf(
				/* translators: 1: How to use adobe fonts docs link */
				__( '<p class="emoza-customize-error">Something went wrong and the Google Fonts couldn\'t be loaded. Please contact our support <a href="%s" target="_blank">here</a> to get help.', 'emoza-woocommerce' ),
				'https://emoza.org/support/'
			);

			if( defined( 'EMOZA_WL_ACTIVE' ) ) {
				$error_message = __( '<p class="emoza-customize-error">Something went wrong and the Google Fonts couldn\'t be loaded.', 'emoza-woocommerce' );
			}

			echo wp_kses_post( $error_message );
		}
	}

	/**
	 * Find the index of the saved font in our multidimensional array of Google Fonts
	 */
	public function get_font_index( $haystack, $needle ) {
		if( 'error' === $haystack ) {
			return false;
		}

		foreach( $haystack as $key => $value ) {
			if( $value->family == $needle ) {
				return $key;
			}
		}

		return false;
	}

	/**
	 * Return the list of Google Fonts from our json file. Unless otherwise specfied, list will be limited to 30 fonts.
	 */
	public function get_google_fonts( $count = 30 ) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

		$fontFile       = get_parent_theme_file_path( '/inc/customizer/controls/typography/google-fonts-alphabetical.json' );
		$file_system    = new WP_Filesystem_Direct( false );
		$content        = json_decode( $file_system->get_contents( $fontFile ) );

		return $content->items;
	}
}
