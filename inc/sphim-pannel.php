<?php

function sphim_customize_register( $wp_customize ) {

    // Tạo Panel
    $wp_customize->add_panel(
        'sphim_panel',
        [
            'priority' => 1,
            'title'    => esc_html__( 'sphim Theme Panel', 'sphim' ),
        ]
    );

    // Tạo Section Header
    $wp_customize->add_section(
        'sphim_header_section',
        [
            'title'    => esc_html__( 'Header Settings', 'sphim' ),
            'priority' => 10,
            'panel'    => 'sphim_panel',
        ]
    );

    // Tùy chọn Upload Logo trong Header
    $wp_customize->add_setting(
        'sphim_header_logo',
        [
            'default'           => '',
            'sanitize_callback' => 'absint', // đảm bảo đây là một ID hình ảnh hợp lệ
        ]
    );

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'sphim_header_logo_control',
            [
                'label'    => esc_html__( 'Upload Logo', 'sphim' ),
                'section'  => 'sphim_header_section',
                'settings' => 'sphim_header_logo',
                'mime_type' => 'image',
            ]
        )
    );

    // Trình viết mã JS vào <head>
    $wp_customize->add_setting(
        'sphim_header_js',
        [
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post', // cho phép mã HTML hợp lệ
        ]
    );

    $wp_customize->add_control(
        'sphim_header_js_control',
        [
            'label'    => esc_html__( 'Custom JS for <head>', 'sphim' ),
            'section'  => 'sphim_header_section',
            'settings' => 'sphim_header_js',
            'type'     => 'textarea',
        ]
    );

    // Tạo Section Footer
    $wp_customize->add_section(
        'sphim_footer_section',
        [
            'title'    => esc_html__( 'Footer Settings', 'sphim' ),
            'priority' => 20,
            'panel'    => 'sphim_panel',
        ]
    );

    // Tùy chọn Upload Logo trong Footer
    $wp_customize->add_setting(
        'sphim_footer_logo',
        [
            'default'           => '',
            'sanitize_callback' => 'absint',
        ]
    );

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'sphim_footer_logo_control',
            [
                'label'    => esc_html__( 'Upload Footer Logo', 'sphim' ),
                'section'  => 'sphim_footer_section',
                'settings' => 'sphim_footer_logo',
                'mime_type' => 'image',
            ]
        )
    );

    // Trình viết văn bản trong Footer
    $wp_customize->add_setting(
        'sphim_footer_text',
        [
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post', // cho phép HTML hợp lệ
        ]
    );

    $wp_customize->add_control(
        'sphim_footer_text_control',
        [
            'label'    => esc_html__( 'Footer Text Content', 'sphim' ),
            'section'  => 'sphim_footer_section',
            'settings' => 'sphim_footer_text',
            'type'     => 'textarea',
        ]
    );

    // Ô nhập tên bản quyền chân trang
    $wp_customize->add_setting(
        'sphim_footer_copyright',
        [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );

    $wp_customize->add_control(
        'sphim_footer_copyright_control',
        [
            'label'    => esc_html__( 'Footer Copyright Name', 'sphim' ),
            'section'  => 'sphim_footer_section',
            'settings' => 'sphim_footer_copyright',
            'type'     => 'text',
        ]
    );

    // Trình viết mã JS vào </body>
    $wp_customize->add_setting(
        'sphim_footer_js',
        [
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
        ]
    );

    $wp_customize->add_control(
        'sphim_footer_js_control',
        [
            'label'    => esc_html__( 'Custom JS for </body>', 'sphim' ),
            'section'  => 'sphim_footer_section',
            'settings' => 'sphim_footer_js',
            'type'     => 'textarea',
        ]
    );
}

add_action( 'customize_register', 'sphim_customize_register' );