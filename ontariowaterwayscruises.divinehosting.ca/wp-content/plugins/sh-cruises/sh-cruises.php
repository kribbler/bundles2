<?php
/*
Plugin Name: Cruises
Plugin URI: http://www.seoheap.com/
Description: 
Author: James Cantrell
Version: 1.0.0
Author URI: http://www.seoheap.com/
*/
class cruises extends seoheap {
	var $fareterms_slug='fare-terms';
	var $tax=array(
		'HST'=>13,
	);
	var $aftercancel_tax=array(
		'RST'=>8
	);
	
	static function instance() {
		static $n=0;
		if (is_numeric($n)) {
			$n=new self();
		}
		return $n;
	}
	function price($p) {
		return '$'.str_replace('.00','',number_format($p,2));
	}
	function __construct() {
		add_action('init',array($this,'init'));
		add_filter('rwmb_meta_boxes',array($this,'rwmb_metaboxes'));
		add_filter('rwmb_meta_boxes',array($this,'rwmb_metaboxes_schedule'));
		add_filter('enter_title_here',array($this,'enter_title_here'));
		add_shortcode('schedule',array($this,'schedule_shortcode'));
		add_action('wp_ajax_schedule_ajax',array($this,'schedule_ajax'));
		add_action('wp_ajax_nopriv_schedule_ajax',array($this,'schedule_ajax'));
		add_action('wp_head',array($this,'ajaxurl'));
	}
	function ajaxurl() {
		echo '<script type="text/javascript">';
		echo 'var ajaxurl = ',json_encode(admin_url('admin-ajax.php')),';';
		echo '</script>';
	}
	function enter_title_here($title) {
		$screen = get_current_screen();
		if ($screen->post_type=='cruise-schedule'){
			$title='Enter Cruise Type';
		}
		return $title;		
	}
	function label($label,$contents) {
		echo '<div class="row labelcont">';
		echo '<div class="span6 label">',$label,'</div>';	
		echo '<div class="span6 value">',$contents,'</div>';
		echo '</div>';	
	}
	function init() {
		register_post_type('cruises',array(
			'labels' => array(
				'name' => __( 'Cruises' ),
				'singular_name' => __( 'cruises' )
			),
			'public' => true,
			'has_archive' =>false,
			'supports'=>array('title','editor','thumbnail'),
			'rewrite' => array( 'slug' => 'cruises', 'with_front'=> false ),
		));
		register_post_type('cruise-schedule',array(
			'labels' => array(
				'name' => __( 'Schedule' ),
				'singular_name' => __( 'schedule' )
			),
			'public' => true,
			'has_archive' =>false,
			'supports'=>array('title','editor')
		));
	}
	function rwmb_metaboxes_schedule($meta_boxes) {
		$prefix = 'cruise_schedule_';
		$meta_boxes[] = array(
			'id'       => 'dates',
			'title'    => 'Dates',
			'pages'    => array('cruise-schedule'),
			'context'  => 'side',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => 'Start',
					'id'    => $prefix . 'start',
					'type'  => 'date',
				),
				array(
					'name'  => 'End',
					'id'    => $prefix . 'end',
					'type'  => 'date',
				),
			)
		);
		$opts=array(0=>'None');
		$opts=posts::title_list(array(
			'post_type'=>'cruises',
			'posts_per_page'=>-1
		),$opts);

		$meta_boxes[] = array(
			'id'       => 'options',
			'title'    => 'Options',
			'pages'    => array('cruise-schedule'),
			'context'  => 'side',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => 'Cruise',
					'id'    => $prefix . 'cruise',
					'type'  => 'select',
					'options'=>$opts
				),
				array(
					'name'  => 'Fully Booked',
					'id'    => $prefix . 'booked',
					'type'  => 'select',
					'options'=>array(
						0=>'No',
						1=>'Yes'
					)
				)
			)
		);
		$meta_boxes[] = array(
			'id'       => 'spring-time-plus',
			'title'    => 'Spring Time Plus',
			'pages'    => array('cruise-schedule'),
			'context'  => 'advanced',
			'priority' => 'high',				
			'fields' => array(
				array(
					'name'  => 'Spring Time Plus',
					'id'    => $prefix . 'spring_time',
					'type'  => 'wysiwyg'
				)
			)
		);
		return $meta_boxes;	
	}
	function rwmb_metaboxes($meta_boxes) {
		$prefix = 'cruises_';
		// 1st meta box
		$meta_boxes[] = array(
			'id'       => 'fares',
			'title'    => 'Fares',
			'pages'    => array('cruises'),
			'context'  => 'side',
			'priority' => 'high',
			'fields' => array(
				array(
					'name'  => 'Price',
					'id'    => $prefix . 'fareprice',
					'type'  => 'number',
				),
				array(
					'name'  => 'Cancelation Fee',
					'id'    => $prefix . 'cancelation',
					'type'  => 'number',
				),
			)
		);
		// 2nd meta box
		$meta_boxes[] = array(
			'title'    => 'Departure & Return',
			'pages'    => array('cruises'),
			'fields' => array(
				array(
					'name' => 'Departure Title',
					'id'   => $prefix . 'departure_title',
					'type' => 'text',
				),
				array(
					'name' => 'Departure Body',
					'id'   => $prefix . 'departureandreturn', // left name as is because means loosing already inputed content
					'type' => 'wysiwyg',
				),
				array(
					'name' => 'Return Title',
					'id'   => $prefix . 'return_title',
					'type' => 'text',
				),
				array(
					'name' => 'Return Body',
					'id'   => $prefix . 'return_body',
					'type' => 'wysiwyg',
				)
			)
		);
		return $meta_boxes;		
	}
	function schedule_ajax() {
		echo $this->schedule_shortcode(allget());
		exit;
	}
	function schedule_shortcode($attrs) {
		$view=new view('sh-cruises','schedule');
		$view->fromArray($attrs);
		$view->year=isset($view->year) ? $view->year : false;
		$view->cruise=isset($view->cruise) ? $view->cruise : false;
		$view->items=$this->schedule($view->year,$view->cruise);
		$view->hasfullybooked=false;
		
		foreach ($view->items as $a) {
			if (!empty($a->meta['cruise_schedule_booked']))	{
				$view->hasfullybooked=true;
				break;
			}
		}
		return $view->content();
	}
	function schedule($year=false,$cruise=false) {
		if ($year===false) {
			$year=date('Y');
			if (date('m')>10) // out of season -show next year
				$year+=1;
		}
		$meta_query_args = array(
			'relation' => 'AND', // Optional, defaults to "AND"
			array(
				'key'     => 'cruise_schedule_start',
				'value'   => $year.'-',
				'compare' => 'LIKE'
			)
		);
		if ($cruise) {
			$meta_query_args[]=array(
				'key'     => 'cruise_schedule_cruise',
				'value'   => $cruise,
				'compare' => '='
			);
		}
		$args=array(
			'post_type'=>'cruise-schedule',
			'posts_per_page'=>-1,
			'meta'=>array(
				'cruise_schedule_start'=>true,
				'cruise_schedule_end'=>true,
				'cruise_schedule_cruise'=>true,
				'cruise_schedule_booked'=>true,
				'cruise_schedule_spring_time'=>true,
			),
			'meta_query'=>$meta_query_args
		);
		$list=posts::get($args);
		//printr($list);
		//return $list;
		// organise
		$sort=$sort2=array();
		foreach ($list as $k=>&$a) {
			$a->meta['cruise_schedule_start']=empty($a->meta['cruise_schedule_start']) ? false : $this->strtotime($a->meta['cruise_schedule_start']);
			$a->meta['cruise_schedule_end']=empty($a->meta['cruise_schedule_end']) ? false : $this->strtotime($a->meta['cruise_schedule_end']);
			if (!$a->meta['cruise_schedule_start'] && !$a->meta['cruise_schedule_end']) {
				$a->meta['friendly_date']='TBA';	
				$a->meta['month']=13;	// put at bottom
				$a->meta['month_name']='TBA';
				$a->meta['nights']='';
			} else {
				if (!$a->meta['cruise_schedule_end'])	
					$a->meta['cruise_schedule_end']=$a->meta['cruise_schedule_start'];
				if (!$a->meta['cruise_schedule_start'])	
					$a->meta['cruise_schedule_start']=$a->meta['cruise_schedule_end'];
				if ($a->meta['cruise_schedule_end']<$a->meta['cruise_schedule_start'])	
					list($a->meta['cruise_schedule_start'],$a->meta['cruise_schedule_end'])=array($a->meta['cruise_schedule_end'],$a->meta['cruise_schedule_start']);
				if (date('m',$a->meta['cruise_schedule_start'])==date('m',$a->meta['cruise_schedule_end'])) {
					if (date('d',$a->meta['cruise_schedule_start'])==date('d',$a->meta['cruise_schedule_end']))	
						$a->meta['friendly_date']=date('F jS',$a->meta['cruise_schedule_start']);
					else
						$a->meta['friendly_date']=date('F jS',$a->meta['cruise_schedule_start']).' - '.date('jS',$a->meta['cruise_schedule_end']);
				} else {
					$a->meta['friendly_date']=date('F jS',$a->meta['cruise_schedule_start']).' - '.date('F jS',$a->meta['cruise_schedule_end']);
				}
				if (date('Y',$a->meta['cruise_schedule_end'])>date('Y'))
					$a->meta['friendly_date'].=' '.date('Y',$a->meta['cruise_schedule_end']);
				$a->meta['month']=date('m',$a->meta['cruise_schedule_start']);	
				$a->meta['nights']=(($a->meta['cruise_schedule_end']-$a->meta['cruise_schedule_start'])/(24*60*60));
				if ($a->meta['nights']<1)
					$a->meta['nights']='N/A';
				$a->meta['month_name']=date('F',$a->meta['cruise_schedule_start']);
			}
			$sort[$k]=$a->meta['month'];
			$sort2[$k]=$a->meta['cruise_schedule_start'];
			
		}
		array_multisort($sort,SORT_ASC,$sort2,SORT_ASC,$list);
		return $list;
	}
	function strtotime($d) {
		if (!$d)
			return false;
		if (is_numeric($d))
			return $d;
		$nd=date_parse_from_format('Y-m-d',$d);	
		return mktime(12,0,0,$nd['month']-1,$nd['day'],$nd['year']);
	}
}

cruises::instance();