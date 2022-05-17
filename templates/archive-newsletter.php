<?php
/**
 * The Template for displaying Archive pages.
 */

get_header();

if ( have_posts() ) :
    ?>
    <header class="page-header">
        <h1 class="page-title">Newsletters</h1>
    </header>
    <?php


    ?>
    <div class="row">
        <?php
        while ( have_posts() ) :
            the_post();

            /**
             * Include the Post-Format-specific template for the content.
             * If you want to overload this in a child theme then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part( 'content', 'index' ); // Post format: content-index.php
        endwhile;
        ?>
    </div>
<?php

else :
    // 404.
    get_template_part( 'content', 'none' );
endif;

wp_reset_postdata(); // End of the loop.

get_footer();
