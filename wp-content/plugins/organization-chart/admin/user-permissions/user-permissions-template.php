<form action="<?php echo $params['current_page_link'] ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
    <div class="container">
        <div class="header">
            <span>
                <h2 class="wpda_theme_title">User permissions settings</h2>
            </span>
        </div>
        <div class="option_panel">
            <div class="all_options_panel">
                <?php
                $user_permissions_html = '';
                foreach ($params['options'] as $param_name => $param_value) {
                    $args = array(
                        "name" => $param_name
                    );
                    $args = array_merge($args, $param_value);
                    $user_permissions_html .= wpda_org_chart_library::create_setting($args);
                }
                echo $user_permissions_html;
                ?>
            </div>
            <br>
            <input type="button" onclick="submitButton('save')" value="Save" class="button-primary action">
        </div>
    </div>
</form>