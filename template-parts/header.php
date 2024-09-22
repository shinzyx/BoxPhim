    <header id="header">
      <div class="header-content container">
        <button class="menu-btn" type="button" aria-label="Menu">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-menu">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>
        <a href="/" class="header-logo">
        <?php
    if ( get_theme_mod( 'sphim_header_logo' ) ) {
    echo '<img src="' . esc_url( wp_get_attachment_url( get_theme_mod( 'sphim_header_logo' ) ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
}?>
</a>

        <button class="search-btn" type="button" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-search">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>
        <button class="close-menu close-search" type="button" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svgred">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
        <nav id="header-nav">
          <ul class="header-menu">
            <li class="close-group">
              <button type="button" class="close-menu" id="close-menu" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-x">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Đóng Menu
              </button>
            </li>
            <?php
            wp_nav_menu(array(
              'theme_location' => 'header',
              'container' => false,
              'items_wrap' => '%3$s',
              'depth' => 1,
              'fallback_cb' => false,
            ));
            ?>
          </ul>
        </nav>


        <form id="header-search" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
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
      <div class="overlay"></div>
    </header>