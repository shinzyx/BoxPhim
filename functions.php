<?php

require_once get_template_directory() . '/inc/sphim-pannel.php';
require_once get_template_directory() . '/inc/breadcrumb.php';
require_once get_template_directory() . '/inc/sphim-core.php';

if (!function_exists('sphim_theme_setup')) {
  function sphim_theme_setup() {
    // Hỗ trợ dịch
    load_theme_textdomain('sphim', get_template_directory() . '/languages');
    
    // Hỗ trợ tiêu đề tùy chỉnh
    add_theme_support('title-tag');

    // Hỗ trợ hình thu nhỏ bài viết
    add_theme_support('post-thumbnails');

    // Hỗ trợ feed tự động
    add_theme_support('automatic-feed-links');

    // Hỗ trợ các thẻ HTML5
    add_theme_support('html5', array(
      'search-form', 
      'comment-form', 
      'comment-list', 
      'gallery', 
      'caption'
    ));

    // Hỗ trợ logo tùy chỉnh
    add_theme_support('custom-logo', array(
      'height'      => 50,
      'width'       => 200,
      'flex-height' => true,
      'flex-width'  => true,
    ));

    // Đăng ký menu
    register_nav_menus(array(
      'header' => esc_html__('Header Menu', 'sphim'),
      'footer'  => esc_html__('Footer Menu', 'sphim'),
      'danh_muc_menu' => esc_html__('Danh Mục Menu'),
        'the_loai_menu' => esc_html__('Thể Loại Menu'),
        'dieu_khoan_menu' => esc_html__('Điều Khoản Menu'),
    ));
  }
}
add_action('after_setup_theme', 'sphim_theme_setup');

function sphim_setup_default_categories() {
  // Danh sách các danh mục mặc định
  $categories = array(
    'phim-bo' => 'Phim Bộ',
    'phim-le' => 'Phim Lẻ',
    'phim-chieu-rap' => 'Phim Chiếu Rạp',
    'phim-moi' => 'Phim Mới'
  );

  foreach ($categories as $slug => $name) {
    // Kiểm tra xem danh mục đã tồn tại chưa
    if (!term_exists($slug, 'category')) {
      // Tạo danh mục nếu chưa tồn tại
      wp_insert_term(
        $name,   // Tên danh mục
        'category', // Loại term
        array(
          'slug' => $slug
        )
      );
    }
  }
}
add_action('after_switch_theme', 'sphim_setup_default_categories');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

function sphim_theme_scripts()
{
  // Sửa đường dẫn cho file CSS
  wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/assets/style.css', array(), wp_get_theme()->get('Version'));

  // Sửa đường dẫn cho file JavaScript
  wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/main.js', array('jquery'), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'sphim_theme_scripts');
