<form action="<?php echo $params['current_page_link'] . ($params['id'] ? ('&id=' . $params['id']) : ''); ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
    <div class="container">
        <div class="header">
            <span>
                <h2 class="wpda_chart_tree_title"><?php echo $params['id'] ? ("Edit the Organization chart " . (isset($params['tree']->name) ? '<span style="color:#2abf00">' . $params['tree']->name . '</span>' : '')) : "Add chart tree"; ?></h2>
            </span>
            <div class="header_action_buttons">
                <span><input type="button" onclick="submitButton('save_tree')" value="Save" class="button-primary action"> </span>
                <span><input type="button" onclick="submitButton('update_tree')" value="Apply" class="button-primary action"> </span>
                <span><input type="button" onclick="window.location.href='<?php echo $params['current_page_link'] ?>'" value="Cancel" class="button-secondary action"> </span>
            </div>
        </div>
        <input type="text" class="tree_name" name="name" placeholder="Enter name here" value="<?php echo isset($params['tree']->name) ? $params['tree']->name : '' ?>">
        <div class="option_panel">
            <div class="org_chart_container">
                <div id="wpdevart_tree" class='tree'>
                    <ul>
                        <li>
                            <div class="wpdevart_tree_node">
                                <span class="node_img"><img src="<?php echo $params['plugin_url'] . 'admin/' ?>assets/images/staff-icon.jpg"></span>
                                <br>
                                <button type="button" class="add_child_button"></button>
                                <span class="dashicons dashicons-edit edit_tree_node"></span>
                                <div class="node_title">Title</div>
                                <div class="node_desc">Description</div>
                                <input class="wpdevart_node_info" type="hidden" value='<?php echo isset($params['tree']->tree_nodes) ? $params['tree']->tree_nodes : $params['standard_json'];  ?>'>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="wpdevart_chart_tree_all_info" name="wpdevart_chart_tree_all_info" value="">
    <div id="org_chart_tinymce_container">
        <?php wp_editor('', 'org_chart_tinymce', array('textarea_rows' => 17)); ?>
    </div>
</form>