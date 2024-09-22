<footer id="footer">
  <div class="container footer-content">
    <div class="footer-top">
      <div class="footer-logo">
        <a href="/" title="Home">
         <?php if ( get_theme_mod( 'sphim_footer_logo' ) ) {
    echo '<img src="' . esc_url( wp_get_attachment_url( get_theme_mod( 'sphim_footer_logo' ) ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
}?>
        </a>
      </div>
      <div class="footer-about">
    <?php  if ( get_theme_mod( 'sphim_footer_text' ) ) {
    echo '<div class="footer-text">' . wp_kses_post( get_theme_mod( 'sphim_footer_text' ) ) . '</div>';
}
 ?>
      </div>
      <nav class="nav-footer">
      <div class="nav-col">
    <h4>Danh Mục</h4>
    <?php 
    wp_nav_menu(array(
        'theme_location' => 'danh_muc_menu',
        'container' => 'ul',
        'menu_class' => '',
    ));
    ?>
</div>

<div class="nav-col">
    <h4>Thể Loại</h4>
    <?php 
    wp_nav_menu(array(
        'theme_location' => 'the_loai_menu',
        'container' => 'ul',
        'menu_class' => '',
    ));
    ?>
</div>

<div class="nav-col">
    <h4>Điều Khoản</h4>
    <?php 
    wp_nav_menu(array(
        'theme_location' => 'dieu_khoan_menu',
        'container' => 'ul',
        'menu_class' => '',
    ));
    ?>
</div>

      </nav>
    </div>
    <div class="footer-bottom">
     <?php if ( get_theme_mod( 'sphim_footer_copyright' ) ) {
    echo '<p class="footer-copyright">' . esc_html( get_theme_mod( 'sphim_footer_copyright' ) ) . '</p>';
} ?>
    </div>
  </div>
</footer>