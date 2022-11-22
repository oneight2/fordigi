<?php
/**
 * This file is used to  create settings in admin side
 *
 * @package the-events-calendar-single-event-templates-addon-free/includes
 */
namespace eptssettings;

if ( ! function_exists( 'tribe_get_events' ) ) {
	return;
}
function epta_get_all_temp() {
	$args     = array(
		'post_status' => 'publish,private',
		'post_type'   => 'epta',
	);
	$my_pages = get_pages( $args );
	// var_dump($my_pages);
	$get_temp_arr = array();
	foreach ( $my_pages as $my_page ) {
		$temp_key                  = $my_page->post_title;
		$get_temp_arr[ $temp_key ] = $my_page->post_title;

	}
	$temp_title = $get_temp_arr;
	return $temp_title;
	// var_dump($title);
}
$epta_get_all_temp = epta_get_all_temp();

/**
 * Get all categoery
 */
function epta_get_all_categoery() {
	$ect_cat_name = '';
	$ect_get_cat  = get_terms( 'tribe_events_cat' );
	if ( $ect_get_cat != '' ) :
		$ect_tslugs_arr = array();
		foreach ( $ect_get_cat as $ect_slug_name ) {
			$tecset_cat_slug                    = $ect_slug_name->slug;
			$ect_tslugs_arr[ $tecset_cat_slug ] = $ect_slug_name->slug;

		}
		$ect_cat_name = $ect_tslugs_arr;
	   endif;
	return $ect_cat_name;
}
$tecset_cate = epta_get_all_categoery();
/**
 * Get tag list
 */
function epta_get_tag() {
	$tecset_tag_name = '';
	$tecset_get_tag  = get_terms( 'post_tag' );

	  $tecset_tslugs_arr = array();
	foreach ( $tecset_get_tag as $tecset_tag_name ) {
		$tecset_get_tag                       = $tecset_tag_name->slug;
		$tecset_tslugs_arr[ $tecset_get_tag ] = $tecset_tag_name->slug;
	}
		$tecset_tag_name = $tecset_tslugs_arr;
		return $tecset_tag_name;
}
$tecset_admin_url   = admin_url( 'edit.php?page=tribe-common&tab=display&post_type=tribe_events' );
$tecset_date_format = array(
	'default' => 'default',
	'DM'      => 'dM (01 Jan)',
	'MD'      => 'MD(Jan 01)',
	'FD'      => 'FD(January 01)',
	'DF'      => 'DF(01 January)',
	'FD,Y'    => 'FD,Y(January 01, 2019)',
	'MD,Y'    => 'MD,Y(Jan 01, 2019)',
	'MD,YT'   => 'MD,YT(Jan 01, 2019 8:00am-5:00pm)',
	'full'    => 'full(01 January 2019 8:00am-5:00pm)',
	'dFY'     => 'dFY(01 January 2019)',
	'dMY'     => 'dMY(01 Jan 2019)',
);
 $tecset_tag        = epta_get_tag();
/**
 * Get all events
 */
function epta_get_all_event() {
	$tecset_events = '';

	$events = tribe_get_events(
		array(
			'posts_per_page' => -1,

		)
	);

	$tecset_tevents_arr = array();
	foreach ( $events as $event ) {
		$tecset_all_event                        = $event->post_name;
		$tecset_tevents_arr[ $tecset_all_event ] = $event->post_title;
	}
	$tecset_events = $tecset_tevents_arr;
	return $tecset_events;
}
 $tecset_get_event_list = epta_get_all_event();

/**
 * Initiate Main Meta box
 */
$cmb = new_cmb2_box(
	array(
		'id'           => 'epta-generate-shortcode',
		'title'        => __( 'Main Settings', 'cmb2' ),
		'object_types' => array( 'epta' ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
	)
);
	   /*
		 $cmb->add_field( array(
		  'name'    => 'Select Template',
		  'id'      => 'epta-select-temp',
		  'type'    => 'select',
		  // 'options' => $epta_get_all_temp,
		  'options' => array(
			'template-1' =>__('Template 1','cmb2'),
			'template-2' => __('Template 2', 'cmb2'),

		  ),

		  ) ); */
	$cmb->add_field(
		array(
			'name'    => 'Apply On',
			'id'      => 'epta-apply-on',
			'type'    => 'select',
			'options' => array(
				'none'           => __( 'None', 'cmb2' ),
				'all-event'      => __( 'All Events', 'cmb2' ),
				'specific-event' => __( 'Specific Event', 'cmb2' ),
				'specific-cate'  => __( 'Specific Categoery', 'cmb2' ),
				'specific-tag'   => __( 'Specific Tag', 'cmb2' ),
			),
		)
	);
		$cmb->add_field(
			array(
				'name'       => 'Specific Event',
				'id'         => 'epta-specific-event',
				'type'       => 'pw_multiselect',
				'options'    => $tecset_get_event_list,
				'attributes' => array(
					'required'               => true,
					'data-conditional-id'    => 'epta-apply-on',
					'data-conditional-value' => 'specific-event',
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => 'Select Categoery',
				'id'         => 'epta-categoery',
				'type'       => 'pw_multiselect',
				'options'    => $tecset_cate,
				'attributes' => array(
					'required'               => true,
					'data-conditional-id'    => 'epta-apply-on',
					'data-conditional-value' => 'specific-cate',
				),
			)
		);
		$cmb->add_field(
			array(
				'name'       => 'Select Tag</span>',
				'id'         => 'epta-tag',
				'type'       => 'pw_multiselect',
				'options'    => $tecset_tag,
				'attributes' => array(
					'required'               => true,
					'data-conditional-id'    => 'epta-apply-on',
					'data-conditional-value' => 'specific-tag',
				),
			)
		);
		$cmb->add_field(
			array(
				'name'    => 'Date Format',
				'desc'    => 'Select Date Format(Please check TEC settings for Default date format)<a href = "' . $tecset_admin_url . '">Click here </a>',
				'id'      => 'tecset-date-format',
				'options' => $tecset_date_format,
				'type'    => 'select',
			)
		);

		$cmb->add_field(
			array(
				'name' => 'Custom all events page slug',
				'desc' => 'Enter custom all events page slug',
				'id'   => 'epta-url',
				'type' => 'text',
			)
		);

		$cmb->add_field(
			array(
				'name' => 'Template Primary Color',
				'desc' => 'For heading background color',
				'id'   => $prefix . 'primary-color',
				'type' => 'colorpicker',

			)
		);
			$cmb->add_field(
				array(
					'name' => 'Primary Alternate Color ',
					'desc' => 'For text where primary color will background color',
					'id'   => $prefix . 'alternate-primary-color',
					'type' => 'colorpicker',

				)
			);
				$cmb->add_field(
					array(
						'name' => 'Secocndary Color',
						'desc' => 'For sidebar background Color',
						'id'   => $prefix . 'secondary-alternate-color',
						'type' => 'colorpicker',

					)
				);
				$cmb->add_field( 
					array(
						'name' => 'Custom CSS',
						'desc' => 'Enter custom CSS',
						'id'   => 'epta-custom-css',
						'type' => 'textarea_code',
						'attributes' => array(
							'data-codeeditor' => json_encode( array(
								'codemirror' => array(
									'mode' => 'css',
								),
							) ),
						),
				) );



				/**
				 * Initiate Main Meta box
				 */
				$cmbforReview = new_cmb2_box(
					array(
						'id'           => 'epta-share-review',
						'title'        => __( 'Is it Helpful for you?', 'cmb2' ),
						'object_types' => array( 'epta' ), // Post type
						'context'      => 'side',
						'priority'     => 'low',
						'show_names'   => true, // Show field names on the left
					)
				);
				$cmbforReview->add_field(
					array(
						'name' => '',
						'desc' => '
    We hope it meets your expectations!<br/>
    Please give us a quick rating, it works as a boost for us to keep working on it.
    <hr>
    <a href="https://wordpress.org/support/plugin/event-page-templates-addon-for-the-events-calendar/reviews/#new-post" class="like_it_btn button button-primary" target="_new" title="Rate Now! ★★★★★">Rate Now! ★★★★★</a>
    <a class="like_it_btn button button-primary" target="_new"
    href="https://eventscalendaraddons.com/event/boston-biggest-marathon-run/?utm_source=epta_plugin&utm_medium=plugin_link&utm_campaign=epta_plugin_inside">
    View Demo</a>
    <h4>Check other Addon plugin(The Events Calendar Shortcode) Demo</a>
    <ul>
    <li> <a target="_blank" href="https://eventscalendaraddons.com/demos/events-shortcodes-pro/events-list/?utm_source=epta_plugin&utm_medium=plugin_link&utm_campaign=epta_plugin_inside">Events List Demo</a></li>
    <li> <a target="_blank" href="https://eventscalendaraddons.com/demos/events-shortcodes-pro/events-grid/?utm_source=epta_plugin&utm_medium=plugin_link&utm_campaign=epta_plugin_inside">Events Grid Demo</a></li>
    <li> <a target="_blank" href="https://eventscalendaraddons.com/demos/events-shortcodes-pro/events-carousel/?utm_source=epta_plugin&utm_medium=plugin_link&utm_campaign=epta_plugin_inside">Events Carousel Demo</a></li>
    <li> <a target="_blank" href="https://eventscalendaraddons.com/demos/events-shortcodes-pro/events-slider/?utm_source=epta_plugin&utm_medium=plugin_link&utm_campaign=epta_plugin_inside">Events Slider Demo</a></li>
    <li> <a target="_blank" href="https://eventscalendaraddons.com/demos/events-shortcodes-pro/events-masonry/?utm_source=epta_plugin&utm_medium=plugin_link&utm_campaign=epta_plugin_inside">Events Masonry Layout Demo</a></li>
    </ul>
   
    ',
						'type' => 'title',
						'id'   => 'wiki_test_title',
					)
				);



