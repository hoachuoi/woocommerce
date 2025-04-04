<?php

/**
 * Blog Customizer options
 *
 * @package Emoza
 */

/**
 * Single posts
 */
$wp_customize->add_section(
	'emoza_section_blog_singles',
	array(
		'title'       => esc_html__('Single Posts', 'emoza-woocommerce'),
		'description' => esc_html__( 'Manage the overall design and functionality from the blog single posts.', 'emoza-woocommerce' ),
		'priority'    => 170,
	)
);

$wp_customize->add_setting(
	'emoza_blog_single_tabs',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control(
	new Emoza_Tab_Control(
		$wp_customize,
		'emoza_blog_single_tabs',
		array(
			'label'   => '',
			'section' => 'emoza_section_blog_singles',
			'controls_general' => wp_json_encode(array(
				'#customize-control-blog_single_layout',
				'#customize-control-sidebar_single_post',
				'#customize-control-sidebar_single_post_position',
				'#customize-control-blog_single_divider_1',
				'#customize-control-single_post_header_title',
				'#customize-control-single_post_header_alignment',
				'#customize-control-single_post_header_spacing',
				'#customize-control-blog_single_divider_2',
				'#customize-control-single_post_image_title',
				'#customize-control-single_post_show_featured',
				'#customize-control-single_post_image_placement',
				'#customize-control-single_post_image_spacing',
				'#customize-control-blog_single_divider_3',
				'#customize-control-single_post_meta_title',
				'#customize-control-single_post_meta_position',
				'#customize-control-single_post_meta_elements',
				'#customize-control-single_post_meta_spacing',
				'#customize-control-blog_single_divider_4',
				'#customize-control-single_post_elements_title',
				'#customize-control-single_post_show_tags',
				'#customize-control-single_post_show_author_box',
				'#customize-control-single_post_show_post_nav',
				'#customize-control-single_post_show_related_posts',
				'#customize-control-single_post_related_posts_slider',
				'#customize-control-single_post_related_posts_slider_nav',
				'#customize-control-single_post_related_posts_number',
				'#customize-control-single_post_related_posts_columns_number',
				'#customize-control-single_post_author_box_align',
			)),
			'controls_design' => wp_json_encode(array(
				'#customize-control-single_post_title_color',
				'#customize-control-single_post_meta_color',
				'#customize-control-single_post_title_title',
				'#customize-control-single_post_title_font_style',
				'#customize-control-single_post_title_adobe_font',
				'#customize-control-single_post_title_font',
				'#customize-control-single_post_title_size',
				'#customize-control-single_post_title_text_style',
				'#customize-control-single_post_meta_title2',
				'#customize-control-single_post_meta_size',
			)),
			'priority' => 10,
		)
	)
);

//Layout
$wp_customize->add_setting(
	'blog_single_layout',
	array(
		'default'           => 'layout1',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Emoza_Radio_Images(
		$wp_customize,
		'blog_single_layout',
		array(
			'label'    => esc_html__('Post layout', 'emoza-woocommerce'),
			'section'  => 'emoza_section_blog_singles',
			'cols'      => 2,
			'choices'  => array(
				'layout1' => array(
					'label' => esc_html__('Centered', 'emoza-woocommerce'),
					'url'   => '%s/assets/img/bls1.svg',
				),
				'layout2' => array(
					'label' => esc_html__('Wide', 'emoza-woocommerce'),
					'url'   => '%s/assets/img/bls2.svg',
				),
				'layout3' => array(
					'label' => esc_html__('Full width', 'emoza-woocommerce'),
					'url'   => '%s/assets/img/bls3.svg',
				),
			),
			'priority' => 20,
		)
	)
);

$wp_customize->add_setting(
	'sidebar_single_post',
	array(
		'default'           => '',
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'sidebar_single_post',
		array(
			'label'             => esc_html__('Enable sidebar', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'active_callback' => 'emoza_callback_single_post_layout',
			'priority'          => 30,
		)
	)
);

$wp_customize->add_setting(
	'sidebar_single_post_position',
	array(
		'default'           => 'sidebar-right',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control(new Emoza_Radio_Buttons(
	$wp_customize,
	'sidebar_single_post_position',
	array(
		'label'     => esc_html__('Sidebar position', 'emoza-woocommerce'),
		'section'   => 'emoza_section_blog_singles',
		'choices'   => array(
			'sidebar-left'      => esc_html__('Left', 'emoza-woocommerce'),
			'sidebar-right'     => esc_html__('Right', 'emoza-woocommerce'),
		),
		'active_callback'   => 'emoza_callback_sidebar_single_post',
		'priority'          => 40,
	)
));

$wp_customize->add_setting(
	'blog_single_divider_1',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Divider_Control(
		$wp_customize,
		'blog_single_divider_1',
		array(
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 50,
		)
	)
);

//Header
$wp_customize->add_setting(
	'single_post_header_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Text_Control(
		$wp_customize,
		'single_post_header_title',
		array(
			'label'         => esc_html__('Header', 'emoza-woocommerce'),
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 60,
		)
	)
);

$wp_customize->add_setting(
	'single_post_header_alignment',
	array(
		'default'           => 'middle',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control(new Emoza_Radio_Buttons(
	$wp_customize,
	'single_post_header_alignment',
	array(
		'label'     => esc_html__('Header alignment', 'emoza-woocommerce'),
		'section'   => 'emoza_section_blog_singles',
		'choices'   => array(
			'left'      => esc_html__('Left', 'emoza-woocommerce'),
			'middle'    => esc_html__('Middle', 'emoza-woocommerce'),
		),
		'priority'  => 70,
	)
));

$wp_customize->add_setting('single_post_header_spacing', array(
	'default'           => 40,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));

$wp_customize->add_control(new Emoza_Responsive_Slider(
	$wp_customize,
	'single_post_header_spacing',
	array(
		'label'         => esc_html__('Header spacing', 'emoza-woocommerce'),
		'section'       => 'emoza_section_blog_singles',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'single_post_header_spacing',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'priority'     => 80,
	)
));

$wp_customize->add_setting(
	'blog_single_divider_2',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Divider_Control(
		$wp_customize,
		'blog_single_divider_2',
		array(
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 90,
		)
	)
);


//Image
$wp_customize->add_setting(
	'single_post_image_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Text_Control(
		$wp_customize,
		'single_post_image_title',
		array(
			'label'         => esc_html__('Image', 'emoza-woocommerce'),
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 100,
		)
	)
);

$wp_customize->add_setting(
	'single_post_show_featured',
	array(
		'default'           => 1,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'single_post_show_featured',
		array(
			'label'             => esc_html__('Show featured image', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 110,
		)
	)
);

$wp_customize->add_setting(
	'single_post_image_placement',
	array(
		'default'           => 'below',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control(new Emoza_Radio_Buttons(
	$wp_customize,
	'single_post_image_placement',
	array(
		'label'     => esc_html__('Image placement', 'emoza-woocommerce'),
		'section'   => 'emoza_section_blog_singles',
		'choices'   => array(
			'below'     => esc_html__('Below', 'emoza-woocommerce'),
			'above'     => esc_html__('Above', 'emoza-woocommerce'),
		),
		'priority'  => 120,
	)
));

$wp_customize->add_setting('single_post_image_spacing', array(
	'default'           => 38,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));

$wp_customize->add_control(new Emoza_Responsive_Slider(
	$wp_customize,
	'single_post_image_spacing',
	array(
		'label'         => esc_html__('Image spacing', 'emoza-woocommerce'),
		'section'       => 'emoza_section_blog_singles',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'single_post_image_spacing',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'priority'      => 130,
	)
));

$wp_customize->add_setting(
	'blog_single_divider_3',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Divider_Control(
		$wp_customize,
		'blog_single_divider_3',
		array(
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 140,
		)
	)
);

//Meta
$wp_customize->add_setting(
	'single_post_meta_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Text_Control(
		$wp_customize,
		'single_post_meta_title',
		array(
			'label'         => esc_html__('Meta', 'emoza-woocommerce'),
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 150,
		)
	)
);

$wp_customize->add_setting(
	'single_post_meta_position',
	array(
		'default'           => 'above-title',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control(new Emoza_Radio_Buttons(
	$wp_customize,
	'single_post_meta_position',
	array(
		'label'     => esc_html__('Position', 'emoza-woocommerce'),
		'section'   => 'emoza_section_blog_singles',
		'choices'   => array(
			'above-title'   => esc_html__('Above title', 'emoza-woocommerce'),
			'below-title'   => esc_html__('Below title', 'emoza-woocommerce'),
		),
		'priority'  => 160,
	)
));

$wp_customize->add_setting('single_post_meta_elements', array(
	'default'           => array( 'emoza_posted_on', 'emoza_posted_by' ),
	'sanitize_callback' => 'emoza_sanitize_single_meta_elements',
));

$wp_customize->add_control(new \Kirki\Control\Sortable($wp_customize, 'single_post_meta_elements', array(
	'label'         => esc_html__('Meta elements', 'emoza-woocommerce'),
	'section' => 'emoza_section_blog_singles',
	'choices' => array(
		'emoza_posted_on'          => esc_html__('Post date', 'emoza-woocommerce'),
		'emoza_posted_by'          => esc_html__('Post author', 'emoza-woocommerce'),
		'emoza_post_categories'    => esc_html__('Post categories', 'emoza-woocommerce'),
		'emoza_entry_comments'     => esc_html__('Post comments', 'emoza-woocommerce'),
	),
	'priority'     => 170,
)));

$wp_customize->add_setting('single_post_meta_spacing', array(
	'default'           => 8,
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
));

$wp_customize->add_control(new Emoza_Responsive_Slider(
	$wp_customize,
	'single_post_meta_spacing',
	array(
		'label'         => esc_html__('Spacing', 'emoza-woocommerce'),
		'section'       => 'emoza_section_blog_singles',
		'is_responsive' => 0,
		'settings'      => array(
			'size_desktop'      => 'single_post_meta_spacing',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'priority'     => 180,
	)
));

$wp_customize->add_setting(
	'blog_single_divider_4',
	array(
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Divider_Control(
		$wp_customize,
		'blog_single_divider_4',
		array(
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 190,
		)
	)
);

//Elements
$wp_customize->add_setting(
	'single_post_elements_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Emoza_Text_Control(
		$wp_customize,
		'single_post_elements_title',
		array(
			'label'         => esc_html__('Elements', 'emoza-woocommerce'),
			'section'       => 'emoza_section_blog_singles',
			'priority'      => 200,
		)
	)
);
$wp_customize->add_setting(
	'single_post_show_tags',
	array(
		'default'           => 1,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'single_post_show_tags',
		array(
			'label'             => esc_html__('Post tags', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 210,
		)
	)
);
$wp_customize->add_setting(
	'single_post_show_author_box',
	array(
		'default'           => 0,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'single_post_show_author_box',
		array(
			'label'             => esc_html__('Author box', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 220,
		)
	)
);
$wp_customize->add_setting(
	'single_post_author_box_align',
	array(
		'default'           => 'center',
		'sanitize_callback' => 'emoza_sanitize_text',
	)
);
$wp_customize->add_control(new Emoza_Radio_Buttons(
	$wp_customize,
	'single_post_author_box_align',
	array(
		'label'   => esc_html__('Author box alignment', 'emoza-woocommerce'),
		'section' => 'emoza_section_blog_singles',
		'choices' => array(
			'left'      => '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
			'center'    => '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
			'right'     => '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
		),
		'active_callback' => 'emoza_callback_single_post_show_author_box',
		'priority'        => 230,
	)
));
$wp_customize->add_setting(
	'single_post_show_post_nav',
	array(
		'default'           => 1,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'single_post_show_post_nav',
		array(
			'label'             => esc_html__('Post navigation', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 240,
		)
	)
);
$wp_customize->add_setting(
	'single_post_show_related_posts',
	array(
		'default'           => 0,
		'sanitize_callback' => 'emoza_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Emoza_Toggle_Control(
		$wp_customize,
		'single_post_show_related_posts',
		array(
			'label'             => esc_html__('Related posts', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 250,
		)
	)
);

/**
 * Styling
 */

// Colors

// Title Color
$wp_customize->add_setting(
	'single_post_title_color',
	array(
		'default'           => '#212121',
		'sanitize_callback' => 'emoza_sanitize_hex_rgba',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Emoza_Alpha_Color(
		$wp_customize,
		'single_post_title_color',
		array(
			'label'             => esc_html__('Title color', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 251,
		)
	)
);

// Meta Color
$wp_customize->add_setting(
	'single_post_meta_color',
	array(
		'default'           => '#666666',
		'sanitize_callback' => 'emoza_sanitize_hex_rgba',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Emoza_Alpha_Color(
		$wp_customize,
		'single_post_meta_color',
		array(
			'label'             => esc_html__('Meta color', 'emoza-woocommerce'),
			'section'           => 'emoza_section_blog_singles',
			'priority'          => 251,
		)
	)
);

// Title
$wp_customize->add_setting(
	'single_post_title_title',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control(
	new Emoza_Text_Control(
		$wp_customize,
		'single_post_title_title',
		array(
			'label'    => esc_html__('Title', 'emoza-woocommerce'),
			'section'  => 'emoza_section_blog_singles',
			'priority' => 260,
		)
	)
);

// Typography
$wp_customize->add_setting(
	'single_post_title_font_style',
	array(
		'default'           => 'heading',
		'sanitize_callback' => 'emoza_sanitize_select',
	)
);
$wp_customize->add_control(
	'single_post_title_font_style',
	array(
		'type'      => 'select',
		'section'   => 'emoza_section_blog_singles',
		'label'     => esc_html__('Font Style', 'emoza-woocommerce'),
		'choices'   => array(
			'heading' => esc_html__('Heading', 'emoza-woocommerce'),
			'body'    => esc_html__('Body', 'emoza-woocommerce'),
			'custom'  => esc_html__('Custom', 'emoza-woocommerce'),
		),
		'priority'  => 260,
	)
);

$wp_customize->add_setting(
	'single_post_title_adobe_font',
	array(
		'default'           => 'system-default|n4',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(new Emoza_Typography_Adobe_Control(
	$wp_customize,
	'single_post_title_adobe_font',
	array(
		'section'         => 'emoza_section_blog_singles',
		'active_callback' => 'emoza_single_post_title_font_library_adobe_and_custom_style',
		'priority'        => 260,
	)
));

$wp_customize->add_setting(
	'single_post_title_custom_font',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_setting(
	'single_post_title_custom_font_weight',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(new Emoza_Typography_Custom_Control(
	$wp_customize,
	'single_post_title_custom_font_typography',
	array(
		'section'         => 'emoza_section_blog_singles',
		'settings'        => array(
			'font-family'   => 'single_post_title_custom_font',
			'font-weight'   => 'single_post_title_custom_font_weight',
		),
		'active_callback' => 'emoza_single_post_title_font_library_custom_and_custom_style',
		'priority'        => 260,
	)
));

$wp_customize->add_setting(
	'single_post_title_font',
	array(
		'default'           => '{"font":"System default","regularweight":"400","category":"sans-serif"}',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'emoza_google_fonts_sanitize',
		'priority'          => 260,
	)
);
$wp_customize->add_control(new Emoza_Typography_Control(
	$wp_customize,
	'single_post_title_font',
	array(
		'section'  => 'emoza_section_blog_singles',
		'settings' => array(
			'family' => 'single_post_title_font',
		),
		'input_attrs' => array(
			'font_count'     => 'all',
			'orderby'        => 'alpha',
			'disableRegular' => false,
		),
		'active_callback' => 'emoza_single_post_title_font_library_google_and_custom_style',
		'priority'  => 260,
	)
));

// Font Size
$wp_customize->add_setting('single_post_title_size_desktop', array(
	'default'           => 32,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));
$wp_customize->add_setting('single_post_title_size_tablet', array(
	'default'           => 32,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));
$wp_customize->add_setting('single_post_title_size_mobile', array(
	'default'           => 32,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));
$wp_customize->add_control(new Emoza_Responsive_Slider(
	$wp_customize,
	'single_post_title_size',
	array(
		'label'         => esc_html__('Font Size', 'emoza-woocommerce'),
		'section'       => 'emoza_section_blog_singles',
		'is_responsive' => 1,
		'settings'      => array(
			'size_desktop'      => 'single_post_title_size_desktop',
			'size_tablet'       => 'single_post_title_size_tablet',
			'size_mobile'       => 'single_post_title_size_mobile',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 200,
		),
		'priority'      => 260,
	)
));

// Text Style
$wp_customize->add_setting('single_post_title_text_decoration', array(
	'default'           => 'none',
	'transport'         => 'postMessage',
	'sanitize_callback' => 'emoza_sanitize_text',
));
$wp_customize->add_setting('single_post_title_text_transform', array(
	'default'           => 'none',
	'transport'         => 'postMessage',
	'sanitize_callback' => 'emoza_sanitize_text',
));
$wp_customize->add_control(new Emoza_Text_Style_Control(
	$wp_customize,
	'single_post_title_text_style',
	array(
		'section'  => 'emoza_section_blog_singles',
		'settings' => array(
			'decoration' => 'single_post_title_text_decoration',
			'transform'  => 'single_post_title_text_transform',
		),
		'priority' => 260,
	)
));

// Title
$wp_customize->add_setting(
	'single_post_meta_title2',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control(
	new Emoza_Text_Control(
		$wp_customize,
		'single_post_meta_title2',
		array(
			'label'    => esc_html__('Meta', 'emoza-woocommerce'),
			'section'  => 'emoza_section_blog_singles',
			'priority' => 290,
		)
	)
);

// Font size
$wp_customize->add_setting('single_post_meta_size_desktop', array(
	'default'           => 14,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));
$wp_customize->add_setting('single_post_meta_size_tablet', array(
	'default'           => 14,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));
$wp_customize->add_setting('single_post_meta_size_mobile', array(
	'default'           => 14,
	'transport'         => 'postMessage',
	'sanitize_callback' => 'absint',
));
$wp_customize->add_control(new Emoza_Responsive_Slider(
	$wp_customize,
	'single_post_meta_size',
	array(
		'label'         => esc_html__('Font Size', 'emoza-woocommerce'),
		'section'       => 'emoza_section_blog_singles',
		'is_responsive' => 1,
		'settings'      => array(
			'size_desktop'      => 'single_post_meta_size_desktop',
			'size_tablet'       => 'single_post_meta_size_tablet',
			'size_mobile'       => 'single_post_meta_size_mobile',
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 200,
		),
		'priority'      => 290,
	)
));
