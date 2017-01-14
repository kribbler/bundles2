<?php
// theme options
$__OPTIONS = array(
	'blogname' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' =>get_option('blogname'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => 'Site Title is used inside &lt;title&gt;&lt;/title&gt; tags and usually showed on the top of the browser',
        'label' => 'Site Title'
    ),
    'afl_logo' => array(
        'weight' => 0,
        'type' => 'text', //input text
        'default_value' => get_option('afl_logo'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => 'Select the logo image for your site. Note: when you select logo image "Logo text" is not shown',
        'label' => 'Logo image',
        'uploadable' => true
    ),
    'blogname_part1' => array(
        'weight' => 1,
        'type' => 'text',
        'label' => 'Logo text(first part)',
		'description' => 'The first part of Logo text. Shown if no Logo image selected',
        'default_value' => get_option('blogname_part1', get_option('blogname')),
    ),
	'blogname_part2' => array(
        'weight' => 1,
        'type' => 'text',
        'label' => 'Logo text(second part)',
		'description' => 'The second part of Logo text. Shown if no Logo image selected',
        'default_value' => get_option('blogname_part2', ''),
    ),
	'tagline' => array(
		'weight' => 0,
		'type' => 'text', //input text
		'default_value' => get_option('tagline'),
		'attributes' => array(
			'class' => 'regular-text'
		),
		'description' => 'Shown under the logo',
		'label' => 'Tagline'
	),
	'afl_phone' => array(
		'weight' => 0,
		'type' => 'text', //input text
		'default_value' => get_option('afl_phone'),
		'attributes' => array(
			'class' => 'regular-text'
		),
		'description' => 'You phone number which will be shown over search form in the header',
		'label' => 'Phone'
	),
    'afl_favicon' => array(
        'weight' => 2,
        'type' => 'text', //input text
        'default_value' => get_option('afl_favicon'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => '.ico file to be used as favicon for your site',
        'label' => 'Favicon',
        'uploadable' => true
    ),
    'default_comment_status' => array(
        'weight' => 3,
        'type' => 'checkbox',
        'default_value' => get_option('default_comment_status', 'open'),
		'description' => 'Enable or Disable commenting throughout your site',
        'label' => 'Comment on/off'
    ),
    'admin_email' => array(
        'weight' => 4,
        'type' => 'text',
        'default_value' => get_option('admin_email'),
        'attributes' => array(
            'class' => 'regular-text'
        ),
		'description' => 'Email address to be used for all the Contact Form letters',
        'label' => 'Admin email'
    ),
    'posts_per_page' => array(
        'weight' => 7,
        'type' => 'text',
        'default_value' => get_option('posts_per_page'),
        'attributes' => array(
            'class' => 'small-text'
        ),
		'description' => 'How many posts per page to show (blog, search, categories)?',
        'label' => 'Post per page'
    ),
    'afl_excerpt' => array(
        'weight' => 1,
        'type' => 'text',
		'description' => 'How long an Excerpt should be?',
        'label' => 'Excerpt',
        'default_value' => get_option('afl_excerpt','40'),
    ),
	'afl_readmore' => array(
		'weight' => 0,
		'type' => 'text', //input text
		'default_value' => get_option('afl_readmore'),
		'attributes' => array(
			'class' => 'regular-text'
		),
		'description' => 'Customize the Read More link',
		'label' => 'Readmore Text'
	),
    'afl_readmore_enable' => array(
        'weight' => 1,
        'type' => 'checkbox',
		'description' => 'Show Read More link?',
        'label' => 'Enable Readmore',
        'default_value' => get_option('afl_readmore_enable','open')
    ),
    'afl_social' => array(
        'weight' => 8,
        'type' => 'social',
		'description' => 'Select which page to display on your Frontpage. If left blank the Blog will be displayed',
        'label' => 'Social networks',
        'default_value' => get_option('afl_social')
    ),
    'afl_font' => array(
        'weight' => 10,
        'type' => 'font',
		'description' => 'Select which page to display on your Frontpage. If left blank the Blog will be displayed',
        'label' => 'Font replace',
        'default_value' => get_option('afl_font')
    ),
	'afl_counter_code' => array(
		'weight' => 5,
		'type' => 'footer',
		'default_value' => get_option('afl_counter_code'),
		'description' => 'Put here your counter code (e.g. Google Analytics or StatCounter)',
		'label' => 'Counter code'
	),
	'afl_footer_copyright' => array(
		'weight' => 6,
		'type' => 'footer',
		'default_value' => get_option('afl_footer_copyright'),
		'description' => 'Copyright text to display in the footer',
		'label' => 'Footer copyright'
	),
	'afl_footer' => array(
		'weight' => 10,
		'type' => 'footer',
		'description' => 'How many columns should be displayed in your footer',
		'label' => 'Footer Columns',
		'default_value' => get_option('afl_footer')
	)
);

include_once TEMPLATEPATH . '/lib/theme-options.php';;

?>
