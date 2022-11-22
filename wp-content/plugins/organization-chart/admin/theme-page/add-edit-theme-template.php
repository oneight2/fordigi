<form action="<?php echo $params['current_page_link'] . ($params['id'] ? ('&id=' . $params['id']) : ''); ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
    <div class="container">
        <div class="header">
            <span>
                <h2 class="wpda_theme_title"><?php echo $params['id'] ? "Edit" : "Add" ?> the Theme</h2>
            </span>
            <div class="header_action_buttons">
                <span><input type="button" onclick="submitButton('save_theme')" value="Save" class="button-primary action"> </span>
                <span><input type="button" onclick="submitButton('update_theme')" value="Apply" class="button-primary action"> </span>
                <span><input type="button" onclick="window.location.href='admin.php?page=wpda_chart_tree_themes'" value="Cancel" class="button-secondary action"> </span>
            </div>
        </div>
        <div class="option_panel">
            <div class="parameter_name"></div>
            <div class="all_options_panel">
                <input type="text" class="theme_name" name="name" placeholder="Enter name here" value="<?php echo isset($name) ? $name : '' ?>">
                <?php
                $tabs_titles = array();
                $tabs_content = array();
                $pro_span = '<span class="pro_heading">(Pro)</span>';
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
                    $tabs_titles[] = $params_group_value['heading_name'] . ((isset($params_group_value['pro']) && $params_group_value['pro'] == true) ? $pro_span : '');
                    $tabs_content[] = $tab_html;
                }
                echo wpda_org_chart_library::create_tab($tabs_titles, $tabs_content);
                ?>
            </div>
        </div>
    </div>
</form>