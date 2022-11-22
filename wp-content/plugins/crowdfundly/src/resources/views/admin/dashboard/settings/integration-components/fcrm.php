<div class="crm-option" v-if="fcrm_contact">
    <c-search-multiselect
    label="<?php _e( 'Lists', 'crowdfundly' ); ?>"
    placeholder="<?php _e( 'Pick Lists', 'crowdfundly' ); ?>"
    :reduce="option => option"
    @selectedval="listSelectedValues"
    :options="listOptions"
    @getdata="getLists"
    :selected="listSelectedVal"
    classname="list"
    >
    </c-search-multiselect>

    <c-search-multiselect
    label="<?php _e( 'Tags', 'crowdfundly' ); ?>"
    placeholder="<?php _e( 'Pick Tags', 'crowdfundly' ); ?>"
    :reduce="option => option"
    @selectedval="tagSelectedValues"
    :options="tagOptions"
    @getdata="getTags"
    :selected="tagSelectedVal"
    classname="tag"
    >
    </c-search-multiselect>
</div>
