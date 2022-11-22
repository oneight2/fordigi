<?php
// the standard template for the admin page header
// required variable $template_parameters if it dose not exists use def
// file use $params variable contain page name and etc
defined('ABSPATH') || exit;
?>
<div class="wpda_wrap wrap wpda_main_admin">
    <div class="wpdevart_plugins_header div-for-clear">
        <div class="wpdevart_plugins_get_pro div-for-clear">
            <div class="wpdevart_plugins_get_pro_info">
                <h3>WpDevArt organization chart Premium</h3>
                <p>Powerful and Customizable organization chart</p>
            </div>
            <a target="blank" href="https://wpdevart.com/wordpress-organization-chart-plugin/" class="wpdevart_upgrade">Upgrade</a>
        </div>
        <a target="blank" href="<?php echo $params['support_link']; ?>" class="wpdevart_support">Have any Questions? Get quick support!</a>
    </div>
    <h2><?php echo $params['name']; ?>
        <a href="<?php echo $params['add_new_link']; ?>" class="add-new-h2">Add New</a>
    </h2>
    <div class="wpda_table_container" id="wpda_table_container">
    </div>
</div>