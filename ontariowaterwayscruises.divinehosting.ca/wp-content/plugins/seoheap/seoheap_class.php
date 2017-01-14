<?php
abstract class seoheap {
	var $callbacks=array();
	function __construct() {

	}
	function archive($post_type,$location) {
		add_filter('archive_template',function($archive_template) use (&$post_type,&$location) {
			 global $post;
			 if (empty($archive_template) && is_post_type_archive($post_type) && file_exists($location . '/archive-'.$post_type.'.php')) {
				  $archive_template = $location . '/archive-'.$post_type.'.php';
			 }
			 return $archive_template;			
		}) ;
	}
	function metaboxes($meta) {
		$this->meta=$meta;
		foreach ($this->meta as $k=>&$a) {
			if (!isset($a['post_type']))
				$a['post_type']=array();
			if (!is_array($a['post_type']))
				$a['post_type']=array($a['post_type']);
			if (!isset($a['position']))
				$a['position']='advanced';
			if (!isset($a['label']))
				$a['label']=uc_words(str_replace('_',' ',$k));
		}
		add_action('add_meta_boxes',array($this,'add_meta_boxes'));
		add_action('save_post',array($this,'dosave'),1,2);		
	}
	function add_meta_boxes() {
		if (!empty($this->meta)) {
			foreach ($this->meta as $k=>$a) {
				if (empty($a['form']))
					continue;		
				$this->addmeta($k,$a['label'],$a['post_type'],$a['position']);
			}
		}
	}
	function dosave($post_id, $post) {
		if (empty($this->meta))
			return $post->ID;
		if (!current_user_can('edit_post',$post->ID))
			return $post->ID;
		$posttype=$post->post_type;
		$save=array();
		foreach ($this->meta as $k=>$a) {
			if (!isset($_POST[$k.'_meta_noncename']) || !wp_verify_nonce( $_POST[$k.'_meta_noncename'],plugin_basename(__FILE__).'__'.$k))
				continue;
			if (!in_array($posttype,$a['post_type']) || empty($a['form']))
				continue;
			foreach ($a['form'] as $kk=>$aa) {
				if (!isset($_POST[$k.'_'.$kk]))
					$save[$k.'_'.$kk]=NULL;
				else {
					if (empty($_POST[$k.'_'.$kk]))
						$save[$k.'_'.$kk]=NULL;
					elseif (is_array($_POST[$k.'_'.$kk]))
						$save[$k.'_'.$kk]=json_encode($_POST[$k.'_'.$kk]);	
					else
						$save[$k.'_'.$kk]=$_POST[$k.'_'.$kk];
				}
			}
		}
		if (!$save)
			return $post->ID;
		foreach ($save as $k=>$a) {
			$k='seoheap_'.$k;
			if (is_null($a))
				delete_post_meta($post->ID,$k);
			elseif (get_post_meta($post->ID,$k,false))
				update_post_meta($post->ID,$k,$a);
			else
				add_post_meta($post->ID, $k,$a);
		}
	}
	function __call($func,$args) {
		if (isset($this->callbacks[$func])) {
			return call_user_func_array($this->callbacks[$func],$args);
		}
	}
	function addmeta($name,$label,$posttype='post',$pos='advanced',$def='default') {
		if (empty($this->meta[$name]) || !is_array($this->meta[$name]))
			return;
		$class=&$this;
		if (!is_array($posttype))
			$posttype=array($posttype);
		$this->savemeta($name,$posttype);
		$this->callbacks['cbmeta_'.$name]=function() use (&$name,&$class,&$form) {
			$val=$class->metadata($name);
			$class->name=$name;
			echo '<input type="hidden" name="',htmlq($name),'_meta_noncename" id="',htmlq($name),'_meta_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__).'__'.$name) . '" />';
			foreach ($class->meta[$name]['form'] as $k=>$a) {
				$class->form($k,$a,$val);
			}
		};
		foreach ($posttype as $a) {
			add_meta_box('seoheap_'.$name,$label,array($this,'cbmeta_'.$name),$a,$pos,$def);
		}
	}
	function name($n) {
		$other='';
		if (strpos($n,'[')) {
			$n=explode('[',$n,2);
			$other='['.$n[1];
			$n=$n[0];	
		}
		return htmlq($this->name.'_'.$n.$other);
	}
	function metadata($name,$sub=false) {
		global $post;
		static $loaded=array();
		if ($sub===false) {
			if (isset($loaded[$name]))
				return $loaded[$name];
			$ret=new stdClass;
			if (empty($this->meta[$name]['form']))
				return $loaded[$name]=$ret;
			foreach ($this->meta[$name]['form'] as $k=>$a) {
				$ret->{$k}=get_post_meta($post->ID,'seoheap_'.$name.'_'.$k,true);
			}
			return $loaded[$name]=$ret;
		}
		$l=$this->metadata($name);
		if (isset($l->{$sub}))
			return $l->{$sub};
		return NULL;
	}
	function form($name,$data,$val) {
		$v=$val;
		if (is_object($val)) {
			if (isset($val->{$name}))
				$v=$val->{$name};
			else
				$v=NULL;	
		}
		if (is_string($data)) {
			$data=array('type'=>$data);	
		}
		if (!isset($data['label']))
			$data['label']=ucwords(str_replace('_',' ',$name));
		echo '<div id="formitem_',htmlq($name),'" class="formitem formitem_',htmlq($data['type']);
		if (!empty($data['help']))
			echo ' hashelp';
		echo '"';
		if (!empty($data['label']) && !empty($data['inline']))
			echo ' style="display:flex"';
		if (!empty($data['help']))
			echo ' title="',htmlq($data['help']),'"';
		echo '>';
		if (!empty($data['label']))
			echo '<div class="label">',html($data['label']),': </div>';
		if (!isset($data['placeholder']))
			$data['placeholder']=(isset($data['help']) ? $data['help'] : '');
		$name=$this->name($name);
		echo '<div class="item">';
		$this->{'form_'.$data['type']}($name,$v,$data);
		echo '</div>';
		echo '</div>';
	}
	function form_text($name,$val,$data) {
		echo '<input type="text" name="',$name,'" value="',htmlq($val),'" placeholder="',$data['placeholder'],'"/>';
	}
	function form_textarea($name,$val,$data) {
		echo '<textarea name="',$name,'" style="width:100%;height:100px" placeholder="',$data['placeholder'],'">',html($val),'</textarea>';
	}

}

class posts {
	static function get($args,$callback=false) {
		static $temp_cache=array();
		global $post;
		ksort($args);
		$hash=md5(json_encode($args));
		if (isset($temp_cache[$hash])) {
			if ($callback!==false) {
				foreach ($temp_cache[$hash] as $post) {
					$return=$callback($post);	
					if ($return===false)
						break;	
				}
			}
		} else {
			$temp_cache[$hash]=array();
			$p=new WP_Query($args);
			if ($p->have_posts()) {
				while ($p->have_posts()) {
					$p->the_post();
					if (isset($args['meta'])) {
						$post->meta=array();
						foreach ($args['meta'] as $meta_key=>$all) {
							$post->meta[$meta_key]=get_post_meta($post->ID,$meta_key,!!$all);
						}
					}
					$temp_cache[$hash][]=$post;
					if ($callback!==false) {
						$return=$callback($post);	
						if ($return===false)
							break;
					}
				}
			}
		}
		wp_reset_query();
		wp_reset_postdata();
		return $temp_cache[$hash];
	}
	static function title_list($args,$opts=array()) {
		if (!is_array($opts))
			$opts=(array)$opts;
		self::get($args,function($post) use (&$opts) {
			$opts[$post->ID]=$post->post_title;
		});
		return $opts;
	}
}

class view {
	protected $view=false;
	protected $plugin_directory=false;
	function __construct($plugin_directory,$view) {
		$this->template=get_template_directory();
		$this->plugin_directory=$plugin_directory;
		$this->view=$view;
	}
	function go($view=false) {
		if ($view===false)
			$view=$this->view;
		if (!$view) {
			throw new Exception('View not found');	
		}
		$plugin=dirname(__FILE__).'/../'.$this->plugin_directory.'/';
		if (file_exists($this->template.'/'.$this->plugin_directory.'/'.$view.'.php'))
			include $this->template.'/'.$this->plugin_directory.'/'.$view.'.php';
		elseif (file_exists($plugin.'/'.$view.'.php'))
			include $plugin.'/'.$view.'.php';
		elseif (file_exists($template.'/'.$this->plugin_directory.'/default.php'))
			include $template.'/'.$this->plugin_directory.'/default.php';
		elseif (file_exists($plugin.'/default.php'))
			include $plugin.'/default.php';
		else
			throw new Exception('View "'.$view.'" not found in "'.$this->plugin_directory.'"');
	}
	function fromArray($array) {
		if (!empty($array) && (is_array($array) || is_object($array))) {
			foreach ($array as $k=>$a) {
				if ($k=='view' || $k=='plugin_directory')
					continue;
				$this->{$k}=$a;
			}
		}
	}
	function content($view=false) {
		ob_start();
		$this->go($view);
		$return=ob_get_contents();
		ob_end_clean();
		return $return;
	}
}