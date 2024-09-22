<?php


// Đăng ký meta box cho phim
function register_combined_movie_meta_box() {
    add_meta_box(
        'combined_movie_meta',
        'Thông Tin Phim',
        'render_combined_movie_meta_box',
        ['post', 'movie'],  // Áp dụng cho các loại bài viết 'post' và 'movie'
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'register_combined_movie_meta_box');

// Hiển thị nội dung của meta box
function render_combined_movie_meta_box($post) {
    // Tạo nonce để bảo mật
    wp_nonce_field('combined_movie_meta_box_nonce_action', 'combined_movie_meta_box_nonce');

    // Lấy giá trị meta hiện tại
    $episode_list = get_post_meta($post->ID, 'episode_list', true);
    $fields = [
        'ten_phim' => 'Tên Phim',
        'eng_name' => 'Tên Tiếng Anh',
        'trang_thai' => 'Trạng Thái'
    ];

    ?>
    <div>
        <h4>Chi Tiết Tập Phim</h4>
        <label for="episode_list">Danh sách tập phim (Tập 01|URL, Tập 02|URL, ...):</label>
        <textarea id="episode_list" name="episode_list" rows="3" style="width:100%;"><?php echo esc_textarea($episode_list); ?></textarea>
    </div>
    <hr/>
    <div>
        <h4>Chi Tiết Phim</h4>
        <?php foreach ($fields as $key => $label): ?>
            <p>
                <label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?>:</label>
                <input type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(get_post_meta($post->ID, '_' . $key, true)); ?>" style="width:100%;" />
            </p>
        <?php endforeach; ?>
    </div>
    <hr/>
    <?php
}

// Lưu dữ liệu của meta box
function save_combined_movie_meta_box($post_id) {
    // Kiểm tra nếu nonce có hợp lệ hay không
    if (!isset($_POST['combined_movie_meta_box_nonce']) || !wp_verify_nonce($_POST['combined_movie_meta_box_nonce'], 'combined_movie_meta_box_nonce_action')) {
        return;
    }

    // Kiểm tra quyền sửa bài viết
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Lưu danh sách tập phim
    if (isset($_POST['episode_list'])) {
        update_post_meta($post_id, 'episode_list', sanitize_textarea_field($_POST['episode_list']));
    }

    // Lưu chi tiết phim
    $fields = ['ten_phim', 'eng_name', 'trang_thai'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_combined_movie_meta_box');


function register_custom_rewrite_rules() {
    // Quy tắc rewrite cho URL tùy chỉnh 'xem-phim'
    add_rewrite_rule(
        '^xem-phim/([^/]*)/?',
        'index.php?xem_phim_slug=$matches[1]',
        'top'
    );

    // Quy tắc rewrite cho URL tùy chỉnh 'phim-moi'
    add_rewrite_rule(
        '^phim-moi/?$', // URL 'phim-moi'
        'index.php?phim_moi=1', // Đích đến là index.php với query var 'phim_moi'
        'top' // Ưu tiên rewrite rule này
    );
}
add_action('init', 'register_custom_rewrite_rules');

// Thêm query vars
function add_custom_query_vars($vars) {
    // Thêm các biến query vào danh sách
    $vars[] = 'xem_phim_slug';
    $vars[] = 'tap'; // Thêm 'tap' vào query vars
    $vars[] = 'phim_moi'; // Thêm 'phim_moi' vào query vars
    return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');

// Điều hướng đến template tùy chỉnh
function template_redirect_custom() {
    // Xử lý điều hướng cho URL 'xem-phim'
    if ($xem_phim_slug = get_query_var('xem_phim_slug')) {
        include(get_template_directory() . '/template-parts/xem-phim.php');
        exit; // Ngăn WordPress tiếp tục xử lý
    }

    // Xử lý điều hướng cho URL 'phim-moi'
    if (get_query_var('phim_moi') == 1) {
        include(get_template_directory() . '/template-parts/phim-moi.php');
        exit; // Ngăn WordPress tiếp tục xử lý
    }
}
add_action('template_redirect', 'template_redirect_custom');




//SET VIEW FUNTION

function set_post_view($postID) {
    $count_key = 'post_views_count';
    $ip_key = 'post_view_ips';

    // Lấy địa chỉ IP của người dùng
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Lấy thời gian hiện tại
    $current_time = current_time('timestamp');
    
    // Lấy danh sách IP đã lưu trữ
    $view_ips = get_post_meta($postID, $ip_key, true);
    if (!$view_ips) {
        $view_ips = [];
    }
    
    // Kiểm tra xem IP này đã được ghi nhận trong vòng 12 giờ chưa
    $ip_valid = !isset($view_ips[$user_ip]) || ($current_time - $view_ips[$user_ip] > 12 * HOUR_IN_SECONDS);

    // Nếu IP hợp lệ, tăng số lượt xem và cập nhật thời gian
    if ($ip_valid) {
        $count = get_post_meta($postID, $count_key, true);
        $count = $count ? (int)$count + 1 : 1;
        update_post_meta($postID, $count_key, $count);

        // Cập nhật thời gian cho IP này
        $view_ips[$user_ip] = $current_time;
        update_post_meta($postID, $ip_key, $view_ips);
    }
}

function track_post_views() {
    if (is_single()) {
        global $post;
        if (empty($post)) return;
        // Kiểm tra nếu người dùng là admin, thì không đếm lượt xem
        if (!current_user_can('manage_options')) {
            set_post_view($post->ID);
        }
    }
}
add_action('wp_head', 'track_post_views');


// Hiển thị số lượt xem trong phần quản trị
function posts_column_views($columns) {
    if (current_user_can('manage_options')) {
        $columns['post_views'] = __('Views');
    }
    return $columns;
}
add_filter('manage_posts_columns', 'posts_column_views');

function posts_custom_column_views($column_name, $id) {
    if ($column_name === 'post_views') {
        $views = get_post_meta($id, 'post_views_count', true);
        echo esc_html($views ? $views : '0');
    }
}
add_action('manage_posts_custom_column', 'posts_custom_column_views', 10, 2);

function get_post_view($postID) {
    $count_key = 'post_views_count';
    $views = get_post_meta($postID, $count_key, true);
    return $views ? (int)$views : 0;
}




//END

function mytheme_admin_notice() {
    $screen = get_current_screen();
    if ($screen->id === 'dashboard') {
        $transient_key = 'mytheme_changelog';
        $update_info = get_transient($transient_key);

        if (false === $update_info) {
            $changelog_path = get_template_directory() . '/assets/changelog.txt';
            
            if (file_exists($changelog_path)) {
                $update_info = file_get_contents($changelog_path);
                set_transient($transient_key, $update_info, 12 * HOUR_IN_SECONDS);
            }
        }

        if ($update_info) {
            echo '<div class="notice notice-info is-dismissible">';
            echo '<p>' . wp_kses_post($update_info) . '</p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'mytheme_admin_notice');

//




function create_custom_taxonomies() {
    // Tạo Custom Taxonomy cho diễn viên, tương tự như tags
    register_taxonomy('dien_vien', 'post', array(
        'label' => __('Diễn Viên'),
        'rewrite' => array('slug' => 'dien-vien'),
        'hierarchical' => false, // Không phân cấp, giống như tags
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true, // Để hỗ trợ Gutenberg
    ));
    
    // Tạo Custom Taxonomy cho thể loại
    register_taxonomy('the_loai', 'post', array(
        'label' => __('Thể Loại'),
        'rewrite' => array('slug' => 'the-loai'),
        'hierarchical' => false, // Phân cấp, giống như danh mục
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
    ));
    
    // Tạo Custom Taxonomy cho quốc gia
    register_taxonomy('quoc_gia', 'post', array(
        'label' => __('Quốc Gia'),
        'rewrite' => array('slug' => 'quoc-gia'),
        'hierarchical' => true, // Phân cấp, giống như danh mục
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
    ));
    
    // Tạo Custom Taxonomy cho năm
    register_taxonomy('nam', 'post', array(
        'label' => __('Năm'),
        'rewrite' => array('slug' => 'nam'),
        'hierarchical' => true, // Phân cấp, giống như danh mục
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
    ));
}

add_action('init', 'create_custom_taxonomies');





function register_top_movies_endpoint() {
    register_rest_route('top-movies/v1', '/(?P<time_filter>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'get_top_movies',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'register_top_movies_endpoint');

function get_top_movies($data) {
    $time_filter = $data['time_filter'];
    $date_query = array();

    switch ($time_filter) {
        case 'day':
            $date_query = array('after' => '1 day ago');
            break;
        case 'week':
            $date_query = array('after' => '1 week ago');
            break;
        case 'month':
            $date_query = array('after' => '1 month ago');
            break;
        case 'year':
            $date_query = array('after' => '1 year ago');
            break;
    }

    $args = array(
        'post_type' => 'post', // Điều chỉnh nếu bạn có một post type khác
        'posts_per_page' => 10,
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'date_query' => $date_query
    );

    $query = new WP_Query($args);

    $movies = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $movies[] = array(
                'title' => get_the_title(),
                'link' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'eng_name' => get_post_meta(get_the_ID(), '_eng_name', true)
            );
        }
    }

    wp_reset_postdata();

    return $movies;
}


//

function sphim_custom_js_in_head() {
    $custom_js = get_theme_mod( 'sphim_header_js' );
    if ( ! empty( $custom_js ) ) {
        echo '<script>' . $custom_js . '</script>';
    }
}
add_action( 'wp_head', 'sphim_custom_js_in_head' );



function sphim_custom_js_in_footer() {
    $custom_js = get_theme_mod( 'sphim_footer_js' );
    if ( ! empty( $custom_js ) ) {
        echo '<script>' . $custom_js . '</script>';
    }
}
add_action( 'wp_footer', 'sphim_custom_js_in_footer' );


//








function custom_seo_title($title) {
    if (is_single()) {
        // Lấy các meta fields
        $ten_phim = get_post_meta(get_the_ID(), '_ten_phim', true);
        $trang_thai = get_post_meta(get_the_ID(), '_trang_thai', true);
        
        // Lấy năm từ taxonomy 'nam'
        $nam_terms = get_the_terms(get_the_ID(), 'nam');
        $nam = !empty($nam_terms) && !is_wp_error($nam_terms) ? esc_html($nam_terms[0]->name) : '';

        // Bắt đầu với "Xem Phim"
        $seo_title = 'Xem Phim';

        // Kiểm tra và thêm 'Tên Phim'
        if (!empty($ten_phim)) {
            $seo_title .= ' ' . ucwords(strtolower($ten_phim)); // Viết hoa chữ cái đầu của tên phim
        } else {
            // Nếu 'Tên Phim' trống, lấy tiêu đề bài viết
            $seo_title .= ' ' . ucwords(strtolower(get_the_title()));
        }

        // Thêm năm nếu có
        if (!empty($nam)) {
            $seo_title .= ' ' . $nam; // Năm giữ nguyên định dạng
        }

        // Thêm trạng thái nếu có
        if (!empty($trang_thai)) {
            $seo_title .= ' ' . ucwords(strtolower($trang_thai)); // Viết hoa chữ cái đầu của trạng thái
        }

        // Loại bỏ khoảng trắng thừa
        return trim($seo_title);
    }
    return $title;
}
add_filter('pre_get_document_title', 'custom_seo_title');



