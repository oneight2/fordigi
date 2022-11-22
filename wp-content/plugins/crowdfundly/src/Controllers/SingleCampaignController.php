<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Request;

/**
 * Campaign Controller
 * Provides functionality for the Single campaign page.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class SingleCampaignController extends BaseController
{
    public function register()
    {
        cf_wp_ajax( 'cf_story_data', [$this, 'cf_story_data'], true );
        cf_wp_ajax( 'cf_reminder', [$this, 'cf_reminder'], true );
        cf_wp_ajax( 'cf_activities_loadmore', [$this, 'cf_activities_loadmore'], true );
        cf_wp_ajax( 'cf_top_contributers_loadmore', [$this, 'cf_top_contributers_loadmore'], true );
        cf_wp_ajax( 'cf_stripe_payment', [$this, 'cf_stripe_payment'], true );
        cf_wp_ajax( 'get_payment_initiate', [$this, 'get_payment_initiate'], true );
        cf_wp_ajax( 'cf_payment_confirm', [$this, 'cf_payment_confirm'], true );
        cf_wp_ajax( 'cf_update_donnar_info', [$this, 'cf_update_donnar_info'], true );
        cf_wp_ajax( 'cf_razorpay_payment', [$this, 'cf_razorpay_payment'], true );
        cf_wp_ajax( 'cf_verify_payment', [$this, 'cf_verify_payment'], true );
    }

    public function renderView()
    {
        // if not login into crowdfundly from admin panel
        if ( ! DBAccessor::is_login() ) return;

        $data = [];
        $data['campaign'] = $this->get_single_campaign();
        // if unable to fetch data from api
        // or campaign not found
        if ( ! $data['campaign'] || empty( $data['campaign'] ) ) return false;
        
        // if campaign is not published, and current user is not admin or cf user,
        // then don't show not found.
        $camp_status = static::donation_status( $data['campaign']['status'] );
        if ( $camp_status != 'PUBLISHED' && ! static::campaign_user_access() ) {
            return $this->render( 'public/single-campaign/campaign-not-found.php', null, true );
        }

        $data['activities'] = $this->get_camp_activities( $data['campaign']['id'] );
        $data['updates'] = $this->get_camp_updates( $data['campaign']['id'] );
        $data['endorsements'] = $this->get_camp_endorsements( $data['campaign']['id'] );
        // $data['top_contributors'] = $this->get_camp_top_contributors( $data['campaign']['id'] );
        $data['top_contributors'] = $this->get_top_contributers( $data['campaign']['id'] );
        $data['notification'] = $this->campaign_notice( $data['campaign'] );
        $data['gateways'] = $this->get_gateways( $data['campaign'] );
        $data['settings'] = $this->get_settings_data( $data['campaign'] );
        $data['org_settings'] = $this->get_organization_settings();
        // Test Data
        $data['similar_camps'] = $this->similar_campaign($data['campaign']);

        return $this->render( 'public/single-campaign.php', $data, true );
    }

    public static function get_single_campaign($camp_slug = null)
    {
        $camps = AllCampaignController::get_all_campaigns();
        if ( ! $camps || empty( $camps['data'] ) ) return false;
        
        // get campaign slug from elementor editor
		$single_camp_slug = apply_filters( 'crowdfundly_single_camp', '' );
        $campaign_slug = false;
        if ( isset( $single_camp_slug['camp_id'] ) && ! empty( $single_camp_slug['camp_id'] ) ) {
            $campaign_slug = $single_camp_slug['camp_id'];
        } elseif ( isset( $single_camp_slug['camp_id'] ) && empty( $single_camp_slug['camp_id'] ) ) {
            $campaign_slug = $camps['data'][0]['slug'];
        }

        if ( isset( $_GET['camp'] ) && ! empty( $_GET['camp'] ) ) {
            $campaign_slug = sanitize_text_field( $_GET['camp'] );
		}
        if ( $camp_slug ) {
            $campaign_slug = $camp_slug;
		}
        if ( ! $campaign_slug ) {
            $campaign_slug = $camps['data'][0]['slug'];
        }
        if ( ! $campaign_slug ) return false;

        $args = [
			'headers' => [
                'Authorization' => 'Bearer ' . DBAccessor::getItem( 'token' )
            ],
			'timeout' => 15,
		];
        $route = 'campaign' . '/' . $campaign_slug;
        $response = Request::get( $route, $args );
        if ( $response->status_code() != 200 ) return false;

		return $response->body();
    }

    public static function build_url($url, $params = [])
    {
        $queries = [];
		// $parseUrl = parse_url( esc_url( $url ) );
        $queries = array_merge( $queries, $params );
        $base_url = strtok( $url, '?' );
        if ( ! empty( $queries ) ) {
            return $base_url . '?' . http_build_query( $queries );
		}
        return $base_url;
    }

    public static function get_camp_base_url()
    {
        $page_id = get_option( 'crowdfundly_single_campaign_page_id' );
		if ( ! $page_id ) return false;

        return esc_html( get_permalink( $page_id ) );
    }

    public static function get_single_camp_permalink($campaign_slug = null)
    {
        $single_camp_link = self::get_camp_base_url();
        if ( ! $single_camp_link ) return false;
        if ( ! $campaign_slug ) return $single_camp_link;
        
        $parse_url = parse_url( $single_camp_link );
        if ( isset( $parse_url['query'] ) ) {
            $schema = $parse_url['scheme'] . '://';
            unset( $parse_url['scheme'] );

            parse_str( $parse_url['query'], $queries );
            $queries['camp'] = $campaign_slug;
            unset( $parse_url['query'] );

            $base_url = $schema . implode( '', $parse_url );
            $single_camp_link = $base_url . '?' . http_build_query( $queries );
        } else {
            $single_camp_link = $single_camp_link . '?camp=' . $campaign_slug;
        }
        return $single_camp_link;
    }

    private static function get_video_url($url)
    {
        // $vm_rx = "vimeo.com";
        // $youtube_long = "www.youtube.com";
        // $youtube_short = "youtu.be";
        $youtube_short = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $youtube_long = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
        $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';

        // $url_parsed_arr = parse_url($url);
        //     parse_str( $url_parsed_arr['query'], $parse_query );
        //     if ( $url_parsed_arr['host'] == $youtube ) {
        //         return esc_url( 'https://youtube.com/embed/' . $parse_query['v'] );
        //     }

        //     if ( $url_parsed_arr['host'] == $youtube_short ) { 
        //         $youCode = explode('/', $url);
        //         return esc_url( 'https://youtube.com/embed/' . $youCode[3] );
        //     }
            
        //     if ( $url_parsed_arr['host'] == $vimeo ) {
        //         $vimeoCode = explode('/', $url); 
        //         return esc_url( 'https://player.vimeo.com/video/' . $vimeoCode[3] );
        //     }
       
        // return esc_url($url);
        if (preg_match($youtube_long, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
            return esc_url( 'https://www.youtube.com/embed/' . $youtube_id );
        }
    
        if (preg_match($youtube_short, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
            return esc_url( 'https://www.youtube.com/embed/' . $youtube_id );
        }
        if (preg_match($vm_rx, $url, $matches)) {
            $viemo_id = $matches[count($matches) - 1];
            return esc_url( 'https://player.vimeo.com/video/' . $viemo_id );
        }
        return esc_url($url);
    }

    private static function is_valid_video_url( $url )
    {
        $bool = false;
        $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        $has_match_youtube = preg_match($yt_rx, esc_url($url), $yt_matches);
    
        $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
        $has_match_vimeo = preg_match( $vm_rx, esc_url($url), $vm_matches );
    
        //Then we want the video id which is:
        if ( $has_match_youtube ) {
             $bool = true;
        } elseif ( $has_match_vimeo ) {
             $bool = true;
        } else {
             $bool = false;
        }
        return $bool;
    }

    private static function render_story($el)
    {
        if ( ! $el['model'] ) return '';
        $selected = $el['selectedElement'];

        if ( isset( $selected['isFile'] ) ) {
            return '<div class="'.$el['selectedElement']['class'].'"><img src='.$el['model'].'></div>';
        }

        if ( isset( $selected['isIframe'] ) ) {
			if ( ! $el['model'] ) return;

			if ( ! self::is_valid_video_url( $el['model'] ) ) {
				return '<p class="text-danger mt-2 mb-2">'.__("Invalid video URL !", "crowdfundly").'</p>';
			}
			$source = self::get_video_url( $el['model'] );
	
			$iframe = "<div class='story-video-wrapper text-center'>
						<iframe class='iframe' width='770' height='425' src='$source?controls=0' frameborder='0' allow='accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture' allowfullscreen></iframe>
					</div>
				";
			return $iframe;
		}

        return '<div class="'.$el['selectedElement']['class'].'">'.$el['model'].'</div>';
    }

    private static function get_slice_word_from_string($string, $wordCount, $separator = " ")
    {
        $word_count = $wordCount - 1;
        $story = explode( $separator, $string );
        if (  count( $story ) > $word_count ) {
            $excerpt = array_slice( $story, 0, $word_count );
            $excerpt = implode( " ", $excerpt ) . '...';
        } else {
            $excerpt = implode( " ", $story );
        }
        return esc_html( $excerpt );
    }

    public static function get_campaign_story_excerpt($story, $wordCount)
    {
        if ( ! $story ) return "";

        $story_string = strip_tags( $story );
        return self::get_slice_word_from_string( $story_string, $wordCount );
    }

    public static function render_slider_iframe($url)
    {
        if ( ! self::is_valid_video_url( $url ) ) return;

        $source = self::get_video_url( $url );
        return '<iframe src="'.$source.'" allow="clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen" id="v-player-iframe" class="v-player__iframe"></iframe>';
    }

    public static function campaign_donation_status($campaign)
    {
        if ( static::donation_status( $campaign['status'] ) != 'PUBLISHED' ) {
            return false;
        }

        $org_gateways_res = OrganizationController::get_org_gateways();
        $org_gateways = $org_gateways_res->body();
        if ( $org_gateways_res->status_code() != 200 || empty( $org_gateways ) ) {
            return false;
        } elseif ( empty( $campaign['options']['gateways'] ) ) {
            return false;
        }

        if ( count( $campaign['options']['gateways'] ) > 1 ) {
            $has_org_gateway = count( $campaign['options']['gateways'] );
            foreach ( $campaign['options']['gateways'] as $camp_gateway ) {
                if ( isset( $org_gateways[$camp_gateway] ) ) {
                    continue;
                }
                $has_org_gateway--;
            }
            if ( $has_org_gateway == 0 ) {
                return false;
            }
        } else {
            if ( ! isset( $org_gateways[$campaign['options']['gateways'][0]] ) ) {
                return false;
            }
        }

        if ( $campaign['target_amount_raised'] ) {
            return false;
        }
        if ( $campaign['target_amount'] && ( $campaign['raised_amount'] > $campaign['target_amount'] ) ) {
            return false;
        }
        if ( $campaign['target_date'] ) {
            $now = new \DateTime("now");
            $target_date = new \DateTime($campaign['target_date']);
            $result = $now->format('U') > $target_date->format('U');
            if ( $result ) return false;
        }
        return true;
	}

    public static function campaign_notice($campaign)
    {
        $status = static::donation_status( $campaign['status'] );
        if ( $status != 'PUBLISHED' ) {
            return __( "This campaign is in readonly view and publicly invisible.", "crowdfundly" );
        }
        if (  $campaign['target_amount_raised'] == true ) {
            return __( "Target amount is raised", "crowdfundly" );
        }
        if ( $campaign['target_date'] ) {
            $now = new \DateTime("now");
            $target_date = new \DateTime($campaign['target_date']);
            $result = $now->format('U') > $target_date->format('U');
            if ( $result ) {
                return __( "Campaign Target Date Expired", "crowdfundly" );
            }
        }

        return false;
    }

    public static function donation_status($status)
    {
        $status = (string) $status;
        $status_list = [
            '0'     => 'DRAFTED',
            '1'     => 'APPROVED',
            '2'     => 'REJECTED',
            '3'     => 'PENDING',
            '16'    => 'DELETED',
            '20'    => 'PUBLISHED',
        ];
        return $status_list[$status];
    }

    public static function get_campaign_story_details($camp_story)
    {
        if ( empty( $camp_story ) ) return '';

        $story = $camp_story;
        $story = json_decode( strip_tags( $story ), true );
        $html = '';
        if ( is_array( $story ) ) {
            foreach( $story as $story_line ) {
                $html .= self::render_story($story_line);
            }
        } else {
            $html = $camp_story;
        }

        return $html;
    }

    public static function get_camp_activities($id, $per_page =  3, $page = 1)
    {
        $route = 'campaigns/' . $id . '/activities?per_page=' . $per_page . '&page=' . $page;
        $response = Request::get( $route );
        if ( $response->status_code() !== 200 ) return false;

        return $response->body();
    }

    public function cf_activities_loadmore()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

        $camp_id = esc_html( $_POST['camp_id'] );
        $current_page = esc_html( $_POST['current_page'] );
        $org_settings = json_decode( esc_html( $_POST['org_settings'] ) );
        $camp_currency = json_decode( esc_html( $_POST['camp_currency'] ) );

        $activities = $this->get_camp_activities( $camp_id, 3, $current_page );
        if ( ! $activities ) {
            wp_send_json_error( [ 'message' => 'Something went wrong' ], 404 );
        }

        if ( $activities['data'] && ! empty( $activities['data'] ) ) :
            foreach ( $activities['data'] as $activity ) :
                $avatar_url = cf_asset( 'images/public/avatar.png' );
                if ( ! $activity['is_anonymous']
                    && isset( $activity['donation']['avatar'] )
                    && ! empty( $activity['donation']['avatar'] )
                ) {
                    $avatar_url = $activity['donation']['avatar'];
                }
                $name = '';
                if ( isset( $activity['donation']['full_name'] ) && ! isset( $activity['donation']['name'] ) ) {
                    $name = isset( $activity['donation']['full_name'] ) ? $activity['donation']['full_name'] : 'Anonymous Contributor 1';
                }
                if ( ! isset( $activity['donation']['full_name'] ) && isset( $activity['donation']['name'] ) ) {
                    $name = isset( $activity['donation']['name'] ) ? $activity['donation']['name'] : 'Anonymous Contributor 2';
                }
                if ( $activity['is_anonymous'] && isset( $activity['donation']['name'] ) == null ) {
                    $name = isset( $activity['donation']['full_name'] ) ? $activity['donation']['full_name'] : 'Anonymous Contributor 3';
                }
                if ( $activity['is_anonymous'] && isset( $activity['donation']['full_name']) ==null) {
                    $name = isset( $activity['donation']['name'] ) ? $activity['donation']['name'] : 'Anonymous Contributor';
                }
                if ( $activity['donation']['is_anonymous'] === (int) 0 && isset( $activity['donation']['full_name'])) {
                    $name = 'Anonymous Contributor';
                }
               
                ?>
                <div class="activity">
                    <div class="activity__avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
                    <div class="activity__details">
                        <div class="activity__row">
                            <div class="activity__name">
                                <?php
                                $offline = '';
                                if($activity['donation']['is_anonymous'] === (boolean)true || isset( $activity['donation']['name'] )) {
                                    $offline = __( 'offline', 'crowdfundly' );
                                }
                                echo esc_html( $name );
                                ?>
                                <span class="activity__label">
                                    <?php
                                    _e( 'has contributed', 'crowdfundly' );
                                    echo esc_html( ' ' . $offline );
                                    ?>
                                </span>
                            </div>
                            <p class="activity__date">
                                <?php echo date_i18n( get_option( 'links_updated_date_format' ), strtotime( $activity['created_at'] ) ); ?>
                            </p>
                        </div>
                        <div class="activity__row">
                            <div class="activity__label">
                                <?php _e( 'Amount:', 'crowdfundly' ); ?> 
                                <span class="activity__value">
                                    <?php
                                    echo esc_html(
                                        SingleCampaignController::get_currency_format(
                                            $org_settings, $camp_currency, $activity['formatted_donation_amount']
                                        )
                                    );
                                    ?>
                                </span>
                            </div>
                        </div>
                        <?php if ( isset( $activity['donation']['message'] ) ) : ?>
                            <div class="activity__row">
                                <p class="activity__message">
                                    <?php echo $activity['donation']['message']; ?>
                                </p>
                            </div>
                        <?php endif; ?>                                                 
                    </div>
                </div>
                <?php 
            endforeach;
        endif;
    }
    public static function get_top_contributers($id, $per_page =  4, $page = 1)
    {
        $route = 'campaigns/' . $id . '/top-donors?per_page=' . $per_page . '&page=' . $page;
        $response = Request::get( $route );
        if ( $response->status_code() !== 200 ) return false;
            // var_dump($response->body());
        return $response->body();
    }
    public function cf_top_contributers_loadmore()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

        $camp_id = esc_html( $_POST['camp_id'] );
        $current_page = esc_html( $_POST['current_page'] );
        $org_settings = json_decode( esc_html( $_POST['org_settings'] ) );
        $camp_currency = json_decode( esc_html( $_POST['camp_currency'] ) );
        $top_contributers = $this->get_top_contributers( $camp_id, 4, $current_page );
        if ( ! $top_contributers ) {
            wp_send_json_error( [ 'message' => 'Something went wrong' ], 404 );
        }

        if ( ! empty( $top_contributers['data'] ) ) :
            ?>
                <?php
                foreach ( $top_contributers['data'] as $contributor ) :
                    $avatar_url = cf_asset( 'images/public/avatar.png' );
                    if ( ! $contributor['is_anonymous'] && $contributor['avatar'] ) {
                        $avatar_url = $contributor['avatar'];
                    }
                    ?>
                    <div class="donor-list__item">
                        <div class="donor-card">
                            <div class="donor-card__avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
                            <div class="donor-card__details">
                                <h6 class="donor-card__name">
                                <?php /*var_dump($contributor['full_name']); */ ?>
                                    <?php echo isset( ($contributor['full_name'])) && ! empty($contributor['full_name'])  ? esc_html( $contributor['full_name'] ) : 'Anonymous Contributor'; ?>
                                </h6> 
                                <h6 class="donor-card__label">
                                    <?php _e( 'Amount:', 'crowdfundly' ); ?> 
                                    <span class="donor-card__value">
                                        <?php echo esc_html( SingleCampaignController::get_currency_format( $org_settings, $camp_currency, $contributor['formatted_amount'] ) ); ?>
                                    </span>
                                </h6>
                            </div>
                            <div class="donor-card__badge">
                                <img src="<?php echo esc_url( cf_asset( 'images/public/medal.svg' ) ); ?>" alt="<?php echo __( 'Badge', 'crowdfundly' ); ?>" class="donor-card__badge-img">
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            <?php
        endif;
    }
    public static function get_camp_updates($camp_id)
    {
        $route = 'campaigns/' . $camp_id . '/updates';
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return false;

        return $response->body();
    }

    public static function get_camp_endorsements($camp_id)
    {
        $route = 'campaigns/' . $camp_id . '/endorsements';
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return false;

        return $response->body();
    }

    public static function get_camp_top_contributors($camp_id)
    {
        $route = 'campaigns/' . $camp_id . '/top-donors';
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return false;

        return $response->body();
    }

    public static function campaign_user_access()
    {
        $current_user = wp_get_current_user();
        if ( ! $current_user ) return false;

        foreach ( $current_user->roles as $role ) {
            if ( $role == 'administrator' || $role == 'crowdfundly_admin' || $role == 'crowdfundly_manager' ) {
                return true;
            }
        }
        return false;
    }

    public function get_payment_initiate()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $route = 'donations';
        $data = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $response = Request::post(
            $route,
            [ 'body' => $data ]
        );

        if ( $response->status_code() > 299 ) {
            wp_send_json_error( $response->body(), $response->status_code() );
            wp_die();
        }
        wp_send_json( $response->body(), $response->status_code() );
        wp_die();
    }

    public function cf_payment_confirm()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $data = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $id = '';

        if ( $data['paymentType'] == 'stripe' ) {
            $id = $data['paymentID'];
            $data = $data['paymentIntent'];
        } elseif ($data['gateway'] == 'razorpay') {
            $id = $data['paymentID'];
            $data = $data['razorPayKey'];
        } else {
            $id = $data['id'];
        }
        $route = 'donations/' . $id . '/capture';
        $response = Request::post(
            $route,
            [ 'body' => $data ]
        );

        if ( $response->status_code() > 299 ) {
            $message = $response->body() ? $response->body() : $response->message();
            wp_send_json_error(
                $message,
                $response->status_code()
            );
            wp_die();
        }
        wp_send_json( $response->body(), 200 );
        wp_die();
    }
    public function cf_verify_payment()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $data = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $id = $data['id'];

        // if ( $data['paymentType'] == 'stripe' ) {
        //     $id = $data['paymentID'];
        //     $data = $data['paymentIntent'];
        // } elseif ($data['gateway'] == 'razorpay') {
        //     $id = $data['paymentID'];
        //     $data = $data['razorPayKey'];
        // } else {
        //     $id = $data['id'];
        // }
        $route = 'donations/' . $id . '/verify-payment';
        $response = Request::post(
            $route,
            [ 'body' => $data ]
        );

        if ( $response->status_code() > 299 ) {
            $message = $response->body() ? $response->body() : $response->message();
            wp_send_json_error(
                $message,
                $response->status_code()
            );
            wp_die();
        }
        wp_send_json( $response->body(), 200 );
        wp_die();
    }
    public function cf_update_donnar_info()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $data = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $route = 'donation/by-key';
        $response = Request::post(
            $route,
            [ 'body' => $data ]
        );

        if ( $response->status_code() > 299 ) {
            $message = $response->body() ? $response->body() : $response->message();
            wp_send_json_error(
                $message,
                $response->status_code()
            );
            wp_die();
        }
        wp_send_json( true, 200 );
        wp_die();
    }

    public function cf_stripe_payment()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $camp_id = esc_html( $_POST['campId'] );
        $route = 'campaigns/' . $camp_id . '/credentials?method=stripe';
        $response = Request::get( $route );

        if ( $response->status_code() != 200 ) {
            $message = $response->body() ? $response->body() : $response->message();
            wp_send_json_error(
                $message,
                $response->status_code()
            );
            wp_die();
        }

        wp_send_json( $response->body(), 200 );
        wp_die();
    }
    public function cf_razorpay_payment()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $camp_id = esc_html( $_POST['campId'] );
        $route = 'campaigns/' . $camp_id . '/credentials?method=razorpay';
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) {
            $message = $response->body() ? $response->body() : $response->message();
            wp_send_json_error(
                $message,
                $response->status_code()
            );
            wp_die();
        }

        wp_send_json( $response->body(), 200 );
        wp_die();
    }

    public function get_gateways($campaign)
    {
        $route = 'campaigns/' . $campaign['id'] . '/gateways';

        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return [];

        return $response->body();
    }

    private function get_settings_data($campaign)
    {
        $route = "campaigns/{$campaign['id']}/org-setting";
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return false;

        return $response->body();
    }

    public function get_organization_settings()
    {
        $organization = DBAccessor::getItem( 'organization' );
        if ( ! $organization ) return false;

        $route = "organization/" . $organization['id'] . "/campaign-page";
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return false;

        return $response->body();
    }

    public static function get_currency_format($organization_settings, $data, $price, $position = 'before')
    {
        if ( ! $organization_settings || empty( $organization_settings ) ) {
            return $data['currency_code'] . ' ' . $price;
        }

        if (
            isset( $organization_settings['currency_format'] )
            && isset( $organization_settings['currency_format']['show'] )
            && $organization_settings['currency_format']['show']
        ) {
            if ( $position == 'before' ) {
                return $data['currency_code'] . ' ' . $price;
            }
            return $price . ' ' . $data['currency_code'];
        }

        return $data['currency_symbol'] . $price;
    }

    public function cf_reminder()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $datas = json_decode( stripcslashes( $_POST['reminderForm'] ) );
        $main_data= array_flip(
            $dataStore = array_column( $datas, 'name', 'value' )
        );

        $res = Request::post(
            'donation-reminders',
            [
                'headers' => [
                    'authorization' => 'Bearer ' . DBAccessor::getItem('token')
                ],
                'body' => $main_data,
            ]
        );
        if ( $res->status_code() > 299 ) {
            $error = $res->body() ? $res->body() : $res->message();
            wp_send_json_error( $error, $res->status_code() );
            wp_die();
        }
        wp_send_json( $res->body(), 200 );
        wp_die();
    }

    public function cf_story_data()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $camp_slug = isset( $_POST['campSlug'] ) ? esc_html( $_POST['campSlug'] ) : null;
        $campaign = $this->get_single_campaign($camp_slug);
        $tab_data = SingleCampaignController::get_campaign_story_details($campaign['options']['story']);

        wp_send_json($tab_data, 200);
        wp_die();
    }

    public function similar_campaign($similar)
    {
        $route = "campaigns/" . $similar['slug'] . "/similar";
        
        $response = Request::get( $route );
        if ( $response->status_code() != 200 ) return [];
        
        // dump($response->body());
        return $response->body();
    }
}
