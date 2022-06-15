<?php
/**
 * The Template for displaying all single posts.
 */

get_header();

$newsletter_url = get_post_meta( get_the_ID(), 'pictsnewsletter', true );

$ext = pathinfo($newsletter_url, PATHINFO_EXTENSION);

?>
<div id="body" class="">
    <div id="layout" class="pagewidth">
        <div id="content" class="">
            
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php if($ext == "pdf") { 
                
                echo do_shortcode('[picts_pdfviewer pdf="'. $newsletter_url .'"]');
                
             } else { // Add image if not a PDF ?>
                <img src="<?php echo $newsletter_url; ?>" style="width:100%; height: auto;" />
            <?php } ?>
        
        </div>
    </div>
</div>

<?php
get_footer();
