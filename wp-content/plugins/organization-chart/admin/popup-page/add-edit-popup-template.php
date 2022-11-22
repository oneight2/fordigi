<form action="admin.php?page=wpda_chart_tree_popup_themes<?php if ($params['id']) echo '&id=' . $params['id']; ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
    <div class="container">
        <div class="header">
            <span>
                <h2 class="wpda_theme_title"><?php echo $params['id'] ? "Edit" : "Add" ?> the popup theme</h2>
            </span>
            <div class="header_action_buttons">
                <span><input type="button" onclick="submitButton('save_popup_theme')" value="Save" class="button-primary action"> </span>
                <span><input type="button" onclick="submitButton('update_popup_theme')" value="Apply" class="button-primary action"> </span>
                <span><input type="button" onclick="window.location.href='admin.php?page=wpda_chart_tree_popup_themes'" value="Cancel" class="button-secondary action"> </span>
            </div>
        </div>
        <div class="option_panel">
            <div class="parameter_name"></div>
            <div class="all_options_panel">
                <input type="text" class="theme_name" name="name" placeholder="Enter name here" value="<?php echo isset($name) ? $name : '' ?>">
                <?php
                $tabs_titles = array();
                $tabs_content = array();
                foreach ($params['options'] as $params_group_name => $params_group_value) {
                    $tab_html = '';
                    foreach ($params_group_value['params'] as $param_name => $param_value) {
                        $args = array(
                            "name" => $param_name,
                            "heading_name" => $params_group_value['heading_name'],
                            "heading_group" => $params_group_name,
                        );
                        $args = array_merge($args, $param_value);
                        $tab_html .= wpda_org_chart_library::create_setting($args);
                    }
                    $tabs_titles[] = $params_group_value['heading_name'];
                    $tabs_content[] = $tab_html;
                }
                echo wpda_org_chart_library::create_tab($tabs_titles, $tabs_content);
                ?>
            </div>
        </div>
    </div>
</form>