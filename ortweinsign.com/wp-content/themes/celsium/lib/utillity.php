<?php

function afl_do_shortcode( $content ){
    return do_shortcode( $content );
}

function afl_container_wrap( $atts, $content ){
	if(!isset($atts['custom_class'])) $atts['custom_class'] = '';
	return '<div class="container '.$atts['custom_class'].'"><div class="row-fluid">'.afl_do_shortcode($content).'</div></div>';
}

function afl_to_shortcode($sc_array){
    $out = '';
    if(count($sc_array)==0)return;
    foreach ($sc_array as $sc){
        $type = $sc['type'];
        $out .= "$sc[prefix][$sc[type]";
        $data = $sc['data'];
        switch($sc['type']){
             case 'flex-slider':
                if (isset($data["$sc[type]_images"])){
                    $images = $data["$sc[type]_images"];
                    unset($data["$sc[type]_images"]);
                }
                $data["$sc[type]_navigation"] = (!empty($data["$sc[type]_navigation"])?'true':'false');
                $data["$sc[type]_links"] = (!empty($data["$sc[type]_links"])?'true':'false');
                $data["$sc[type]_hoverPause"] = (!empty($data["$sc[type]_hoverPause"])?'true':'false');
                
                $out .= ' '.afl_render_shortcode_attributes($sc['type'], $data).']';
                if(count($images)>0){
					$out .= '<ul class="slides">';
                    foreach($images as $image){
                        $out .= '<li><img src="'.esc_attr($image['url']).'" alt=""/>'.$image['title'].'</li>';
                    }
					$out .= '</ul>';
                }
                else{
                    $out .= ' ';
                }
                break;
            case 'text_slider':
				if(!empty($data['content_types'])) {
                	$out .= ' content_count="'.$data['content_count'].'" content_types="'.$data['content_types'].'"] ';
				} else {
					$out .= '] ';
					if(!empty($data[$type])){
						foreach($data[$type] as $slide){
							if(isset($slide['content'])){
								$content = $slide['content'];
								unset($slide['content']);
							}
							$out .= ' [text_slide '.afl_render_shortcode_attributes($type,$slide).'] '.$content.' [/text_slide] ';
						}
					}
				}
                break;
            case 'full_width':
			case 'advanced_recent_projects':
            case 'advanced_recent_posts':
                $content = $data["$sc[type]_content"];    
                if(isset($data["$sc[type]_content"])){
                    unset($data["$sc[type]_content"]);
                }
                $out .= ' '.afl_render_shortcode_attributes($sc['type'], $data).'] '.$content;
                break;
            case 'slogan':
                $content = $data["$sc[type]_text"];
                unset($data["$sc[type]_text"]);
                $out .= ' '.afl_render_shortcode_attributes($sc['type'], $data).'] '.$content;
                break;
			case 'post_slider':
                $out .= ' '.afl_render_shortcode_attributes($sc['type'], $data).'] ';
                break;
			case 'divider':
                $out .= ' '.afl_render_shortcode_attributes($sc['type'], $data).'] ';
                break;
			case 'recent_projects':
			case 'recent_posts':
                $out .= ' '.afl_render_shortcode_attributes($sc['type'], $data).'] ';
                break;
            case '2_columns':
                $out .= '] ';
                for ($i = 0;$i<2;$i++){
                    $out .= '[2_column';
					if ($i == 0) $out .= ' order ="first"'; else if ($i == 1) $out .= ' order="last"';
                    if(is_array($data)){
                        $out .= ' title="'.$data["$sc[type]_title"][$i].'" icon="'.$data["$sc[type]_icon"][$i];
                        $out .= '" button_text="'.$data["$sc[type]_button_text"][$i].'" button_link="'.$data["$sc[type]_button_link"][$i].'"]';
						
                        $out .= (empty($data["$sc[type]_content"][$i])?' ':$data["$sc[type]_content"][$i]);
                    }
                    else{
                        $out .= ']';
                    }
                    $out .= ' [/2_column] ';
                }
                break;
			case 'one_third_block':
                $out .= '] ';
                for ($i = 0;$i<2;$i++){
                    if ($i==1) $out .= '[two_third'; else $out .= '[one_third';
					if ($i == 0) $out .= ' order ="first"'; else if ($i == 1) $out .= ' order="last"';
                    if(is_array($data)){
                        $out .= ' title="'.$data["$sc[type]_title"][$i].'" icon="'.$data["$sc[type]_icon"][$i];
                        $out .= '" button_text="'.$data["$sc[type]_button_text"][$i].'" button_link="'.$data["$sc[type]_button_link"][$i].'"]';
                        $out .= (empty($data["$sc[type]_content"][$i])?' ':$data["$sc[type]_content"][$i]);
                    }
                    else{
                        $out .= '] ';
                    }
                    if ($i==1) $out .= ' [/two_third] '; else $out .= ' [/one_third] ';
                }
                break;
				
			case 'one_third_last_block':
                $out .= '] ';
                for ($i = 0;$i<2;$i++){
                    if ($i==1) $out .= '[one_third'; else $out .= '[two_third';
					if ($i == 0) $out .= ' order ="first"'; else if ($i == 1) $out .= ' order="last"';
                    if(is_array($data)){
                        $out .= ' title="'.$data["$sc[type]_title"][$i].'" icon="'.$data["$sc[type]_icon"][$i];
                        $out .= '" button_text="'.$data["$sc[type]_button_text"][$i].'" button_link="'.$data["$sc[type]_button_link"][$i].'"]';
                        $out .= (empty($data["$sc[type]_content"][$i])?' ':$data["$sc[type]_content"][$i]);
                    }
                    else{
                        $out .= '] ';
                    }
                    if ($i==1) $out .= ' [/one_third] '; else $out .= ' [/two_third] ';
                }
                break;
				
            case '3_columns':
                $out .= '] ';
                for ($i = 0;$i<3;$i++){
                    $out .= '[3_column';
					if ($i == 0) $out .= ' order ="first"'; else if ($i == 2) $out .= ' order="last"';
                    if(is_array($data)){
                        $out .= ' title="'.$data["$sc[type]_title"][$i].'" icon="'.$data["$sc[type]_icon"][$i];
                        $out .= '" button_text="'.$data["$sc[type]_button_text"][$i].'" button_link="'.$data["$sc[type]_button_link"][$i].'"]';
						if(!empty($data["$sc[type]_content"][$i])){
							$out .= $data["$sc[type]_content"][$i];
						}
						else{
							$out .= ' ';
						}
                    }
                    else{
                        $out .= ']';
                    }
                    $out .= ' [/3_column] ';
                }
                break;
            case '4_columns':
                $out .= '] ';
                for ($i = 0;$i<4;$i++){
                    $out .= '[4_column';
					if ($i == 0) $out .= ' order ="first"'; else if ($i == 3) $out .= ' order="last"';
                    if(is_array($data)){
                        $out .= ' title="'.$data["$sc[type]_title"][$i].'" icon="'.$data["$sc[type]_icon"][$i];
                        $out .= '" button_text="'.$data["$sc[type]_button_text"][$i].'" button_link="'.$data["$sc[type]_button_link"][$i].'"]';
                        $out .= (empty($data["$sc[type]_content"][$i])?' ':$data["$sc[type]_content"][$i]);
                    }
                    else{
                        $out .= ']';
                    }
                    $out .= ' [/4_column] ';
                }
                break;
            default:
               $out .= "] ";
        }
        $out .= "[/$sc[type]]$sc[suffix] ";
    }
    return $out;
}

function afl_render_shortcode_attributes($type, $attrs = array()){
    $out = array();
    if(is_array($attrs)){
        foreach($attrs as $k=>$v){
            if(is_array($v)) $v = $v[0];
            $k = str_replace("{$type}_", '', $k);
            $v = esc_attr($v);
            $out[] = "{$k}=\"{$v}\"";
        }
    }
    return implode(' ', $out);
}

function afl_render_theme_option($id, $option){
    $out = '';
    if($option && isset($option['type'])){
        switch($option['type']){
            case 'checkbox':
                $option['value'] = 'open';
                if($option['default_value']=='open'){
                    $option['attributes']['checked'] = 'checked';
                }
                $out = __afl_input($id, $option);
                break;
            case 'text':
                $option['value'] = esc_attr($option['default_value']);
                $out = __afl_input($id, $option);
                if($option['uploadable']){
				   (isset($option['button_class'])) ? $class = $option['button_class'] : $class = '';
                   $out .= __afl_upload_button($id.'_uploader', $class);
                }
                break;
            case 'textarea':
                $option['value'] = esc_attr($option['default_value']);
                $out = __afl_textarea($id, $option);
                break;
            case 'select':
                $option['value'] = esc_attr($option['default_value']);
                $out = __afl_select($id, $option);
                break;
        }
    }
    return $out;
}

function afl_render_attributes($attributes){
    $out = array();
    if(is_array($attributes)){
        foreach($attributes as  $k => $v){
            //ignoring such attributes
            if (in_array($k, array('value', 'id', 'type'))) continue;
            $v = esc_attr($v);
            $out[] = "{$k}=\"{$v}\"";
        }
    }
    return implode(' ', $out);
}

function afl_refresh_options($options){
    global $__OPTIONS;
    if(is_array($options)){
        foreach($options as $k => $v){
            if(isset($__OPTIONS[$k])){
                $__OPTIONS[$k]['default_value'] = $v;
            }
        }
    }
}

function __afl_input($id, $option){
    if( !isset($option['attributes']['name']) ){
        $option['attributes']['name'] = $id;
    }
    $out = "<input id='{$id}' type='{$option['type']}' ";
	if ($option['type'] == 'checkbox') $out.="class='niceCheck0' ";
	$out .= "value='{$option['value']}' ".
        afl_render_attributes($option['attributes'])." />";
	return $out;
}

function __afl_textarea($id, $option){
    if( !isset($option['attributes']['name']) ){
        $option['attributes']['name'] = $id;
    }
    return "<textarea id='{$id}' ".afl_render_attributes($option['attributes']).">".
        $option['value']."</textarea>";
}

function __afl_select($id, $option){
    if( !isset($option['attributes']['name']) ){
        $option['attributes']['name'] = $id;
    }
    $out = '';
    if(is_array($option['options'])){
        $out = "<select id='{$id}' ".afl_render_attributes($option['attributes']).">";
        foreach($option['options'] as $k => $v){
			if(isset($option['background']) && $option['background']) $k = $v;
            $out .= "<option value='{$k}'".($k==$option['default_value']?'selected':'').">{$v}</option>";
        }
        $out .= "</select>";
    }
    return $out;
}


function __afl_upload_button($id, $class = ''){
    return "<a href='#' id='{$id}' class=\"afl-button afl-uploader {$class}\">Upload</a>";
}

function __afl_composer_toolbox( ){
    global $__SHORTCODES;
?>
    <div id="afl-composer-toolbox-items" class="maxheight">
    <div class="toolbox-logo"></div>
        <div class="toolbox-inner">
			<?php
				$i=0;
				$j=0;
				$n=0;
                foreach($__SHORTCODES as $k => $tool){
					$type = str_replace('afl_','', $k);
                     switch ($k){
						case 'afl_flex-slider':
                        case 'afl_text_slider':if ($i==0) echo '<strong><a href="javascript:void(0)">Sliders</a></strong><div>';__afl_composer_toolbox_item($k, $tool, $type);$i++;break;

                        case 'afl_full_width':
                        case 'afl_2_columns':
                        case 'afl_3_columns':
                        case 'afl_4_columns':
                        case 'afl_one_third_block':
                        case 'afl_one_third_last_block':if ($j==0) echo '</div><strong><a href="javascript:void(0)">Layouts</a></strong><div>';$j++;__afl_composer_toolbox_item($k, $tool, $type);break;
                        default:if($n == 0) echo ' </div>';$n++;__afl_composer_toolbox_item($k, $tool, $type);
                    }
                    
                }
            ?>
        </div>
    </div>
<?php
}

function __afl_composer_toolbox_item($key, $tool, $type){?>
	<?php $suf = rand(100000,999999); ?>
    <div id="<?php print $key ?>" class="toolbox-inner-item">
    	<a href="javascript:void(0)" title="<?php echo $tool['description'] ?>" id="tooltip-link-<?php print $suf ?>" class="<?php print $type ?>"><?php print $tool['name'] ?></a>
        <script>
	 		simple_tooltip("a#tooltip-link-<?php print $suf ?>", "<?php print TEMPLATEURL . '/lib/'.$tool['image'] ?>");
		</script>
       <!-- <div><?php //print $tool['description'] ?></div> -->
    </div>
<?php
}

function __afl_cloner( $post, $metabox ){
    print '<div style="padding:6px 0 6px;"><p style="float:left;margin:0;line-height:23px;">Clone this post and data</p><input name="afl_clone" style="float:right;display:inline-block;" type="submit" class="button-primary" id="clone" value="Clone" /><div class="clear"></div></div>';
}

function afl_pager($posts_count, $per_page, $cur_page, $delta = 2, $dooutput = true){
    $max_page = ceil(floatval($posts_count)/$per_page);
    if($max_page>1){
        $pages = array();
        $out = '<!--pagination-->
                        <div class="pagination pagination-centered">
                        	<ul>';
        //'<'
        if($cur_page!=1){
            $pages[] = array('k'=>($cur_page-1), 'v'=>'&laquo;', 'class'=>'prev');
            $class = 'first';
        }
        else{
            $class = 'active first';
        }
        //first page
        $pages[] = array('k'=>1, 'v'=>'1', 'class' => $class);
        //left page index
        $l_page = $cur_page - $delta;
        if($l_page <= 2){
            $l_page = 2;
        }
        else{
            //space
            $pages[] = array('v'=>'...', 'class'=>'space');
        }
        //right page index
        $r_page = $cur_page + $delta;
        if($r_page > ($max_page - 1)){
            $r_page = $max_page - 1;
        }
        for($i = $l_page; $i <= $r_page; $i++){
            $item = array('k'=>$i, 'v'=>$i);
            if($i == $cur_page){
                $item['class'] = 'active';
            }
            $pages[] = $item;
        }
        if($i < $max_page){
            //space
            $pages[] = array('v'=>'...', 'class'=>'space');
        }
        //next
        if($cur_page!=$max_page){
            //last
            $pages[] = array('k'=>$max_page, 'v'=>$max_page, 'class' => '');
            $pages[] = array('k'=>($cur_page+1), 'v'=>'&raquo;', 'class'=>'next');

        }
        else{
            //last
            $pages[] = array('k'=>$max_page, 'v'=>$max_page, 'class' => 'active');
        }

        foreach($pages as $item ){
            $out .= '<li'.(isset($item['class'])?' class="'.$item['class'].'"':'').'>'.(isset($item['k'])?('<a href="'.get_pagenum_link($item['k']).'">'.$item['v'].'</a>'):'<a>'.$item['v'].'</a>').'</li>';
        }
        $out .= '</ul>
                </div>';
        if($dooutput){
            echo $out;
        }
        else{
            return $out;
        }
       
    }
}
function __afl_composer_base( $post, $metabox ){
    //print_r($post);
?>	
	<div class="logo-container">
        <a href="http://www.turboframeworks.com" class="logo"></a>
        <div class="swich-button-container">
            <?php if(get_post_meta($post->ID, 'afl_composer', true)=='on') echo '<strong>Turbo Editor enabled. You can switch to classic editor</strong>';else echo '<strong>Turbo Editor disabled. You can switch to it</strong>'; ?>
        </div>
    </div>
    <div class="item-container">
    	
        <input type="hidden" name="afl_composer"
               value="<?php print ($afl_composer = get_post_meta($post->ID, 'afl_composer', true))?$afl_composer:'off'; ?>" />
        <input type="hidden" name="afl_theme_base" value="<?php print TEMPLATEURL; ?>" />
        
        <div id="afl-loader" style="display:none;"></div>
        <?php if(current_user_can( 'upload_files' )): ?>
        <div id="composer-media-buttons" style="display:none">
            <?php	do_action( 'media_buttons' ); ?>
        </div>
        <?php endif; ?>
        <div id="afl-composer-base-data">
        <table width="100%" class="conainer-table" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td width="80%" class="left-side-cell">
            <ul id="afl-composer-base-items">
                <?php
                    $items = afl_get_te_data($post->ID);
                    if($items){
                        $i = 0;
                        foreach($items as $item){
                            __afl_composer_base_item($i, $item);
                        }
                    } ?>
            </ul>
        </td>
        <td width="20%" class="right-side-cell">
			<?php __afl_composer_toolbox(); ?>
        </td>
        </tr>
        </table>
        <div class="clear"></div>
        </div>
    </div>
<?php
}

function __afl_composer_base_item(&$i, $item, $attached = ''){
    global $__SHORTCODES;
?>
<li class="editor-item <?php echo $item['type'] ?>">
    <span></span>
    <div class="left-side">
        <strong><?php print $__SHORTCODES["afl_{$item['type']}"]['name'] ?> <a href="#" class="text-name"><?php print (isset($item['name']) && ($item['name'] !="Type element name..."))?$item['name']: 'Block Name'; ?></a></strong>
    </div>
    <input type="hidden" name="itemattached[<?php print $i ?>]" value="<?php print $attached; ?>"/>
    <input type="hidden" name="itemdata[<?php print $i ?>]" value="<?php print base64_encode(serialize($item['data'])) ?>"/>
    <input type="hidden" name="itemtype[<?php print $i ?>]" value="<?php print $item['type'] ?>"/>
    <input type="text" name="itemname[<?php print $i ?>]" style="display:none" value="<?php print isset($item['name'])?$item['name']:'Type element name...'; ?>"/>
    <a class="name-apply" style="display:none;">Yes</a>
    <div class="item-wrapper" style="display:none;">
        <textarea name="itemprefix[<?php print $i ?>]" cols="50" rows="5"><?php print $item['prefix'] ?></textarea>
        <textarea name="itemsuffix[<?php print $i ?>]" cols="50" rows="5"><?php print $item['suffix'] ?></textarea>
    </div>
    <div class="right-side"><a href="#" class="wrapit afl-advance" title="Wrap It">Your Code</a><a href="#" title="Edit" class="edit afl-with-ipencil"></a><a href="#" class="delete afl-with-itrash" title="Delete"></a></div>
    <?php if($item['type']=='sidebar'): ?>
    <ul class="composer-sidebar-items">
        <?php
        $i++;
        foreach($item['attached'] as $a){
            __afl_composer_base_item($i, $a, 'true');
        }
        $i--;
        ?>
    </ul>
    <?php endif;?>
</li>
<?php
    $i++;
}

function __afl_composer_edit_item_tab( $col_id, $type, $values = array() ){
?>
<div id="afl-edit-item-tabs-content<?php print $col_id; ?>">
    <div class="slide-item">
   		<label for="<?php print "{$type}-title{$col_id}" ?>">Title</label>
        <input id="<?php print "{$type}-title{$col_id}" ?>" type="text" name="<?php print "{$type}_title[$col_id]" ?>" value="<?php print $values["{$type}_title"][$col_id]?>"/>
    </div>
    <div class="slide-item">
   		<label for="<?php print "{$type}-icon{$col_id}" ?>">Icon source</label>
        <input id="<?php print "{$type}-icon{$col_id}" ?>" type="text" name="<?php print "{$type}_icon[$col_id]" ?>" value="<?php print $values["{$type}_icon"][$col_id] ?>" />
		<?php print __afl_upload_button("{$type}-icon{$col_id}_uploader") ?>
        <!--<div class="insrt-butt-cont"><a href="media-upload.php?post_id=4&type=image&TB_iframe=1&width=640&height=774" id="" class="thickbox">Insert Image</a></div> -->
    </div>
    <?php $richedit =  user_can_richedit(); global $post; ?>
    <?php $class = ($richedit?'afl-wysiwyg':''); ?>
    <div class="slide-item editor">
        <?php if($richedit): ?>
            <p style="overflow:hidden;margin:0;" class="hide-if-no-js">
		
                <a class="alignright" id="edSideButtonHTML" onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'html');">HTML</a>
		<a class="active alignright" id="edSideButtonPreview"  onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'tinymce');">Visual</a>
            </p>
        <?php endif; ?>
        <textarea id="<?php print "{$type}-content-{$col_id}" ?>" cols="100" rows="25" class="<?php print $class; ?>" name="<?php print "{$type}_content[$col_id]" ?>"><?php print wp_richedit_pre($values["{$type}_content"][$col_id]); ?></textarea>
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-button-text{$col_id}" ?>">Button text</label>
        <input id="<?php print "{$type}-button-text{$col_id}" ?>" type="text" name="<?php print "{$type}_button_text[$col_id]" ?>" value="<?php print $values["{$type}_button_text"][$col_id] ?>" />
        
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-button-link{$col_id}" ?>">Button link</label>
        <input id="<?php print "{$type}-button-link{$col_id}" ?>" type="text" name="<?php print "{$type}_button_link[$col_id]" ?>" value="<?php print $values["{$type}_button_link"][$col_id] ?>" />
        
    </div>
</div>
<?php
}

function __afl_composer_edit_text_slider_item( $col_id, $type, $values = array() ){
?>
<div id="afl-edit-item-tabs-content<?php print $col_id; ?>" class="text-slide">
    <div class="slide-item">
    	<label for="<?php print "{$type}-title{$col_id}" ?>">Title</label>
        <input id="<?php print "{$type}-title{$col_id}" ?>" type="text" name="<?php print "{$type}[$col_id][title]" ?>" value="<?php print $values[$type][$col_id]['title']; ?>" />
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-icon{$col_id}" ?>">Icon Source</label>
        <input id="<?php print "{$type}-icon{$col_id}" ?>" type="text" name="<?php print "{$type}[$col_id][icon]" ?>" value="<?php print $values[$type][$col_id]['icon']; ?>" />
		<?php print __afl_upload_button("{$type}-icon{$col_id}_uploader") ?>
    </div>
    <div class="slide-item">
        <textarea id="<?php print "{$type}-content-{$col_id}" ?>" cols="100" rows="10" name="<?php print "{$type}[$col_id][content]" ?>"><?php print $values[$type][$col_id]['content']; ?></textarea>
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-button-text{$col_id}" ?>">Button text</label>
        <input id="<?php print "{$type}-button-text{$col_id}" ?>" type="text" name="<?php print "{$type}[$col_id][button_text]" ?>" value="<?php print $values[$type][$col_id]['button_text']; ?>" />
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-button-link{$col_id}" ?>">Button link</label>
        <input id="<?php print "{$type}-button-link{$col_id}" ?>" type="text" name="<?php print "{$type}[$col_id][button_link]" ?>" value="<?php print $values[$type][$col_id]['button_link']; ?>" />
    </div>
</div>
<?php
}

function __afl_composer_edit_anything_slider_item( $col_id, $type, $values = array() ){
?>
<div id="afl-edit-item-tabs-content<?php print $col_id; ?>" class="anything-slide">
    <?php $richedit =  user_can_richedit(); global $post; ?>
    <?php $class = ($richedit?'afl-wysiwyg':''); ?>
    <div class="slide-item">
        <?php if($richedit): ?>
            <div style="overflow:hidden;margin:0;" class="hide-if-no-js">
                <a class="alignright" id="edSideButtonHTML" onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'html');">HTML</a>
		<a class="active alignright" id="edSideButtonPreview"  onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'tinymce');">Visual</a>
            </div>
        <?php endif; ?>
        <textarea id="<?php print "{$type}-content-{$col_id}" ?>" cols="100" rows="25" class="<?php print $class; ?>" name="<?php print "{$type}[$col_id][content]" ?>"><?php print $values[$type][$col_id]['content']; ?></textarea>
    </div>
</div>
<?php
}

function afl_get_cufon_font_list(){
    static $fonts;
    if (!$fonts){
        $fonts = array();
        if ($handle = opendir(TEMPLATEPATH.'/js/fonts')) {
            while (false !== ($file = readdir($handle))){
                if(preg_match('/(\w+)_(\d+)\.font\.js/', $file, $matches)){
                    $fonts[] = array('name'=>str_replace('_',' ',$matches[1]), 'weight'=>$matches[2]);
                }
            }
            closedir($handle);
        }
    }
    return $fonts;
}

function afl_get_google_font_list(){
    return array(
        'Terminal Dosis',
        'Droid Serif',
        'Droid Sans',
		'Cuprum',
		'Yesteryear',
		'Open Sans'    );
}

function afl_get_background_parts(){
	return array('page', 'header', 'fullwidth', 'content', 'footer');
}

function afl_get_meta_tag_list(){
    return array(
        '[logo part1]' => 'header .logo a strong',
        '[logo part2]' => 'header .logo a b',
        '[tagline]' => 'header .logo i',
        '[menu items]' => 'ul#menu-main-menu li a',
		'[menu items hover]' => 'ul#menu-main-menu li a:hover, ul#menu-main-menu li.current_page_item>a, ul#menu-main-menu li li.current_page_item>a, ul#menu-main-menu li.current_page_parent>a, ul#menu-main-menu li.sfHover>a',
        '[content text]' => 'section#content'
    );
}

function afl_get_active_fonts(){
    static $fonts;
    if(!$fonts){
        $fonts = array();
        if(is_array($option_fonts = unserialize(get_option('afl_font')))){
            foreach($option_fonts as $font){
                $font_parts = explode(';', $font['font']);
                $font['filename'] = 'js/fonts/'.str_replace(' ', '_', $font_parts[0])."_{$font_parts[1]}.font.js";
                $font['name'] = $font_parts[0];
                $font['weight'] = $font_parts[1];
                unset($font['font']);
                if(file_exists(TEMPLATEPATH.'/'.$font['filename'])){
                    $fonts[] = $font;
                }
            }
        }
    }
    return $fonts;
}

function afl_get_post_meta_original($post_id, $key){
    global $wpdb;
    $res = $wpdb->get_results($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE post_id=%d AND meta_key='%s'", $post_id, $key));
    return ($res[0]->meta_value);
}

function afl_get_te_data($post_id, $key = 'afl_composer_data'){
	$meta = get_post_meta($post_id, $key);
	$meta = $meta[0];
	if(is_string($meta)){

		//trying json decode
		$tmp = json_decode($meta, true);
		if((!$tmp&&function_exists('json_last_error')&&json_last_error()!==JSON_ERROR_NONE) || ($tmp == NULL&&!function_exists('json_last_error'))){
			//trying base64_decode
			$tmp = base64_decode($meta);
			$tmp = json_decode($tmp, true);
		}

		$meta = $tmp;
	}
	return $meta;
}

function afl_set_te_data($post_id, $data, $key = 'afl_composer_data'){
	if(intval($post_id)>0){
		$data = json_encode($data);
		$data = base64_encode($data);
		global $wpdb;
		if(($meta_id = $wpdb->get_var($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id=%d AND meta_key='%s'", $post_id, $key)))>0){
			$wpdb->update( $wpdb->postmeta, array( 'meta_value' => $data ), array('meta_id' => $meta_id), array('%s'), array('%d') );
		}
		else{
			$wpdb->insert( $wpdb->postmeta, array( 'post_id' => $post_id, 'meta_key' => $key, 'meta_value' => $data ), array( '%d', '%s', '%s' ) );
		}
	}
}

function afl_get_active_sitebars(){
    global $wp_registered_sidebars;
    $opts = array();
    foreach($wp_registered_sidebars as $k=>$v){
        if(is_active_sidebar($k)){
            $opts[$k] = $v['name'];
        }
    }
    return $opts;
}

function afl_import_google_fonts () {
    $out = '<style type="text/css"> ';
    $out .= '@import url("'.'http://fonts.googleapis.com/css?family='.implode('|', afl_get_google_font_list()).'");';
    $out .= ' </style>';
    return $out;
}

function afl_get_custom_style(){
    $styles = array();
    foreach(afl_get_background_parts() as $part){
        $background = get_theme_mod("afl_{$part}_background_image", '');
		if(!get_theme_mod("afl-{$part}-color-transparent", false))
			$color = '#'.get_theme_mod("afl_{$part}_background_color", '');
		else
			$color = 'transparent';
        if ( ! $background && ! $color )
                continue;
        $style = "background-color: $color;";
        if ( $background ) {
                $image = " background-image: url('$background');";

                $repeat = get_theme_mod( "afl_{$part}_background_repeat", 'repeat' );
                if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
                        $repeat = 'repeat';
                $repeat = " background-repeat: $repeat;";

                $position = get_theme_mod( "afl_{$part}_background_position_x", 'left' );
                if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
                        $position = 'left';
                $position = " background-position: top $position;";

                $attachment = get_theme_mod( "afl_{$part}_background_attachment", 'scroll' );
                if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
                        $attachment = 'scroll';
                $attachment = " background-attachment: $attachment;";

                $style .= $image . $repeat . $position . $attachment;
        } else {
			$style .= 'background-image:none; ';
		}
        $styles[$part] = $style;
    }
    $out = '';
    if(count($styles)>0){
        $out .= '<style type="text/css"> ';
        if(isset($styles['page'])){
                $out .= 'body { '. trim( $styles['page'] ). ' } ';
        }
        if(isset($styles['header'])){
                $out .= 'header, header #menu ul ul { '. trim( $styles['header'] ). ' } ';
        }
		if(isset($styles['fullwidth'])){
			$out .= 'section.container { '. trim( $styles['fullwidth'] ). ' } ';
		}
        if(isset($styles['content'])){
                $out .= 'section#container { '. trim( $styles['content'] ). ' } ';
        }
        if(isset($styles['footer'])){
                $out .= 'footer { '. trim( $styles['footer'] ). ' } ';
        }
        $out .= ' </style>';
    }
    $fonts = unserialize(get_option('afl_font',''));
    if(is_array($fonts)){
        $metatags = afl_get_meta_tag_list();
        $metatags_keys = array_keys($metatags);
        if(count($fonts)>0){
            $out .= '<style type="text/css"> ';
            $loads = array();
            foreach($fonts as $font){
                $font['selector'] = trim(strtolower($font['selector']));
                if(in_array($font['selector'], $metatags_keys)){
                        $font['selector'] = $metatags[$font['selector']];
                }
                if(!empty($font['color'])){
                        $style = "color: $font[color];";
                }
                if(!empty($font['font'])){
                        $loads[] = $font['font'];
                        $font['font'] = str_replace('+', ' ', $font['font']);
                        $style .= "font-family: '$font[font]';";
                }
                $out .= "$font[selector] { {$style} } ";
            }

            $out .= ' </style>';
        }
        $out .= afl_import_google_fonts();
    }
    return $out;
}

?>
