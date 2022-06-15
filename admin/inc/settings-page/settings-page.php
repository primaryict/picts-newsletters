<?php
add_action( 'admin_menu', 'picts_newsletter_add_admin_menu',11 );
add_action( 'admin_init', 'picts_newsletter_init' );


function picts_newsletter_add_admin_menu(  ) {

    $pictsiconurl = PICTS_NEWSLETTERS_PLUGIN_DIR . 'assets/images/icon-darkmode.svg';

    if ( empty ( $GLOBALS['admin_page_hooks']['picts-theme'] ) ) {
        add_menu_page( 'Primary ICT Support - Setting Page', 'PICTS', 'manage_options', 'picts-plugin', 'picts_plugin_page', $pictsiconurl );
        add_submenu_page( 'picts-plugin', 'PICTS', 'Newsletters', 'manage_options', 'picts-newsletters', 'picts_newsletter_options_page' );
    
    } else {
        add_submenu_page( 'picts-theme', 'PICTS', 'Newsletters', 'manage_options', 'picts-newsletters', 'picts_newsletter_options_page' );
    }
}


function picts_newsletter_init(  ) {

    register_setting( 'newsletterpluginPage', 'picts_newsletter_settings' );

    add_settings_section(
        'picts_newsletterpluginPage_section',
        __( 'Your section description', 'picts' ),
        'picts_newsletter_settings_section_callback',
        'newsletterpluginPage'
    );

    add_settings_field(
        'picts_text_field_0',
        __( 'Settings field description', 'picts' ),
        'picts_newsletter_text_field_0_render',
        'newsletterpluginPage',
        'picts_newsletterpluginPage_section'
    );


}


function picts_newsletter_text_field_0_render(  ) {

    $options = get_option( 'picts_newsletter_settings' );
    ?>
    <input type='text' name='picts_newsletter_settings[picts_text_field_0]' value='<?php echo $options['picts_text_field_0']; ?>'>
    <?php

}


function picts_newsletter_settings_section_callback(  ) {

    echo __( 'This section description', 'picts' );

}



function picts_plugin_page(  ) {
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>
        <div class="picts-container-fluid">
            <div class="picts-settings-page-wrapper">
                <!-- Settings Page - Header -->
                <div class="picts-header">
                    <img class="theme-logo" src="<?php echo PICTS_NEWSLETTERS_PLUGIN_DIR; ?>/assets/images/primary_ict_full_logo_light.png" title="Primary ICT Support" />
                </div>

                <!-- Settings Page - Content -->
                <div class="picts-settings-page-content">

                    <nav class="nav-tab-wrapper">
                        <a href="?page=picts-plugin" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Information</a>
                        <!--<a href="?page=picts-plugin&tab=settings" class="nav-tab <?php //if($tab==='settings'):?>nav-tab-active<?php //endif; ?>">Settings</a>-->
                        <!--<a href="?page=picts-plugin&tab=tools" class="nav-tab <?php //if($tab==='tools'):?>nav-tab-active<?php //endif; ?>">Tools</a>-->
                    </nav>

                    <div class="tab-content">
                        <?php switch($tab) :
                            case 'settings':
                                echo display_setting_tab();; //Put your HTML here
                                break;
                            case 'tools':
                                echo display_tool_tab();;
                                break;
                            default:
                                echo display_default_tab();
                                break;
                        endswitch; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php

}

function display_default_tab() {

    $content = "
        <div class='row'>
            <div class='col-md-12'>
                <h1>Primary ICT Support - Information</h1>
                <p>Welcome to the Primary ICT Support information and support. Here you will find resources and help regarding your website and plugins used.</p>
                <p>Please use the menu on the left to get to the plugin page needed for more information on that specific plugin. We also have a YouTube tutorial link below that will get you some really nice tutorials on how to use WordPress but if you need more specific help please don't hesitate to <a href='https://www.primaryictsupport.co.uk/request-support/' title='Request Support' target='_blank'>Request Support using this link</a> or the link below.</p>
            </div>
            <div class='col-md-6'>
                <div class='sub-section'>
                    <h2 class='header'>Getting Help</h2>
                    <p>We have tried to make this theme as simple and user friendly as possible but we appreciate some things might be more difficult than others. Please select the help you need from the list below:<p>
                    <hr />
                    <h3 class='sub-header'>YouTube</h3>
                    <p>Our tutorials are a great way to learn how to use WordPress and should help solve most of your problems.</p>
                    <a class='button button-primary' href='#'>YouTube Tutorials</a>
                    
                    <h3 class='sub-header'>Primary ICT Support</h3>
                    <p>Being a Primary ICT Support customer we have range of ways to contact us via our Request Support page on our website.</p>
                    <a class='button button-primary' href='https://www.primaryictsupport.co.uk/request-support/'>Request Support</a>
                </div>
            </div>
        </div>
        
    ";
    return $content;
}


function picts_newsletter_options_page(  ) {
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>
    <div class="picts-container-fluid">
        <div class="picts-settings-page-wrapper">
            <!-- Settings Page - Header -->
            <div class="picts-header">
                <img class="theme-logo" src="<?php echo PICTS_NEWSLETTERS_PLUGIN_DIR; ?>/assets/images/primary_ict_full_logo_light.png" title="Primary ICT Support" />
            </div>

            <!-- Settings Page - Content -->
            <div class="picts-settings-page-content">

                <nav class="nav-tab-wrapper">
                    <a href="?page=picts-newsletters" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Information</a>
                    <a href="?page=picts-newsletters&tab=add" class="nav-tab <?php if($tab==='add'):?>nav-tab-active<?php endif; ?>">Add a Newsletter</a>
                    <a href="?page=picts-newsletters&tab=display" class="nav-tab <?php if($tab==='display'):?>nav-tab-active<?php endif; ?>">Newsletter Shortcodes</a>
<!--                    <a href="?page=picts-newsletters&tab=tools" class="nav-tab --><?php //if($tab==='tools'):?><!--nav-tab-active--><?php //endif; ?><!--">Tools</a>-->
                </nav>


                <div class="tab-content">
                    <?php switch($tab) :
                        case 'add':
                            echo news_display_add_tab();; //Put your HTML here
                            break;
                        case 'display':
                            echo news_display_display_tab();;
                            break;
                        default:
                            echo news_display_default_tab();
                            break;
                    endswitch; ?>
                </div>
            </div>
        </div>
    </div>

    <?php

}

function news_display_default_tab() {

    $content = "
        <div class='row'>
            <div class='col-md-12'>
                <h1>Primary ICT Support - Newsletter Plugin</h1>
                <p>Welcome to the Primary ICT Support Plugin information page for the newsletter plugin.</p>
            </div>
            <div class='col-md-6'>
                <div class='sub-section'>
                    <h2 class='header'>Using This Plugin</h2>
                    <p>Click here to view our help files</p>
                    <a class='button button-primary button-hero' href='?page=picts-newsletters&tab=add'>Add a Newsletter</a></li>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='sub-section'>
                    <h2 class='header'>Getting Help</h2>
                    <p>We have tried to make this theme as simple and user friendly as possible but we appreciate some things might be more difficult than others. Please select the help you need from the list below:<p>
                    <hr />
                    <h3 class='sub-header'>YouTube</h3>
                    <p>Our tutorials are a great way to learn how to use this plugin and WordPress and should help solve most of your problems.</p>
                    <a class='button button-primary' href='#'>YouTube Tutorials</a>
                    
                    <h3 class='sub-header'>Primary ICT Support</h3>
                    <p>Being a Primary ICT Support customer we have range of ways to contact us via our Request Support page on our website.</p>
                    <a class='button button-primary' href='https://www.primaryictsupport.co.uk/request-support/'>Request Support</a>
                    
                </div>
            </div>
        </div>
        
    ";
    return $content;
}

function news_display_add_tab() {

    $content = "
        <div class='row'>
            <div class='col-md-12'>
                <h1>Primary ICT Support - Newsletter Plugin</h1>
                <h2>Add Newsletters</h2>
                <p>We have a list of support information below.</p>
                <hr />
                <h3>How does this Plugin Work?</h3>
                <div class='d-flex align-items-center justify-content-evenly'>
                    <div class='col'>
                        <img class='help-image' src='". PICTS_NEWSLETTERS_PLUGIN_DIR."/admin/assets/images/admin-help-1.png' />
                    </div> 
                    <div class='col'>
                        <p>This plugin will create a custom post for Newsletters within WordPress automatically.</p>
                        <p>Clicking on 'Add New' will bring you to a input screen where you can add information about the newsletter.</p>
                    </div>
                </div>
                
                <hr />
                <h3>Adding a new Newsletter?</h3>
                <div class='d-flex align-items-center justify-content-evenly'>
                    <div class='col'>
                      <img class='help-image' src='". PICTS_NEWSLETTERS_PLUGIN_DIR."/admin/assets/images/admin-help-2.png' />
                    </div>
                    <div class='col'>

                        <p>On this input screen you will see some sections that you can fill in.</p>
                        <ul>
                            <li><strong>Title</strong> - Add a title to the newsletter e.g. Spring 2021 or 31st June 2021.</li>
                            <li><strong>Newsletter</strong> - this is the section you can upload your newsletters. Please use pdf or an image. Word documents will not be allowed. <a href='https://www.howtogeek.com/352668/how-to-convert-a-microsoft-word-document-to-a-pdf/' target='_blank' title='This link will open a new window'>Please convert your word document to a pdf or image</a>.</li>
                        </ul>
                    </div>
                </div>
                
                
            </div>
        </div>
         



    ";

    return $content;
}


// Function for dispaying the Display tab of the settings page

function news_display_display_tab() {

    $content = "
        <div class='row'>
            <div class='col-md-12'>
                <h1>Newsletter Shortcodes</h1>
                <p>Need to know how to show a list of Newsletters on your site. Use these handy shortcodes below.</p>
                <hr />
                <h3>Newsletter List Shortcode</h3>
                <p>Shortcodes are small blocks that represent code in the background and can display pieces of information wherever you add the shortcode.</p>
                <p><code>[picts_newsletters]</code> This code will display a default list of newsletters with the default settings applied )see table below).</p>
                <h4>Options</h4>
                <p>Shotcodes can have options within them which can alter how the information is displayed.</p>
                <p><code>[picts_newsletters numberofposts='20']</code> This will display the top 20 Newsletters in the list</p>
                <p><code>[picts_newsletters title='Our Newsletters' bgcolor='#000000' fontcolor='#ffffff' icon='fa-link']</code> This will display a black box with white heading 'Our Newsletters', links and a 'link' icon.</p>
                <h4>All Options </h4>
                <p>Below is a table with all the information of the options and what the default vaules are and how to get more information on making the newsletter plugin your own.</p>
                <table class='widefat'>
                <thead>
                    <tr><td>Setting name</td><td>Description</td><td>Default Value</td></tr>
                </thead>
                    <tr><td>numberofposts</td><td>How many newsletters to display</td><td>5</td></tr>
                    <tr><td>id</td><td>change the default ID so you can style the list yourself using custom CSS style</td><td>newsletterlist</td></tr>
                    <tr><td>bgcolor</td><td>The background colour of the container. <a href='https://g.co/kgs/GrShU9' target='_blank' title='Hex Colour Picker'>Example Hex colour picker here</a>. Please include the # symbol.</td><td>#efefef</td></tr>
                    <tr><td>title</td><td>What title do you want the containg box to have?</td><td>No title</td></tr>
                    <tr><td>fontcolor</td><td>Font colour for the header, links and icons in the list. <a href='https://g.co/kgs/GrShU9' target='_blank' title='Hex Colour Picker'>Example Hex colour picker here</a>. Please include the # symbol.</td><td>#333333</td></tr>
                    <tr><td>icon</td><td>What icon do you want on the list. Please use the prefix 'fa-' i.e. 'fa-link'. <a href='https://fontawesome.com/search?m=free&s=solid' title='Font Awesome Free Icons' target='_blank'>Please use the font awesome free list icons</a>.</td><td>No Icon</td></tr>
                </table>
                <h3>Custom Style</h3>
                <p>Using the default <a href='/wp-admin/customize.php'>WordPress Customiser</a> you're to add to the CSS for the site and if you add an 'id' option you can target the newsletter block and style it however you wish.</p>
                <p>Please use the inspector tool to find out more about the structure of the newsletters list.</p>
            </div>
        </div>
         



    ";

    return $content;
}




function news_admin_style() {
    wp_enqueue_style('picts-newsletter-admin-styles', PICTS_NEWSLETTERS_PLUGIN_DIR.'admin/assets/css/admin-style.css');

}
add_action('admin_enqueue_scripts', 'news_admin_style');
