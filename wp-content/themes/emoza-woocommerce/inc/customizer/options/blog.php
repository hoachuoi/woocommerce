<?php
/**
 * Blog Customizer options
 *
 * @package Emoza
 */

/**
 * Archives
 */
$wp_customize->add_section(
	'emoza_section_blog_archives',
	array(
		'title'       => esc_html__( 'Blog Archives', 'emoza-woocommerce'),
		'description' => esc_html__( 'Manage the overall design and functionality from the blog archive pages.', 'emoza-woocommerce' ),
		'priority'    => 165,
	)
);

$wp_customize->add_setting(
	'emoza_blog_archive_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control(
	new Emoza_Tab_Control (
		$wp_customize,
		'emoza_blog_archive_tabs',
		array(
			'label'   => '',
			'section' => 'emoza_section_blog_archives',
			'controls_general' => wp_json_encode( array( 
				'#customize-control-show_avatar',
				'#customize-control-archives_list_vertical_alignment',
				'#customize-control-archive_featured_image_size',
				'#customize-control-archive_list_image_placement',
				'#customize-control-archives_grid_columns',
				'#customize-control-blog_layout',
				'#customize-control-archive_hide_title',
				'#customize-control-sidebar_archives',
				'#customize-control-sidebar_archives_position',
				'#customize-control-archives_sidebar_display_conditions',
				'#customize-control-blog_divider_1',
				'#customize-control-archive_featured_image_title',
				'#customize-control-archive_featured_image_spacing',
				'#customize-control-blog_divider_2',
				'#customize-control-archive_text_title',
				'#customize-control-archive_text_align',
				'#customize-control-archive_title_spacing',
				'#customize-control-show_excerpt',
				'#customize-control-excerpt_length',
				'#customize-control-read_more_link',
				'#customize-control-read_more_spacing',
				'#customize-control-blog_divider_3',
				'#customize-control-archive_meta_title',
				'#customize-control-archive_meta_position',
				'#customize-control-archive_meta_elements',
				'#customize-control-archive_meta_spacing',
				'#customize-control-archive_meta_delimiter',
			) ),
			'controls_design'  => wp_json_encode( array(
				'#customize-control-loop_post_title_color',
				'#customize-control-loop_post_meta_color',
				'#customize-control-loop_post_text_color',
				'#customize-control-loop_post_title_title',
				'#customize-control-loop_post_title_font_style',
				'#customize-control-loop_post_title_adobe_font',
				'#customize-control-loop_post_title_font',
				'#customize-control-loop_post_title_size',
				'#customize-control-loop_post_title_text_style',
				'#customize-control-loop_post_meta_title',
				'#customize-control-loop_post_meta_size',
				'#customize-control-loop_post_excerpt_title',
				'#customize-control-loop_post_text_size',
			) ),
			'priority' => 10,
		)
	)
);

//Layout
$wp_customize->add_setting(
	'blog_layout',
	array(
		'default'           => 'layout3',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Emoza_Radio_Images(
		$wp_customize,
		'blog_layout',
		array(
			'label'    => esc_html__( 'Blog layout', 'emoza-woocommerce' ),
			'section'  => 'emoza_section_blog_archives',
			'cols'      => 2,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__( '1 column', 'emoza-woocommerce' ),
					'url'   => '%s/assets/img/bl1.svg',
				),
				'layout2' => array(
					'label' => esc_html__( '2 columns', 'emoza-woocommerce' ),
					'url'   => '%s/assets/img/bl2.svg',
				),      
				'layout3' => array(
					'label' => esc_html__( '2 columns', 'emoza-woocommerce' ),
					'url'   => '%s/assets/img/bl3.svg',
				),              
				'layout4' => array(
					'label' => esc_html__( '2 columns', 'emoza-woocommerce' ),
					'url'   => '%s/assets/img/bl4.svg',
				),
				'layout5' => array(
					'label' => esc_html__( '3 columns', 'emoza-woocommerce' ),
					'url'   => '%s/assets/img/bl5.svg',
				),  
				'layout6' => array(
					'label' => esc_html__( '3 columns', 'emoza-woocommerce' ),
					'url'   => '%s/assets/img/bl6.svg',
				),
			),
			'priority'  => 20,
		)
	)
); 

$wp_customize->add_setting(
	'archive_hide_title',
	array(
		'default'           => 0,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'archive_hide_title',
		array(
			'label'             => esc_html__( 'Hide Page Title', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'priority'          => 30,
		)
	)
);

$wp_customize->add_setting(
	'sidebar_archives',
	array(
		'default'           => '',
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'sidebar_archives',
		array(
			'label'             => esc_html__( 'Enable sidebar', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'priority'          => 31,
		)
	)
);

$wp_customize->add_setting( 'sidebar_archives_position',
	array(
		'default'           => 'sidebar-right',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'sidebar_archives_position',
	array(
		'label'     => esc_html__( 'Sidebar position', 'emoza-woocommerce' ),
		'section'   => 'emoza_section_blog_archives',
		'choices'   => array(
			'sidebar-left'      => esc_html__( 'Left', 'emoza-woocommerce' ),
			'sidebar-right'     => esc_html__( 'Right', 'emoza-woocommerce' ),
		),
		'active_callback'   => 'emoza_callback_sidebar_archives',
		'priority'          => 40,
	)
) );

$wp_customize->add_setting( 'archives_grid_columns',
	array(
		'default'           => '3',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'archives_grid_columns',
	array(
		'label'     => esc_html__( 'Columns', 'emoza-woocommerce' ),
		'section'   => 'emoza_section_blog_archives',
		'choices'   => array(
			'2'         => esc_html__( '2', 'emoza-woocommerce' ),
			'3'         => esc_html__( '3', 'emoza-woocommerce' ),
			'4'         => esc_html__( '4', 'emoza-woocommerce' ),
		),
		'active_callback'   => 'emoza_callback_grid_archives',
		'priority'          => 50,
	)
) );


$wp_customize->add_setting( 'blog_divider_1',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Emoza_Divider_Control( $wp_customize, 'blog_divider_1',
		array(
			'section'       => 'emoza_section_blog_archives',
			'priority'      => 60,
		)
	)
);

//Featured image
$wp_customize->add_setting( 'archive_featured_image_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Emoza_Text_Control( $wp_customize, 'archive_featured_image_title',
		array(
			'label'         => esc_html__( 'Featured image', 'emoza-woocommerce' ),
			'section'       => 'emoza_section_blog_archives',
			'priority'      => 70,
		)
	)
);

$wp_customize->add_setting( 'archive_list_image_placement',
	array(
		'default'           => 'left',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'archive_list_image_placement',
	array(
		'label'     => esc_html__( 'Image placement', 'emoza-woocommerce' ),
		'section'   => 'emoza_section_blog_archives',
		'choices'   => array(
			'left'      => esc_html__( 'Left', 'emoza-woocommerce' ),
			'right'     => esc_html__( 'Right', 'emoza-woocommerce' ),
		),
		'active_callback'   => 'emoza_callback_list_archives',
		'priority'  => 80,
	)
) );

$wp_customize->add_setting( 'archive_featured_image_size_desktop', array(
	'default'           => 30,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            

$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'archive_featured_image_size',
	array(
		'label'         => esc_html__( 'Image size', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'archive_featured_image_size_desktop',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'active_callback'   => 'emoza_callback_list_general_archives',
		'priority'      => 90,
	)
) );


$wp_customize->add_setting( 'archive_featured_image_spacing_desktop', array(
	'default'           => 16,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            

$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'archive_featured_image_spacing',
	array(
		'label'         => esc_html__( 'Spacing', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'archive_featured_image_spacing_desktop',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'priority'      => 100,
	)
) );

$wp_customize->add_setting( 'blog_divider_2',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Emoza_Divider_Control( $wp_customize, 'blog_divider_2',
		array(
			'section'       => 'emoza_section_blog_archives',
			'priority'      => 110,
		)
	)
);

$wp_customize->add_setting( 'archive_text_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Emoza_Text_Control( $wp_customize, 'archive_text_title',
		array(
			'label'         => esc_html__( 'Text', 'emoza-woocommerce' ),
			'section'       => 'emoza_section_blog_archives',
			'priority'      => 120,
		)
	)
);

$wp_customize->add_setting( 'archive_text_align',
	array(
		'default'           => 'center',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'archive_text_align',
	array(
		'label'   => esc_html__( 'Text alignment', 'emoza-woocommerce' ),
		'section' => 'emoza_section_blog_archives',
		'choices' => array(
			'left'      => '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
			'center'    => '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
			'right'     => '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
		),
		'priority' => 130,
	)
) );

$wp_customize->add_setting( 'archives_list_vertical_alignment',
	array(
		'default'           => 'middle',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'archives_list_vertical_alignment',
	array(
		'label'     => esc_html__( 'Vertical alignment', 'emoza-woocommerce' ),
		'section'   => 'emoza_section_blog_archives',
		'choices'   => array(
			'top'       => esc_html__( 'Top', 'emoza-woocommerce' ),
			'middle'    => esc_html__( 'Middle', 'emoza-woocommerce' ),
			'bottom'    => esc_html__( 'Bottom', 'emoza-woocommerce' ),
		),
		'active_callback'   => 'emoza_callback_list_general_archives',
		'priority'  => 140,
	)
) );

$wp_customize->add_setting( 'archive_title_spacing', array(
	'default'           => 16,
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );            

$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'archive_title_spacing',
	array(
		'label'         => esc_html__( 'Title spacing', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'archive_title_spacing',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'priority'      => 150,
	)
) );

$wp_customize->add_setting(
	'show_excerpt',
	array(
		'default'           => 1,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'show_excerpt',
		array(
			'label'             => esc_html__( 'Show excerpt', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'priority'          => 160,
		)
	)
);

$wp_customize->add_setting( 'excerpt_length', array(
	'default'           => 30,
	'sanitize_callback' => 'absint',
) );            

$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'excerpt_length',
	array(
		'label'         => esc_html__( 'Excerpt length', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'excerpt_length',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 120,
			'step'  => 1,
			'unit' => '',
		),
		'active_callback' => 'emoza_callback_excerpt',
		'priority'      => 170,
	)
) );

$wp_customize->add_setting(
	'read_more_link',
	array(
		'default'           => 0,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'read_more_link',
		array(
			'label'             => esc_html__( 'Read more link', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'active_callback'   => 'emoza_callback_excerpt',
			'priority'          => 180,
		)
	)
);


$wp_customize->add_setting( 'blog_divider_3',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Emoza_Divider_Control( $wp_customize, 'blog_divider_3',
		array(
			'section'       => 'emoza_section_blog_archives',
			'priority'      => 190,
		)
	)
);
//Meta
$wp_customize->add_setting( 'archive_meta_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control( new Emoza_Text_Control( $wp_customize, 'archive_meta_title',
		array(
			'label'         => esc_html__( 'Meta', 'emoza-woocommerce' ),
			'section'       => 'emoza_section_blog_archives',
			'priority'      => 200,
		)
	)
);

$wp_customize->add_setting( 'archive_meta_position',
	array(
		'default'           => 'above-title',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'archive_meta_position',
	array(
		'label'     => esc_html__( 'Position', 'emoza-woocommerce' ),
		'section'   => 'emoza_section_blog_archives',
		'choices'   => array(
			'above-title'       => esc_html__( 'Above title', 'emoza-woocommerce' ),
			'below-excerpt'     => esc_html__( 'Below excerpt', 'emoza-woocommerce' ),
		),
		'priority'  => 210,
	)
) );

$wp_customize->add_setting( 'archive_meta_elements', array(
	'default'           => array( 'post_date' ),
	'sanitize_callback' => 'emoza_sanitize_blog_meta_elements',
) );

$wp_customize->add_control( new \Kirki\Control\Sortable( $wp_customize, 'archive_meta_elements', array(
	'label'         => esc_html__( 'Meta elements', 'emoza-woocommerce' ),
	'section' => 'emoza_section_blog_archives',
	'choices' => array(
		'post_date'         => esc_html__( 'Post date', 'emoza-woocommerce' ),
		'post_author'       => esc_html__( 'Post author', 'emoza-woocommerce' ),
		'post_categories'   => esc_html__( 'Post categories', 'emoza-woocommerce' ),
		'post_comments'     => esc_html__( 'Post comments', 'emoza-woocommerce' ),
	),
	'priority'  => 220,
) ) );

$wp_customize->add_setting(
	'show_avatar',
	array(
		'default'           => '',
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'show_avatar',
		array(
			'label'             => esc_html__( 'Show author avatar', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'active_callback'   => 'emoza_callback_author_avatar',
			'priority'          => 230,
		)
	)
);


$wp_customize->add_setting( 'archive_meta_spacing', array(
	'default'           => 8,
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );            

$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'archive_meta_spacing',
	array(
		'label'         => esc_html__( 'Spacing', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'archive_meta_spacing',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'priority'      => 240,
	)
) );

$wp_customize->add_setting( 'archive_meta_delimiter',
	array(
		'default'           => 'none',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control( new Emoza_Radio_Buttons( $wp_customize, 'archive_meta_delimiter',
	array(
		'label'     => esc_html__( 'Delimiter style', 'emoza-woocommerce' ),
		'section'   => 'emoza_section_blog_archives',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'emoza-woocommerce' ),
			'dot'       => '&middot;',
			'vertical'  => '&#124;',
			'horizontal'=> '&#x23AF;',
		),
		'priority'  => 250,
	)
) );

/**
 * Styling
 */

// Colors

// Title Color
$wp_customize->add_setting(
	'loop_post_title_color',
	array(
		'default'           => '#212121',
		'sanitize_callback' => 'emoza_sanitize_hex_rgba',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Emoza_Alpha_Color(
		$wp_customize,
		'loop_post_title_color',
		array(
			'label'             => esc_html__( 'Title color', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'priority'          => 251,
		)
	)
);

// Meta Color
$wp_customize->add_setting(
	'loop_post_meta_color',
	array(
		'default'           => '#212121',
		'sanitize_callback' => 'emoza_sanitize_hex_rgba',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Emoza_Alpha_Color(
		$wp_customize,
		'loop_post_meta_color',
		array(
			'label'             => esc_html__( 'Meta color', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'priority'          => 251,
		)
	)
);

// Excerpt Color
$wp_customize->add_setting(
	'loop_post_text_color',
	array(
		'default'           => '#212121',
		'sanitize_callback' => 'emoza_sanitize_hex_rgba',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Emoza_Alpha_Color(
		$wp_customize,
		'loop_post_text_color',
		array(
			'label'             => esc_html__( 'Excerpt color', 'emoza-woocommerce' ),
			'section'           => 'emoza_section_blog_archives',
			'priority'          => 251,
		)
	)
);

// Title
$wp_customize->add_setting( 'loop_post_title_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control( new Emoza_Text_Control( $wp_customize, 'loop_post_title_title',
		array(
			'label'    => esc_html__( 'Title', 'emoza-woocommerce' ),
			'section'  => 'emoza_section_blog_archives',
			'priority' => 260,
		)
	)
);

// Typography
$wp_customize->add_setting( 
	'loop_post_title_font_style', 
	array(
		'default'           => 'heading',
		'sanitize_callback' => 'emoza_sanitize_select',
	) 
);
$wp_customize->add_control( 
	'loop_post_title_font_style', 
	array(
		'type'      => 'select',
		'section'   => 'emoza_section_blog_archives',
		'label'     => esc_html__( 'Font Style', 'emoza-woocommerce' ),
		'choices'   => array(
			'heading' => esc_html__( 'Heading', 'emoza-woocommerce' ),
			'body'    => esc_html__( 'Body', 'emoza-woocommerce' ),
			'custom'  => esc_html__( 'Custom', 'emoza-woocommerce' ),
		),
		'priority'  => 260,
	)
);

$wp_customize->add_setting( 'loop_post_title_adobe_font',
	array(
		'default'           => 'system-default|n4',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( new Emoza_Typography_Adobe_Control( $wp_customize, 'loop_post_title_adobe_font',
	array(
		'section'         => 'emoza_section_blog_archives',
		'active_callback' => 'emoza_loop_post_title_font_library_adobe_and_custom_style',
		'priority'        => 260,
	)
) );

$wp_customize->add_setting( 'loop_post_title_custom_font',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_setting( 'loop_post_title_custom_font_weight',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( new Emoza_Typography_Custom_Control( $wp_customize, 'loop_post_title_custom_font_typograhpy',
	array(
		'section'         => 'emoza_section_blog_archives',
		'settings'        => array(
			'font-family'   => 'loop_post_title_custom_font',
			'font-weight'   => 'loop_post_title_custom_font_weight',
		),
		'active_callback' => 'emoza_loop_post_title_font_library_custom_and_custom_style',
		'priority'        => 260,
	)
) );

$wp_customize->add_setting( 'loop_post_title_font',
	array(
		'default'           => '{"font":"System default","regularweight":"400","category":"sans-serif"}',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'emoza_google_fonts_sanitize',
		'priority'          => 260,
	)
);
$wp_customize->add_control( new Emoza_Typography_Control( $wp_customize, 'loop_post_title_font',
	array(
		'section'  => 'emoza_section_blog_archives',
		'settings' => array(
			'family' => 'loop_post_title_font',
		),
		'input_attrs' => array(
			'font_count'     => 'all',
			'orderby'        => 'alpha',
			'disableRegular' => false,
		),
		'active_callback' => 'emoza_loop_post_title_font_library_google_and_custom_style',
		'priority'  => 260,
	)
) );

// Font Size
$wp_customize->add_setting( 'loop_post_title_size_desktop', array(
	'default'           => 18,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            

$wp_customize->add_setting( 'loop_post_title_size_tablet', array(
	'default'           => 18,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'loop_post_title_size_mobile', array(
	'default'           => 18,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            
$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'loop_post_title_size',
	array(
		'label'         => esc_html__( 'Font Size', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 1,
		'settings'      => array(
			'size_desktop'      => 'loop_post_title_size_desktop',
			'size_tablet'       => 'loop_post_title_size_tablet',
			'size_mobile'       => 'loop_post_title_size_mobile',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 200,
		),
		'priority' => 260,
	)
) );

// Text Style
$wp_customize->add_setting( 
	'loop_post_title_text_decoration', 
	array(
		'default'           => 'none',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'emoza_sanitize_text',
	) 
);
$wp_customize->add_setting( 
	'loop_post_title_text_transform', 
	array(
		'default'           => 'none',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'emoza_sanitize_text',
	) 
);
$wp_customize->add_control( 
	new Emoza_Text_Style_Control( 
		$wp_customize, 
		'loop_post_title_text_style',
		array(
			'section'  => 'emoza_section_blog_archives',
			'settings' => array(
			'decoration' => 'loop_post_title_text_decoration',
			'transform'  => 'loop_post_title_text_transform',
			),
				'priority' => 260,
		)
	)
);

$wp_customize->add_setting( 'loop_post_meta_size_desktop', array(
	'default'           => 14,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            

$wp_customize->add_setting( 'loop_post_meta_size_tablet', array(
	'default'           => 14,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_setting( 'loop_post_meta_size_mobile', array(
	'default'           => 14,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            

// Title
$wp_customize->add_setting( 'loop_post_meta_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control( new Emoza_Text_Control( $wp_customize, 'loop_post_meta_title',
		array(
			'label'    => esc_html__( 'Meta', 'emoza-woocommerce' ),
			'section'  => 'emoza_section_blog_archives',
			'priority' => 290,
		)
	)
);

// Font Size
$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'loop_post_meta_size',
	array(
		'label'         => esc_html__( 'Font Size', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 1,
		'settings'      => array(
			'size_desktop'      => 'loop_post_meta_size_desktop',
			'size_tablet'       => 'loop_post_meta_size_tablet',
			'size_mobile'       => 'loop_post_meta_size_mobile',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 200,
		),
		'priority'      => 290,
	)
) );

// Title
$wp_customize->add_setting( 'loop_post_excerpt_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control( new Emoza_Text_Control( $wp_customize, 'loop_post_excerpt_title',
		array(
			'label'    => esc_html__( 'Excerpt Title', 'emoza-woocommerce' ),
			'section'  => 'emoza_section_blog_archives',
			'priority' => 320,
		)
	)
);

// Font size
$wp_customize->add_setting( 'loop_post_text_size_desktop', array(
	'default'           => 16,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            
$wp_customize->add_setting( 'loop_post_text_size_tablet', array(
	'default'           => 16,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'loop_post_text_size_mobile', array(
	'default'           => 16,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
) );            
$wp_customize->add_control( new Emoza_Responsive_Slider( $wp_customize, 'loop_post_text_size',
	array(
		'label'         => esc_html__( 'Font Size', 'emoza-woocommerce' ),
		'section'       => 'emoza_section_blog_archives',
		'is_responsive' => 1,
		'settings'      => array(
			'size_desktop'      => 'loop_post_text_size_desktop',
			'size_tablet'       => 'loop_post_text_size_tablet',
			'size_mobile'       => 'loop_post_text_size_mobile',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 200,
		),
		'priority'      => 320,
	)
) );