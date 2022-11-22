<div class="notice notice-success cf-notice">
    <div class="cf-notice-inner">
        <?php
        printf(
            "<p class='cf-content'>%s 
            <strong><a href='%s' target='_blank'>%s</a></strong>  
            %s <a href='%s' target='_blank'>%s</a>.</p>",
            __( 'Introducing', 'crowdfundly' ),
            esc_url( 'https://crowdfundly.com' ),
            __( 'Crowdfundly', 'crowdfundly' ),
            __( 'V3.0: A Digital Fundraising Software for Creators and Organizations. Read the', 'crowdfundly' ),
            esc_url( 'https://crowdfundly.com/blog/introducing-crowdfundly-v3-reveals-new-brand-identity-with-redesigned-logo-and-website/' ),
            __( 'full changelog here', 'crowdfundly' )
        );
        ?>

        <a
        id="cf-notice-intro-dismiss"
        title="<?php echo esc_attr__( 'Dismiss', 'crowdfundly' ); ?>"
        >
            <span class="dashicons dashicons-no-alt"></span>
        </a>
    </div>
</div>
