<?php
// data coming from the OrganizationController
if ( $data['organization']['template_id'] == 1 ) {
    cf_loadViewTemplate('public/organization/template-one.php', $data);
} else {
    cf_loadViewTemplate('public/organization/template-two.php', $data);
}
