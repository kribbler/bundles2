<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general_default',
        'title'       => 'General Settings'
      ),
      array(
        'id'          => 'typography',
        'title'       => 'Typography'
      ),
      array(
        'id'          => 'seo_settings',
        'title'       => 'SEO Settings'
      ),
      array(
        'id'          => 'theme_options',
        'title'       => 'Theme Options'
      ),
      array(
        'id'          => 'page_options',
        'title'       => 'Page Options'
      ),
      array(
        'id'          => 'social_media_options',
        'title'       => 'Social Media Options'
      ),
      array(
        'id'          => 'footer_options',
        'title'       => 'Footer Options'
      ),
      array(
        'id'          => 'blog_options',
        'title'       => 'Blog Options'
      ),
      array(
        'id'          => 'shop_options',
        'title'       => 'Shop Options'
      ),
      array(
        'id'          => 'header_background',
        'title'       => 'Header Background'
      )
    ),
    'settings'        => array(
      array(
        'id'          => 'theme_layouts',
        'label'       => 'Theme Layouts',
        'desc'        => 'Select one of theme layouts',
        'std'         => '1170',
        'type'        => 'select',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '1170',
            'label'       => '1170px wide (standard bootstrap system)',
            'src'         => ''
          ),
          array(
            'value'       => '940',
            'label'       => '940px wide (based on 960 grid system)',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'type_layouts',
        'label'       => 'Layouts Type',
        'desc'        => 'Select one of layouts type',
        'std'         => 'responsive',
        'type'        => 'select',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'responsive',
            'label'       => 'responsive',
            'src'         => ''
          ),
          array(
            'value'       => 'fixed',
            'label'       => 'fixed',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'meta_layouts',
        'label'       => 'Header Meta Layouts',
        'desc'        => 'Select layouts for header "Header Meta" container',
        'std'         => '75',
        'type'        => 'select',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '39',
            'label'       => '3/9 Columns',
            'src'         => ''
          ),
          array(
            'value'       => '48',
            'label'       => '4/8 Columns',
            'src'         => ''
          ),
          array(
            'value'       => '57',
            'label'       => '5/7 Columns',
            'src'         => ''
          ), 
          array(
            'value'       => '66',
            'label'       => '6/6 Columns',
            'src'         => ''
          ),
          array(
            'value'       => '75',
            'label'       => '7/5 Columns',
            'src'         => ''
          ),
          array(
            'value'       => '84',
            'label'       => '8/4 Columns',
            'src'         => ''
          ),
          array(
            'value'       => '93',
            'label'       => '9/3 Columns',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'left_headermeta',
        'label'       => 'Left Header Meta',
        'desc'        => 'Enter a value for left header meta or use shortcode for displaying jnewsticket.',
        'std'         => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        'type'        => 'text',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'right_headermeta',
        'label'       => 'Right Header Meta',
        'desc'        => 'Enter a value for right header meta.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'header_meta_c',
        'label'       => 'Header Meta',
        'desc'        => 'Disable for hiding "header meta" bar.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'wpml_switcher',
        'label'       => 'WPML Switcher',
        'desc'        => 'Enable for displaying "WordPress Multilingual" switcher.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Enable',
            'label'       => 'Enable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'wpml_switcher_label',
        'label'       => 'WPML Switcher Label',
        'desc'        => 'Disable "Languages:" label for "WordPress Multilingual" switcher.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'lm_headermeta',
        'label'       => 'Logout/My Account & Login/Register',
        'desc'        => 'Disable "Logout/My Account" "Login/Register" buttons in "Right Header Meta".',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      /*array(
        'id'          => 'wishlist_headermeta',
        'label'       => 'Wishlist',
        'desc'        => 'Enter full url of "Wishlist" page for displaying it in "Right Header Meta", the option is available only if "WooCommerce WishLists" plugin is activated.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),*/
      array(
        'id'          => 'compare_headermeta',
        'label'       => 'Comparison Page',
        'desc'        => 'Enter full url of "Comparison Page" for displaying it in "Right Header Meta", the option is available only if "WooCommerce Compare Products PRO" plugin is activated.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'custom_logo',
        'label'       => 'Custom Logo',
        'desc'        => 'Upload a logo for your theme.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'logo_tagline',
        'label'       => 'Logo Tagline',
        'desc'        => 'Enable for displaying logo tagline.',
        'std'         => 'Enable',
        'type'        => 'checkbox',
        'section'     => 'general_default',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Enable',
            'label'       => 'Enable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'custom_css',
        'label'       => 'Custom Css',
        'desc'        => 'Enter your custom css styles.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general_default',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'custom_js',
        'label'       => 'Custom Javascript',
        'desc'        => 'Enter your custom javascript.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general_default',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
       array(
        'id'          => 'body_font_size',
        'label'       => 'Body Font Size',
        'desc'        => 'Set body font size.',
        'std'         => '13',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '11',
            'label'       => '11',
            'src'         => ''
          ), 
          array(
            'value'       => '12',
            'label'       => '12',
            'src'         => ''
          ), 
          array(
            'value'       => '13',
            'label'       => '13',
            'src'         => ''
          ),
          array(
            'value'       => '14',
            'label'       => '14',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'body_font_family',
        'label'       => 'Body Font Family',
        'desc'        => 'Set body font family.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '',
            'label'       => '--- Google Webfonts ---',
            'src'         => ''
          ),
          array(
            'value'       => 'Open+Sans',
            'label'       => '"Open Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Titillium+Web',
            'label'       => '"Titillium Web", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oxygen',
            'label'       => '"Oxygen", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Quicksand',
            'label'       => '"Quicksand", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lato',
            'label'       => '"Lato", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Raleway',
            'label'       => '"Raleway", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Source+Sans+Pro',
            'label'       => '"Source Sans Pro", sans-serif',
            'src'         => ''
          ),
           array(
            'value'       => 'Dosis',
            'label'       => '"Dosis", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Exo',
            'label'       => '"Exo", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arvo',
            'label'       => '"Arvo", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Vollkorn',
            'label'       => '"Vollkorn", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Ubuntu',
            'label'       => '"Ubuntu", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Sans',
            'label'       => '"PT Sans", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Serif',
            'label'       => '"PT Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Droid+Sans',
            'label'       => '"Droid Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Droid+Serif',
            'label'       => '"Droid Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Cabin',
            'label'       => '"Cabin", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lora',
            'label'       => '"Lora", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oswald',
            'label'       => '"Oswald", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Varela+Round',
            'label'       => '"Varela Round", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '',
            'label'       => '--- System Fonts ---',
            'src'         => ''
          ),
          array(
            'value'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'label'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'label'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'label'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'label'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'label'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'label'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'label'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Times, "Times New Roman", Georgia, serif',
            'label'       => 'Times, "Times New Roman", Georgia, serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'label'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'label'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'body_2_font_family',
        'label'       => 'Body 2 Font Family',
        'desc'        => 'Set body 2 font family.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '',
            'label'       => '--- Google Webfonts ---',
            'src'         => ''
          ),
          array(
            'value'       => 'Open+Sans',
            'label'       => '"Open Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Titillium+Web',
            'label'       => '"Titillium Web", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oxygen',
            'label'       => '"Oxygen", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Quicksand',
            'label'       => '"Quicksand", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lato',
            'label'       => '"Lato", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Raleway',
            'label'       => '"Raleway", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Source+Sans+Pro',
            'label'       => '"Source Sans Pro", sans-serif',
            'src'         => ''
          ),
           array(
            'value'       => 'Dosis',
            'label'       => '"Dosis", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Exo',
            'label'       => '"Exo", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arvo',
            'label'       => '"Arvo", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Vollkorn',
            'label'       => '"Vollkorn", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Ubuntu',
            'label'       => '"Ubuntu", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Sans',
            'label'       => '"PT Sans", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Serif',
            'label'       => '"PT Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Droid+Sans',
            'label'       => '"Droid Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Droid+Serif',
            'label'       => '"Droid Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Cabin',
            'label'       => '"Cabin", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lora',
            'label'       => '"Lora", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oswald',
            'label'       => '"Oswald", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Varela+Round',
            'label'       => '"Varela Round", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '',
            'label'       => '--- System Fonts ---',
            'src'         => ''
          ),
          array(
            'value'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'label'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'label'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'label'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'label'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'label'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'label'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'label'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Times, "Times New Roman", Georgia, serif',
            'label'       => 'Times, "Times New Roman", Georgia, serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'label'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'label'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'elements_font_family',
        'label'       => 'Elements Font Family',
        'desc'        => 'Set font family for button and etc.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '',
            'label'       => '--- Google Webfonts ---',
            'src'         => ''
          ),
          array(
            'value'       => 'Open+Sans',
            'label'       => '"Open Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Titillium+Web',
            'label'       => '"Titillium Web", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oxygen',
            'label'       => '"Oxygen", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Quicksand',
            'label'       => '"Quicksand", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lato',
            'label'       => '"Lato", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Raleway',
            'label'       => '"Raleway", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Source+Sans+Pro',
            'label'       => '"Source Sans Pro", sans-serif',
            'src'         => ''
          ),
           array(
            'value'       => 'Dosis',
            'label'       => '"Dosis", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Exo',
            'label'       => '"Exo", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arvo',
            'label'       => '"Arvo", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Vollkorn',
            'label'       => '"Vollkorn", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Ubuntu',
            'label'       => '"Ubuntu", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Sans',
            'label'       => '"PT Sans", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Serif',
            'label'       => '"PT Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Droid+Sans',
            'label'       => '"Droid Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Droid+Serif',
            'label'       => '"Droid Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Cabin',
            'label'       => '"Cabin", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lora',
            'label'       => '"Lora", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oswald',
            'label'       => '"Oswald", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Varela+Round',
            'label'       => '"Varela Round", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '',
            'label'       => '--- System Fonts ---',
            'src'         => ''
          ),
          array(
            'value'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'label'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'label'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'label'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'label'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'label'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'label'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'label'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Times, "Times New Roman", Georgia, serif',
            'label'       => 'Times, "Times New Roman", Georgia, serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'label'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'label'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'navigation_font_family',
        'label'       => 'Navigation Font Family',
        'desc'        => 'Set navigation font family.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '',
            'label'       => '--- Google Webfonts ---',
            'src'         => ''
          ),
          array(
            'value'       => 'Open+Sans',
            'label'       => '"Open Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Titillium+Web',
            'label'       => '"Titillium Web", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oxygen',
            'label'       => '"Oxygen", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Quicksand',
            'label'       => '"Quicksand", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lato',
            'label'       => '"Lato", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Raleway',
            'label'       => '"Raleway", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Source+Sans+Pro',
            'label'       => '"Source Sans Pro", sans-serif',
            'src'         => ''
          ),
           array(
            'value'       => 'Dosis',
            'label'       => '"Dosis", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Exo',
            'label'       => '"Exo", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arvo',
            'label'       => '"Arvo", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Vollkorn',
            'label'       => '"Vollkorn", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Ubuntu',
            'label'       => '"Ubuntu", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Sans',
            'label'       => '"PT Sans", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Serif',
            'label'       => '"PT Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Droid+Sans',
            'label'       => '"Droid Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Droid+Serif',
            'label'       => '"Droid Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Cabin',
            'label'       => '"Cabin", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lora',
            'label'       => '"Lora", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oswald',
            'label'       => '"Oswald", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Varela+Round',
            'label'       => '"Varela Round", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '',
            'label'       => '--- System Fonts ---',
            'src'         => ''
          ),
          array(
            'value'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'label'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'label'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'label'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'label'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'label'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'label'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'label'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Times, "Times New Roman", Georgia, serif',
            'label'       => 'Times, "Times New Roman", Georgia, serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'label'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'label'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'input_font_family',
        'label'       => 'Input and Textarea Font Family',
        'desc'        => 'Set (input, textarea) font family.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '',
            'label'       => '--- Google Webfonts ---',
            'src'         => ''
          ),
          array(
            'value'       => 'Open+Sans',
            'label'       => '"Open Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Titillium+Web',
            'label'       => '"Titillium Web", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oxygen',
            'label'       => '"Oxygen", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Quicksand',
            'label'       => '"Quicksand", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lato',
            'label'       => '"Lato", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Raleway',
            'label'       => '"Raleway", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Source+Sans+Pro',
            'label'       => '"Source Sans Pro", sans-serif',
            'src'         => ''
          ),
           array(
            'value'       => 'Dosis',
            'label'       => '"Dosis", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Exo',
            'label'       => '"Exo", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arvo',
            'label'       => '"Arvo", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Vollkorn',
            'label'       => '"Vollkorn", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Ubuntu',
            'label'       => '"Ubuntu", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Sans',
            'label'       => '"PT Sans", sans-serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'PT+Serif',
            'label'       => '"PT Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Droid+Sans',
            'label'       => '"Droid Sans", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Droid+Serif',
            'label'       => '"Droid Serif", serif',
            'src'         => ''
          ), 
          array(
            'value'       => 'Cabin',
            'label'       => '"Cabin", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Lora',
            'label'       => '"Lora", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Oswald',
            'label'       => '"Oswald", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Varela+Round',
            'label'       => '"Varela Round", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '',
            'label'       => '--- System Fonts ---',
            'src'         => ''
          ),
          array(
            'value'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'label'       => '"Helvetica Neue", Helvetica, Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'label'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'label'       => 'Garamond, "Hoefler Text", Times New Roman, Times, serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'label'       => 'Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'label'       => '"Gill Sans", Calibri, "Trebuchet MS", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'label'       => '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'label'       => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'label'       => 'Tahoma, Geneva, Verdana, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Times, "Times New Roman", Georgia, serif',
            'label'       => 'Times, "Times New Roman", Georgia, serif',
            'src'         => ''
          ),
          array(
            'value'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'label'       => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
            'src'         => ''
          ),
          array(
            'value'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'label'       => 'Verdana, Tahoma, Geneva, sans-serif, sans-serif',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'input_font_size',
        'label'       => 'Input and Textarea Font Size',
        'desc'        => 'Set (input, textarea) font size.',
        'std'         => '12',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => '11',
            'label'       => '11',
            'src'         => ''
          ), 
          array(
            'value'       => '12',
            'label'       => '12',
            'src'         => ''
          ), 
          array(
            'value'       => '13',
            'label'       => '13',
            'src'         => ''
          ),
          array(
            'value'       => '14',
            'label'       => '14',
            'src'         => ''
          ),
          array(
            'value'       => '15',
            'label'       => '15',
            'src'         => ''
          ),
          array(
            'value'       => '16',
            'label'       => '16',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'navigation_font_size',
        'label'       => 'Navigation Font Size',
        'desc'        => 'Set navigation font size.',
        'std'         => '12',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '11',
            'label'       => '11',
            'src'         => ''
          ), 
          array(
            'value'       => '12',
            'label'       => '12',
            'src'         => ''
          ), 
          array(
            'value'       => '13',
            'label'       => '13',
            'src'         => ''
          ),
          array(
            'value'       => '14',
            'label'       => '14',
            'src'         => ''
          ),
          array(
            'value'       => '15',
            'label'       => '15',
            'src'         => ''
          ),
          array(
            'value'       => '16',
            'label'       => '16',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'navigation_font_style',
        'label'       => 'Navigation Font Weight',
        'desc'        => 'Set navigation font weight.',
        'std'         => 'bold',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'normal',
            'label'       => 'normal',
            'src'         => ''
          ),
          array(
            'value'       => 'bold',
            'label'       => 'bold',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'dropdown_font_size',
        'label'       => 'Navigation Dropdown Font Size',
        'desc'        => 'Set navigation dropdown font size.',
        'std'         => '13',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '11',
            'label'       => '11',
            'src'         => ''
          ), 
          array(
            'value'       => '12',
            'label'       => '12',
            'src'         => ''
          ), 
          array(
            'value'       => '13',
            'label'       => '13',
            'src'         => ''
          ),
          array(
            'value'       => '14',
            'label'       => '14',
            'src'         => ''
          ),
          array(
            'value'       => '15',
            'label'       => '15',
            'src'         => ''
          ),
          array(
            'value'       => '16',
            'label'       => '16',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'dropdown_font_style',
        'label'       => 'Navigation Dropdown Font Weight',
        'desc'        => 'Set navigation dropdown font weight.',
        'std'         => 'bold',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'normal',
            'label'       => 'normal',
            'src'         => ''
          ),
          array(
            'value'       => 'bold',
            'label'       => 'bold',
            'src'         => ''
          )
        ),
      ),
       array(
        'id'          => 'meta_font_size',
        'label'       => 'Meta Font Size',
        'desc'        => 'Set meta font size.',
        'std'         => '12',
        'type'        => 'select',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '11',
            'label'       => '11',
            'src'         => ''
          ), 
          array(
            'value'       => '12',
            'label'       => '12',
            'src'         => ''
          ), 
          array(
            'value'       => '13',
            'label'       => '13',
            'src'         => ''
          ),
          array(
            'value'       => '14',
            'label'       => '14',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'google_character_sets',
        'label'       => 'Google Webfont Character Sets',
        'desc'        => 'Choose the character sets you want.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'cyrillic-ext',
            'label'       => 'Cyrillic Extended (cyrillic-ext)',
            'src'         => ''
          ),
          array(
            'value'       => 'greek-ext',
            'label'       => 'Greek Extended',
            'src'         => ''
          ),
          array(
            'value'       => 'greek',
            'label'       => 'Greek',
            'src'         => ''
          ),
          array(
            'value'       => 'vietnamese',
            'label'       => 'Vietnamese',
            'src'         => ''
          ),
          array(
            'value'       => 'latin-ext',
            'label'       => 'Latin Extended',
            'src'         => ''
          ),
          array(
            'value'       => 'cyrillic',
            'label'       => 'Cyrillic',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'disable_seo',
        'label'       => 'Disable Theme SEO',
        'desc'        => 'If you are using an external SEO plug-in you should disable this option.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'seo_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'theme_title',
        'label'       => 'Browser Page Title',
        'desc'        => '%blog_title% - Will display name of your blog,
%blog_description% - Will blog description,
%page_title% - Will display current page title.',
        'std'         => '%blog_title%, %blog_description%, %page_title%',
        'type'        => 'textarea-simple',
        'section'     => 'seo_settings',
        'rows'        => '2',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'keywords',
        'label'       => 'Keywords',
        'desc'        => 'Enter a list of keywords separated by commas.',
        'std'         => 'keyword1, keywords2',
        'type'        => 'textarea-simple',
        'section'     => 'seo_settings',
        'rows'        => '2',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'description',
        'label'       => 'Description',
        'desc'        => 'Enter a description for your site.',
        'std'         => 'website description',
        'type'        => 'textarea-simple',
        'section'     => 'seo_settings',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'theme_style',
        'label'       => 'Theme Style',
        'desc'        => 'Select on of theme style.',
        'std'         => 'full-width',
        'type'        => 'select',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'boxed',
            'label'       => 'boxed',
            'src'         => ''
          ),
          array(
            'value'       => 'full',
            'label'       => 'full-width',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'theme_color',
        'label'       => 'Theme Color',
        'desc'        => 'Pick the color for link, buttons and etc.',
        'std'         => '#ea2e49',
        'type'        => 'colorpicker',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'theme_color_2',
        'label'       => 'Theme Color 2',
        'desc'        => 'Pick the color for minor "theme" elements.',
        'std'         => '#5c8ca7',
        'type'        => 'colorpicker',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'bg_pattern',
        'label'       => 'Pattern Background',
        'desc'        => 'Select one of pattern background for displaying it.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'none',
            'label'       => 'none',
            'src'         => ''
          ), 
          array(
            'value'       => 'pattern01',
            'label'       => 'pattern01',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern02',
            'label'       => 'pattern02',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern03',
            'label'       => 'pattern03',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern04',
            'label'       => 'pattern04',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern05',
            'label'       => 'pattern05',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern06',
            'label'       => 'pattern06',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern07',
            'label'       => 'pattern07',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern08',
            'label'       => 'pattern08',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern09',
            'label'       => 'pattern09',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern10',
            'label'       => 'pattern10',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern11',
            'label'       => 'pattern11',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern12',
            'label'       => 'pattern12',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern13',
            'label'       => 'pattern13',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern14',
            'label'       => 'pattern14',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern15',
            'label'       => 'pattern15',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern16',
            'label'       => 'pattern16',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern17',
            'label'       => 'pattern17',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern18',
            'label'       => 'pattern18',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern19',
            'label'       => 'pattern19',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern20',
            'label'       => 'pattern20',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern21',
            'label'       => 'pattern21',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern22',
            'label'       => 'pattern22',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern23',
            'label'       => 'pattern23',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern24',
            'label'       => 'pattern24',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern25',
            'label'       => 'pattern25',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern26',
            'label'       => 'pattern26',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern27',
            'label'       => 'pattern27',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern28',
            'label'       => 'pattern28',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern29',
            'label'       => 'pattern29',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern30',
            'label'       => 'pattern30',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern31',
            'label'       => 'pattern31',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern32',
            'label'       => 'pattern32',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern33',
            'label'       => 'pattern33',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern34',
            'label'       => 'pattern34',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern35',
            'label'       => 'pattern35',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern36',
            'label'       => 'pattern36',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern37',
            'label'       => 'pattern37',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern38',
            'label'       => 'pattern38',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern39',
            'label'       => 'pattern39',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern40',
            'label'       => 'pattern40',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern41',
            'label'       => 'pattern41',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern42',
            'label'       => 'pattern42',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern43',
            'label'       => 'pattern43',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern44',
            'label'       => 'pattern44',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern45',
            'label'       => 'pattern45',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern46',
            'label'       => 'pattern46',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern47',
            'label'       => 'pattern47',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern48',
            'label'       => 'pattern48',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern49',
            'label'       => 'pattern49',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern50',
            'label'       => 'pattern50',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern51',
            'label'       => 'pattern51',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern52',
            'label'       => 'pattern52',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern53',
            'label'       => 'pattern53',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern54',
            'label'       => 'pattern54',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern55',
            'label'       => 'pattern55',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern56',
            'label'       => 'pattern56',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern57',
            'label'       => 'pattern57',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern58',
            'label'       => 'pattern58',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern59',
            'label'       => 'pattern59',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern60',
            'label'       => 'pattern60',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern61',
            'label'       => 'pattern61',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern62',
            'label'       => 'pattern62',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern63',
            'label'       => 'pattern63',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern64',
            'label'       => 'pattern64',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern65',
            'label'       => 'pattern65',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern66',
            'label'       => 'pattern66',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern67',
            'label'       => 'pattern67',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern68',
            'label'       => 'pattern68',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern69',
            'label'       => 'pattern69',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern70',
            'label'       => 'pattern70',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern71',
            'label'       => 'pattern71',
            'src'         => ''
          ),
          array(
            'value'       => 'pattern72',
            'label'       => 'pattern72',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'bg_types',
        'label'       => 'Background Type',
        'desc'        => 'Select one of background type.',
        'std'         => 'one_color',
        'type'        => 'select',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'one_color',
            'label'       => 'one color',
            'src'         => ''
          ), 
          array(
            'value'       => 'horizontal',
            'label'       => 'gradient (horizontal reflected)',
            'src'         => ''
          ),
          array(
            'value'       => 'vertical',
            'label'       => 'gradient (vertical)',
            'src'         => ''
          ),
          array(
            'value'       => 'circular_top',
            'label'       => 'gradient (circular, top center)',
            'src'         => ''
          ),
          array(
            'value'       => 'circular_top_50',
            'label'       => 'gradient (circular, top center 50%)',
            'src'         => ''
          ),
          array(
            'value'       => 'ellipse_top',
            'label'       => 'gradient (ellipse, top center)',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'gradient_bg_color_1',
        'label'       => 'Gradient Background Color 1',
        'desc'        => 'Pick the color for gradient background, use this color picker for "one color" background type.',
        'std'         => '#ebebeb',
        'type'        => 'colorpicker',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'gradient_bg_color_2',
        'label'       => 'Gradient Background Color 2',
        'desc'        => 'Pick the second color for gradient background.',
        'std'         => '#ebebeb',
        'type'        => 'colorpicker',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'bg_custom_pattern',
        'label'       => 'Custom Pattern Background',
        'desc'        => 'Upload a pattern image for backgrond.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'bg_custom_img',
        'label'       => 'Custom Image Background',
        'desc'        => 'Upload an image for backgrond.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'favicon',
        'label'       => 'Favicon',
        'desc'        => 'Upload an .ico image (dimensions 16x16) for favicon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'iphone_icon',
        'label'       => 'Iphone Icon',
        'desc'        => 'Upload an .png image (dimensions 57x57) for touch icon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'ipad_icon',
        'label'       => 'Ipad Icon',
        'desc'        => 'Upload an .png image (dimensions 72x72) for touch icon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'iphone2_icon',
        'label'       => 'Iphone Icon Retina',
        'desc'        => 'Upload an .png image (dimensions 114x114) for touch icon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'ipad2_icon',
        'label'       => 'Ipad Icon Retina',
        'desc'        => 'Upload an .png image (dimensions 144x144) for touch icon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'theme_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'page_header_bg_types',
        'label'       => 'Page Header Type',
        'desc'        => 'Select one of page header type.',
        'std'         => 'one_color',
        'type'        => 'select',
        'section'     => 'page_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'one_color',
            'label'       => 'one color',
            'src'         => ''
          ), 
          array(
            'value'       => 'horizontal',
            'label'       => 'gradient (horizontal reflected)',
            'src'         => ''
          ),
          array(
            'value'       => 'vertical',
            'label'       => 'gradient (vertical)',
            'src'         => ''
          ),
          array(
            'value'       => 'circular_top',
            'label'       => 'gradient (circular, top center)',
            'src'         => ''
          ),
          array(
            'value'       => 'circular_top_50',
            'label'       => 'gradient (circular, top center 50%)',
            'src'         => ''
          ),
          array(
            'value'       => 'ellipse_top',
            'label'       => 'gradient (ellipse, top center)',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'page_gradient_bg_color_1',
        'label'       => 'Gradient Header Color 1',
        'desc'        => 'Pick the color for gradient header, use this color picker for one color background.',
        'std'         => '#cccccc',
        'type'        => 'colorpicker',
        'section'     => 'page_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'page_gradient_bg_color_2',
        'label'       => 'Gradient Header Color 2',
        'desc'        => 'Pick the color for gradient header, use this color picker for one color background.',
        'std'         => '#acacac',
        'type'        => 'colorpicker',
        'section'     => 'page_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => '500px',
        'label'       => '500px',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'about_me',
        'label'       => 'About Me',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'add_this',
        'label'       => 'Add This',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'amazon',
        'label'       => 'Amazon',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'aol',
        'label'       => 'Aol',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'app_store_alt',
        'label'       => 'App Store Alt',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'app_store',
        'label'       => 'App Store',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'apple',
        'label'       => 'Apple',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'bebo',
        'label'       => 'Bebo',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'behance',
        'label'       => 'Behance',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'bing',
        'label'       => 'Bing',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blip',
        'label'       => 'Blip',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blogger',
        'label'       => 'Blogger',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'coroflot',
        'label'       => 'Coroflot',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'daytum',
        'label'       => 'Daytum',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'delicious',
        'label'       => 'Delicious',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'design_bump',
        'label'       => 'Design Bump',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'designfloat',
        'label'       => 'Designfloat',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'deviant_art',
        'label'       => 'Deviant Art',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'digg_alt',
        'label'       => 'Digg Alt',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'digg',
        'label'       => 'Digg',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'dribbble',
        'label'       => 'Dribbble',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'drupal',
        'label'       => 'Drupal',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'ebay',
        'label'       => 'Ebay',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'email',
        'label'       => 'Email',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'ember_app',
        'label'       => 'Ember App',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'etsy',
        'label'       => 'Etsy',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'facebook',
        'label'       => 'Facebook',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'flickr',
        'label'       => 'Flickr',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'foodspotting',
        'label'       => 'Foodspotting',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'forrst',
        'label'       => 'Forrst',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'foursquare',
        'label'       => 'Foursquare',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'friendsfeed',
        'label'       => 'Friendsfeed',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'friendstar',
        'label'       => 'Friendstar',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'gdgt',
        'label'       => 'Gdgt',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'github',
        'label'       => 'Github',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'google_buzz',
        'label'       => 'Google Buzz',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'google_talk',
        'label'       => 'Google Talk',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'gowalla_pin',
        'label'       => 'Gowalla Pin',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'gowalla',
        'label'       => 'Gowalla',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'grooveshark',
        'label'       => 'Grooveshark',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'heart',
        'label'       => 'Heart',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'hyves',
        'label'       => 'Hyves',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'icondock',
        'label'       => 'Icondock',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'icq',
        'label'       => 'Icq',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'identica',
        'label'       => 'Identica',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'imessage',
        'label'       => 'Imessage',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'itune',
        'label'       => 'Itune',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'last_fm',
        'label'       => 'Last.fm',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'linkedin',
        'label'       => 'Linkedin',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'meetup',
        'label'       => 'Meetup',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'metacafe',
        'label'       => 'Metacafe',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'mixx',
        'label'       => 'Mixx',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'mobileme',
        'label'       => 'Mobileme',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'mr_wong',
        'label'       => 'Mr Wong',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'msn',
        'label'       => 'Msn',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'myspace',
        'label'       => 'Myspace',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'newsvine',
        'label'       => 'Newsvine',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'paypal',
        'label'       => 'Paypal',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'photobucket',
        'label'       => 'Photobucket',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'picasa',
        'label'       => 'Picasa',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'pinterest',
        'label'       => 'Pinterest',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'podcast',
        'label'       => 'Podcast',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'posterous',
        'label'       => 'Posterous',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'qik',
        'label'       => 'Qik',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'quora',
        'label'       => 'Quora',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'reddit',
        'label'       => 'Reddit',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'retweet',
        'label'       => 'Retweet',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'rss',
        'label'       => 'Rss',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'scribd',
        'label'       => 'Scribd',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'share_this',
        'label'       => 'Share This',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'skype',
        'label'       => 'Skype',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'slashdot',
        'label'       => 'Slashdot',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'slideshare',
        'label'       => 'Slideshare',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'smugmug',
        'label'       => 'Smugmug',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'sound_cloud',
        'label'       => 'Sound Cloud',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'spotify',
        'label'       => 'Spotify',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'squidoo',
        'label'       => 'Squidoo',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'stackoverflow',
        'label'       => 'Stackoverflow',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'stumbleupon',
        'label'       => 'Stumbleupon',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'technorati',
        'label'       => 'Technorati',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tumblr',
        'label'       => 'Tumblr',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'twitter_bird',
        'label'       => 'Twitter_bird',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'twitter',
        'label'       => 'Twitter',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'viddler',
        'label'       => 'Viddler',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vimeo',
        'label'       => 'Vimeo',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'virb',
        'label'       => 'Virb',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'w3',
        'label'       => 'w3',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'wikipedia',
        'label'       => 'Wikipedia',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'windows',
        'label'       => 'Windows',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'wordpress',
        'label'       => 'Wordpress',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'xing',
        'label'       => 'Xing',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'yahoo_buzz',
        'label'       => 'Yahoo Buzz',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'yahoo',
        'label'       => 'Yahoo',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'yelp',
        'label'       => 'Yelp',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'youtube',
        'label'       => 'Youtube',
        'desc'        => 'Input the full URL you\'d like the button to link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_media_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_search',
        'label'       => 'Footer Search Form',
        'desc'        => 'Select one search form type',
        'std'         => 'theme_search',
        'type'        => 'select',
        'section'     => 'footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'shop_search',
            'label'       => 'Shop search',
            'src'         => ''
          ),
          array(
            'value'       => 'theme_search',
            'label'       => 'Theme search',
            'src'         => ''
          ),
          array(
            'value'       => 'none',
            'label'       => 'None',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'ccard',
        'label'       => 'Credit Cards',
        'desc'        => 'Select your payment methods.',
        'std'         => '#',
        'type'        => 'checkbox',
        'section'     => 'footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'amazon',
            'label'       => 'Amazon',
            'src'         => ''
          ),
          array(
            'value'       => 'amex_alt',
            'label'       => 'Amex Alt',
            'src'         => ''
          ),
          array(
            'value'       => 'amex_gold',
            'label'       => 'Amex Gold',
            'src'         => ''
          ),
          array(
            'value'       => 'amex_green',
            'label'       => 'Amex Green',
            'src'         => ''
          ),
          array(
            'value'       => 'amex_silver',
            'label'       => 'Amex Silver',
            'src'         => ''
          ),
           array(
            'value'       => 'amex',
            'label'       => 'Amex',
            'src'         => ''
          ),
           array(
            'value'       => 'apple',
            'label'       => 'Apple',
            'src'         => ''
          ),
           array(
            'value'       => 'bank',
            'label'       => 'Bank',
            'src'         => ''
          ),
          array(
            'value'       => 'cash',
            'label'       => 'Cash',
            'src'         => ''
          ),
           array(
            'value'       => 'chase',
            'label'       => 'Chase',
            'src'         => ''
          ),
           array(
            'value'       => 'coupon',
            'label'       => 'Coupon',
            'src'         => ''
          ),
           array(
            'value'       => 'credit',
            'label'       => 'Credit',
            'src'         => ''
          ),
          array(
            'value'       => 'debit',
            'label'       => 'Debit',
            'src'         => ''
          ),
           array(
            'value'       => 'discover_alt',
            'label'       => 'Discover Alt',
            'src'         => ''
          ),
           array(
            'value'       => 'discover_novus',
            'label'       => 'Discover Novus',
            'src'         => ''
          ),
           array(
            'value'       => 'discover',
            'label'       => 'Discover',
            'src'         => ''
          ),
           array(
            'value'       => 'echeck',
            'label'       => 'Echeck',
            'src'         => ''
          ),
           array(
            'value'       => 'generic_1',
            'label'       => 'Generic 1',
            'src'         => ''
          ),
           array(
            'value'       => 'generic_2',
            'label'       => 'Generic 2',
            'src'         => ''
          ),
           array(
            'value'       => 'generic_3',
            'label'       => 'Generic 3',
            'src'         => ''
          ),
           array(
            'value'       => 'gift_alt',
            'label'       => 'Gift Alt',
            'src'         => ''
          ),
           array(
            'value'       => 'gift',
            'label'       => 'Gift',
            'src'         => ''
          ),
           array(
            'value'       => 'gold',
            'label'       => 'Gold',
            'src'         => ''
          ),
           array(
            'value'       => 'googleckout',
            'label'       => 'Googleckout',
            'src'         => ''
          ),
           array(
            'value'       => 'itunes_2',
            'label'       => 'Itunes 2',
            'src'         => ''
          ),
           array(
            'value'       => 'itunes_3',
            'label'       => 'Itunes 3',
            'src'         => ''
          ),
           array(
            'value'       => 'itunes',
            'label'       => 'Itunes',
            'src'         => ''
          ),
           array(
            'value'       => 'mastercard_alt',
            'label'       => 'Mastercard Alt',
            'src'         => ''
          ),
           array(
            'value'       => 'mastercard',
            'label'       => 'Mastercard',
            'src'         => ''
          ),
           array(
            'value'       => 'mileage',
            'label'       => 'Mileage',
            'src'         => ''
          ),
           array(
            'value'       => 'paypal',
            'label'       => 'Paypal',
            'src'         => ''
          ),
           array(
            'value'       => 'sapphire',
            'label'       => 'Sapphire',
            'src'         => ''
          ),
           array(
            'value'       => 'solo',
            'label'       => 'Solo',
            'src'         => ''
          ),
           array(
            'value'       => 'visa_alt',
            'label'       => 'Visa Alt',
            'src'         => ''
          ),
           array(
            'value'       => 'visa',
            'label'       => 'Visa',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'footer_copyright',
        'label'       => 'Footer Copyright Text',
        'desc'        => 'Enter the copyright text you\'d like to show in the footer of your site.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'footer_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog_post_share',
        'label'       => 'Blog Post Share Buttons',
        'desc'        => '',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'blog-tagline-title',
        'label'       => 'Blog Tagline Title',
        'desc'        => 'Tagline title.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog-tagline-description',
        'label'       => 'Blog Tagline Description',
        'desc'        => 'Tagline description, use "&#60;br&gt;" html tag for separation lines.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog-header-image',
        'label'       => 'Blog Header Background Image',
        'desc'        => 'Upload an image for blog header.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog_left_sidebar',
        'label'       => 'Left Sidebar',
        'desc'        => '',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enable',
            'label'       => 'Enable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'filter_change_animation',
        'label'       => 'filterChangeAnimation',
        'desc'        => 'This Option defines which Transition is used if the Entries disappearing or appearing after a filter has been activated.',
        'std'         => 'scale',
        'type'        => 'select',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'fade',
            'label'       => 'fade',
            'src'         => ''
          ),
          array(
            'value'       => 'rotate',
            'label'       => 'rotate',
            'src'         => ''
          ),
          array(
            'value'       => 'scale',
            'label'       => 'scale',
            'src'         => ''
          ),
          array(
            'value'       => 'rotatescale',
            'label'       => 'rotatescale',
            'src'         => ''
          ),
          array(
            'value'       => 'pagetop',
            'label'       => 'pagetop',
            'src'         => ''
          ),
          array(
            'value'       => 'pagebottom',
            'label'       => 'pagebottom',
            'src'         => ''
          ),
          array(
            'value'       => 'pagemiddle',
            'label'       => 'pagemiddle',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'filter-change-speed',
        'label'       => 'filterChangeSpeed',
        'desc'        => 'Defines the speed of the Transition set via the filterChangeAnimation option. Values should be between 300 - 1500 (0.3sec till 1.5 Sec).',
        'std'         => '400',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'filter-change-rotate',
        'label'       => 'filterChangeRotate',
        'desc'        => 'Defines the rotating degree of the Entries by Transition. Used only at rotate and rotatescale transitions. Possible values are -720  till 720.  99= Random Rotating.',
        'std'         => '99',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'filter-change-scale',
        'label'       => 'filterChangeScale',
        'desc'        => 'Defines the scaling of Entries by Transition. Used only at scale and rotatescale. Values are from 0-2. i.e. 0.6 will 60% decrease the Entry at disappearing.',
        'std'         => '0.6',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'delay',
        'label'       => 'delay',
        'desc'        => 'Defines the dealying between two Entries transition. If this set to 0 than all entrypoint animated at the same time. i.e. 20 0.2 Sec will be delayed between each transition.',
        'std'         => '20',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'padding-horizontal',
        'label'       => 'paddingHorizontal',
        'desc'        => 'The space between the Entries Horizontal (value is in px)',
        'std'         => '15',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'padding-vertical',
        'label'       => 'paddingVertical',
        'desc'        => 'The space between the Entries Vertical (value is in px)',
        'std'         => '15',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'layout-array',
        'label'       => 'layoutarray',
        'desc'        => 'Defines the Grid, Grids used in the Gallery. This can be a single Value, or even more values.',
        'std'         => '3',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'layout-array-textblock',
        'label'       => 'layoutarray',
        'desc'        => 'The Gallery Grid types are <ol><li>2-9 (Special Grids),  2 = 2 Entry  3 = 3 Entry etc.. See Grid Types later ! </li><li>11,12,13,14 (for Square Grids. 11=3 in the Row, 12= 4 in the Row, 13=5 in the Row, 14=6 in the Row)</li><li>15,16,17,18 (Different Heights per Column. Height of Entries defined in data-height per Entry) will be taken.  15= 3 in the Row, 16 = 4 in the Row etc...</li><li>0 = Random Grid Types</li></ol>The layoutarray is an array where you define i.e. an array like [5,3,13]  which means, the first 5 item will be arranged in "Grid Type 5", the next 3 item will be arranged in "Grid Type 3" the next 5 item will be arranged in "Grid Type 15". If you have more entries here, then the Array will be looped and the Gallery form starts from the first Defined Grid Type again. You can not Mix types from 15,16,17,18 with any other types !!<br /><br />Some Possibilities: [0,5,0,5,0,5]  or [ 9,6,3,6,0,4,13]  but you can not mix like [16,2,...] since the Grid Types above 15 are different Height Grids, which is logically not mixable with other grids. ',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog_number_of_post',
        'label'       => 'Number of Posts',
        'desc'        => 'Enter a number of posts for custom blog templates, the option is available only for "Blog Temlplate (full-width)", "Front Temlplate (blog)" and "Front Temlplate (blog, sidebar)".',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'blog_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 's_cart',
        'label'       => 'Shopping Cart',
        'desc'        => 'Check for disabling shopping cart.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 's_rating',
        'label'       => 'Rating',
        'desc'        => 'Check for disabling rating stars on front pages.',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'Disable',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'loop_shop_per_page',
        'label'       => 'Number of Products',
        'desc'        => 'Number of products to display on shop page.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'shop_columns',
        'label'       => 'Number of Columns',
        'desc'        => 'Select number of columns for shop page.',
        'std'         => '4',
        'type'        => 'select',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '2',
            'label'       => '2',
            'src'         => ''
          ),
          array(
            'value'       => '3',
            'label'       => '3',
            'src'         => ''
          ),
          array(
            'value'       => '4',
            'label'       => '4',
            'src'         => ''
          ),
          array(
            'value'       => '6',
            'label'       => '6',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'product_style',
        'label'       => 'Product Page Sidebar',
        'desc'        => 'Select one of sidebar side for product (taxonomy).',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right_sidebar',
            'label'       => 'right sidebar',
            'src'         => ''
          ),
          array(
            'value'       => 'left_sidebar',
            'label'       => 'left sidebar',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'product_post_style',
        'label'       => 'Product Post Sidebar',
        'desc'        => 'Select one of sidebar side for product post.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right_sidebar',
            'label'       => 'right sidebar',
            'src'         => ''
          ),
          array(
            'value'       => 'left_sidebar',
            'label'       => 'left sidebar',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'sale_flash_color1',
        'label'       => 'Sale Flash Element (gradient color 1)',
        'desc'        => 'Pick the color 1 for sale flash element.',
        'std'         => '#897964',
        'type'        => 'colorpicker',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'sale_flash_color2',
        'label'       => 'Sale Flash Element (gradient color 2)',
        'desc'        => 'Pick the color 2 for sale flash element.',
        'std'         => '#897964',
        'type'        => 'colorpicker',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'shop_search_header_image',
        'label'       => 'Shop Search Header Background Image',
        'desc'        => 'Upload an image for shop search header.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'shop_search_image',
        'label'       => 'Shop Search Page Image',
        'desc'        => 'Upload an image for shop search page.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'shop_tag_header_image',
        'label'       => 'Shop Tag Header Background Image',
        'desc'        => 'Upload an image for shop tag header.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'shop_tag_image',
        'label'       => 'Shop Tag Page Image',
        'desc'        => 'Upload an image for shop search page.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'shop_category_header_image',
        'label'       => 'Shop Category Header Background Image',
        'desc'        => 'Upload an image for shop category header.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'shop_options',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      
      
            
      array(
        'id'          => 'tax_category_header_image',
        'label'       => 'Category Header Background Image',
        'desc'        => 'Upload an image for category header (taxonomy:category).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_background',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tax_post_tag_header_image',
        'label'       => 'Tags Header Background Image',
        'desc'        => 'Upload an image for tags header (taxonomy:post_tag).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_background',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'archive_header_image',
        'label'       => 'Archive Header Background Image',
        'desc'        => 'Upload an image for archive header.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_background',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'search_header_image',
        'label'       => 'Search Header Background Image',
        'desc'        => 'Upload an image for search header.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_background',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tax_portfolio_category_header_image',
        'label'       => 'Portfolio Category Header Background Image',
        'desc'        => 'Upload an image for portfolio category header (taxonomy:portfolio_category).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_background',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tax_portfolio_tags_header_image',
        'label'       => 'Portfolio Tags Header Background Image',
        'desc'        => 'Upload an image for portfolio tags header (taxonomy:portfolio_tags).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header_background',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}