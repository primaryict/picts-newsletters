<?php
add_action( 'admin_menu', 'picts_newsletter_add_admin_menu',11 );
add_action( 'admin_init', 'picts_newsletter_init' );


function picts_newsletter_add_admin_menu(  ) {

    add_submenu_page( 'picts-theme', 'PICTS', 'Newsletters', 'manage_options', 'picts-newsletters', 'picts_newsletter_options_page' );

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
                    <a class='button button-primary button-hero' href='?page=picts-newsletters&tab=help'>Help & Support</a></li>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='sub-section'>
                    <h2 class='header'>Getting Help</h2>
                    <p>We have tried to make this theme as simple and user friendly as possible but we appreciate some things might be more difficult than others. Please select the help you need from the list below:<p>
                    <hr />
                    <h3 class='sub-header'>YouTube</h3>
                    <p>Our tutorials are a great way to learn how to use the theme and WordPress and should help solve most of your problems.</p>
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

function news_display_help_tab() {

    $content = "
        <div class='row'>
            <div class='col-md-12'>
                <h1>Primary ICT Support - Newsletter Plugin</h1>
                <h2>Help & Support</h2>
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

//function news_display_tool_tab() {
//
//    $content = "
//
//    <p>Tool!</p>
//
//
//    ";
//    return $content;
//}


function picts_newsletter_options_page(  ) {
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>
    <div class="picts-container-fluid">
        <div class="picts-settings-page-wrapper">
            <!-- Settings Page - Header -->
            <div class="picts-header">
                <img class="theme-logo" src="<?php echo PICTS_THEME_DIR_URI; ?>/assets/images/primary_ict_full_logo_light.png" title="Primary ICT Support" />
            </div>

            <!-- Settings Page - Content -->
            <div class="picts-settings-page-content">

                <nav class="nav-tab-wrapper">
                    <a href="?page=picts-newsletters" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Information</a>
                    <a href="?page=picts-newsletters&tab=help" class="nav-tab <?php if($tab==='help'):?>nav-tab-active<?php endif; ?>">Help & Support</a>
<!--                    <a href="?page=picts-newsletters&tab=tools" class="nav-tab --><?php //if($tab==='tools'):?><!--nav-tab-active--><?php //endif; ?><!--">Tools</a>-->
                </nav>


                <div class="tab-content">
                    <?php switch($tab) :
                        case 'help':
                            echo news_display_help_tab();; //Put your HTML here
                            break;
                        case 'tools':
                            echo news_display_tool_tab();;
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

function news_admin_style() {
    wp_enqueue_style('picts-newsletter-admin-styles', PICTS_NEWSLETTERS_PLUGIN_DIR.'admin/assets/css/admin-style.css');

}
add_action('admin_enqueue_scripts', 'news_admin_style');
