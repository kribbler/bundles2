<?php $col_id = 0; $values = &$data; ?>
<div id="afl-edit-item-tabs-content<?php print $col_id; ?>" class="full-width">
    <div class="slide-item">
    	<label for="<?php print "{$type}-title{$col_id}" ?>"><?php print __('Title', $domain); ?></label>
        <input id="<?php print "{$type}-title{$col_id}" ?>" type="text" name="<?php print "{$type}_title" ?>" value="<?php print $values["{$type}_title"] ?>" />
        
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-icon{$col_id}" ?>"><?php print __('Icon', $domain); ?></label>
        <input id="<?php print "{$type}-icon{$col_id}" ?>" type="text" name="<?php print "{$type}_icon" ?>" value="<?php print $values["{$type}_icon"] ?>" />
		<?php print __afl_upload_button("{$type}-icon{$col_id}_uploader") ?>
    </div>
    <?php $richedit =  user_can_richedit(); global $post; ?>
    <?php $class = ($richedit?'afl-wysiwyg':''); ?>
    <div class="slide-item">
        <?php if($richedit): ?>
            <p style="overflow:hidden;margin:0;" class="hide-if-no-js">
                <a class="alignright" id="edSideButtonHTML" onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'html');">HTML</a>
    <a class="active alignright" id="edSideButtonPreview"  onclick="switchSpecialEditors.go('<?php print "{$type}-content-{$col_id}" ?>', 'tinymce');">Visual</a>
            </p>
        <?php endif; ?>
            <textarea id="<?php print "{$type}-content-{$col_id}" ?>" cols="100" rows="25" class="<?php print $class; ?>" name="<?php print "{$type}_content" ?>"><?php print wp_richedit_pre($values["{$type}_content"]); ?></textarea>
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-button-text{$col_id}" ?>"><?php print __('Button text', $domain); ?></label>
        <input id="<?php print "{$type}-button-text{$col_id}" ?>" type="text" name="<?php print "{$type}_button_text" ?>" value="<?php print $values["{$type}_button_text"] ?>" />
        
    </div>
    <div class="slide-item">
    	<label for="<?php print "{$type}-button-link{$col_id}" ?>"><?php print __('Button link', $domain); ?></label>
        <input id="<?php print "{$type}-button-link{$col_id}" ?>" type="text" name="<?php print "{$type}_button_link" ?>" value="<?php print $values["{$type}_button_link"] ?>" />
    </div>
    <div class="select-item">
        <label for="<?php print "{$type}-category{$col_id}" ?>"><?php print __('Select category: ', $domain); ?></label>
		<?php
		$cats = get_categories();
		$categories = array();
		foreach($cats as $n => $cat) $categories["{$cat->cat_ID}"] = $cat->name;
		$opts = array('0' => __('--All Posts--',$domain)) + $categories;
		print afl_render_theme_option("afl-category", array('type' => 'select', 'options' => $opts, 'default_value'=>$data['category'], 'attributes' => array('name' => "category")));
		?>
    </div>
    <div class="select-item">
        <label for="<?php print "number{$col_id}" ?>"><?php print __('How Many to Show: ', $domain); ?></label>
		<?php print afl_render_theme_option("number", array('type' => 'select' ,
		'options' => array('3' => '3', '2' => '2', '1' => '1'), 'default_value'=>$data['number'],
		'attributes' => array('class' => 'regular-text', 'name' => "number"))); ?>
    </div>
    <div class="slide-item">
        <label for="<?php print "offset{$col_id}" ?>"><?php print __('Offset', $domain); ?></label>
        <input id="<?php print "offset{$col_id}" ?>" type="text" name="<?php print "offset" ?>" value="<?php print $values["offset"] ?>" />
    </div>
</div>