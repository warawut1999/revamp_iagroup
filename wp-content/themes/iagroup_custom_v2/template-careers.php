<?php
/* Template Name: Careers */
get_header(); ?>

<div class="elementor-container">
    <?php
    // This will allow Elementor to work properly on this template
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content(); // This function is required for Elementor to render the content
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
