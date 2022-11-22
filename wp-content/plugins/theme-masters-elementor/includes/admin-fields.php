<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
* TABS
*/

if( !class_exists( 'CMB2_Tabs' ) ) {
    class CMB2_Tabs {
        public function __construct() {
            add_action( 'cmb2_before_form', array( $this, 'before_form' ), 10, 4 );
            add_action( 'cmb2_after_form', array( $this, 'after_form' ), 10, 4 );
        }

        public function before_form( $cmb_id, $object_id, $object_type, $cmb ) {
            if( $cmb->prop( 'tabs' ) && is_array( $cmb->prop( 'tabs' ) ) ) : ?>
                <div class="cmb-tabs-wrap cmb-tabs-<?php echo ( ( $cmb->prop( 'vertical_tabs' ) ) ? 'vertical' : 'horizontal' ) ?>">
                    <div class="cmb-tabs">

                        <?php foreach( $cmb->prop( 'tabs' ) as $tab ) :
                            $fields_selector = array();

                            foreach( $tab['fields'] as $tab_field )  :
                                $fields_selector[] = '.' . 'cmb2-id-' . str_replace( '_', '-', sanitize_html_class( $tab_field ) ) . ':not(.cmb2-tab-ignore)';
                            endforeach;

                            $fields_selector = apply_filters( 'cmb2_tabs_tab_fields_selector', $fields_selector, $tab, $cmb_id, $object_id, $object_type, $cmb );
                            $fields_selector = apply_filters( 'cmb2_tabs_tab_' . $tab['id'] . '_fields_selector', $fields_selector, $tab, $cmb_id, $object_id, $object_type, $cmb );
                            ?>

                            <div id="<?php echo $cmb_id . '-tab-' . $tab['id']; ?>" class="cmb-tab" data-fields="<?php echo implode( ', ', $fields_selector ); ?>">

                                <?php if( isset( $tab['icon'] ) && ! empty( $tab['icon'] ) ) :
                                    $tab['icon'] = strpos($tab['icon'], 'dashicons') !== false ? 'dashicons ' . $tab['icon'] : $tab['icon']?>
                                    <span class="cmb-tab-icon"><i class="<?php echo $tab['icon']; ?>"></i></span>
                                <?php endif; ?>

                                <?php if( isset( $tab['title'] ) && ! empty( $tab['title'] ) ) : ?>
                                    <span class="cmb-tab-title"><?php echo $tab['title']; ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>
            <?php endif;
        }
        
        public function after_form( $cmb_id, $object_id, $object_type, $cmb ) {
            if( $cmb->prop( 'tabs' ) && is_array( $cmb->prop( 'tabs' ) ) ) : ?></div><?php endif;
        }
    }

    $cmb2_tabs = new CMB2_Tabs();
}

/**
* SWITCH
*/

if ( ! class_exists( 'CMB2_Switch_Button' ) ) {
	class CMB2_Switch_Button {
		public function __construct() {
			add_action( 'cmb2_render_switch', array( $this, 'callback' ), 10, 5 );
		}
		public function callback( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
			$field_name   = $field->_name();
			$active_value = ! empty( $field->args( 'active_value' ) ) ? $field->args( 'active_value' ) : 'on';

			$args = array(
				'type'  => 'checkbox',
				'id'    => $field_name,
				'name'  => $field_name,
				'desc'  => '',
				'value' => $active_value,
			);
			if ( $escaped_value == $active_value ) {
				$args['checked'] = 'checked';
			}

			echo '<label class="cmb2-switch">';
			echo $field_type_object->input( $args );
			echo '<span class="cmb2-slider round"></span>';
			echo '</label>';
			$field_type_object->_desc( true, true );
		}

	}
	$cmb2_switch_button = new CMB2_Switch_Button();
}