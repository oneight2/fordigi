<?php
if (!defined('ABSPATH')) {
   exit;
} 
/**
 * 
 * Addon dashboard sidebar.
 */

 if( !isset($this->main_menu_slug) ):
    return false;
 endif;

 $cool_support_email = esc_url("https://coolplugins.net/contact-plugin-support/");
 $coolpluginsweb = esc_url("https://coolplugins.net");
?>

<div class="cool-body-right">
   <a href="<?php echo esc_url($coolpluginsweb);?>" target="_blank"><img src="<?php echo esc_url(plugin_dir_url( $this->addon_file ) .'/assets/coolplugins-logo.png'); ?>"></a>
   <ul>
      <li>Cool Plugins develops top class addons for <b>The Events Calendar</b>.</li>
      <li>These addons have <b>20000+</b> active installs.</li>
      <li>For any query or support, please contact plugin support team.
      <br/><br>
      <a href="<?php echo esc_url($cool_support_email); ?>" target="_blank" class="button button-secondary">Premium Plugin Support</a>
      <br><br>
      </li>
      <li>We also provide <b>The Events Calendar</b> customization services.
      <br/><br>
      <a href="<?php echo esc_url($cool_support_email); ?>" target="_blank" class="button button-primary">Hire Developer</a>
      <br><br>
      </li>
   </ul>
</div>

</div><!-- End of main container-->