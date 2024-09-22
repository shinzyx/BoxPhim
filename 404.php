<?php get_header(); ?>
<div class="404-container">
<h1>Oops! Trang không tìm thấy</h1>
<p>Chúng tôi không thể tìm thấy trang bạn yêu cầu. Có thể bạn muốn xem một bộ phim khác?</p>
<form id="header-search 404" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
    <div class="search-group">
        <input type="text" name="s" class="search-input" placeholder="<?php esc_attr_e('Tìm kiếm...', 'sphim'); ?>" aria-label="<?php esc_attr_e('Search', 'sphim'); ?>" value="<?php echo get_search_query(); ?>" />
        <button type="submit" class="search-btn" aria-label="<?php esc_attr_e('Search', 'sphim'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
    </div>
</form>
</div>
<?php get_footer(); ?>