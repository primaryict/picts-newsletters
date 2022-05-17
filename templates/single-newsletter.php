<?php
/**
 * The Template for displaying all single posts.
 */

get_header();

$newsletter_url = get_post_meta( get_the_ID(), 'pictsnewsletter', true );

$ext = pathinfo($newsletter_url, PATHINFO_EXTENSION);

?>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php if($ext == "pdf") { ?>
        <iframe src="https://docs.google.com/viewerng/viewer?url=<?php echo $newsletter_url; ?>&embedded=true" style="width:100%; margin-bottom: 30px;" frameborder="0" class="newsletter-viewer"></iframe>
    <?php } else { ?>
        <img src="<?php echo $newsletter_url; ?>" style="width:100%; height: auto;" />
    <?php } ?>

    <style>

        .newsletter-viewer {
            height:700px;
        }

        /*// Medium devices (tablets, 768px and up)*/
        @media (min-width: 768px) {
            .newsletter-viewer {
                height:800px;
            }
        }

        /*// Large devices (desktops, 992px and up)*/
        @media (min-width: 992px) {
            .newsletter-viewer {
                height:1000px;
            }
        }

        /*// Extra large devices (large desktops, 1200px and up)*/
        @media (min-width: 1200px) {
            .newsletter-viewer {
                height:1200px;
            }
        }

    </style>

<?php
get_footer();
