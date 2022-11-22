<?php
/**
 * Template Name: Crowdfundly Template
 * Description: Template for Crowdfundly pages
 *
 * @package    crowdfundly
 */
get_header();
global $post;
?>

<div class="crowdfundly-frontend-wrapper crowdfundly-page-id-<?php echo esc_attr( $post->ID ); ?>">
    <div class="crowdfundly-content-wrapper">

		<?php
        if ( have_posts() ) :
            while ( have_posts() ) { the_post();
                the_content();
            }
        else : ?>
            <p>
                <?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'crowdfundly' ); ?>
            </p>
            <?php
            get_search_form();
        endif;
        ?>

    </div>
</div>

<?php get_footer(); ?>
