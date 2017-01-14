<?php $col_id = 0; $values = &$data; ?>
<div id="afl-edit-item-tabs-content<?php print $col_id; ?>" class="full-width">
    <div class="slide-item">
        <label for="<?php print "{$type}-title{$col_id}" ?>"><?php print __('Title', $domain); ?></label>
        <input id="<?php print "{$type}-title{$col_id}" ?>" type="text" name="<?php print "{$type}_title" ?>" value="<?php print $values["{$type}_title"] ?>" />

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
		'options' => array('4' => '4', '3' => '3', '2' => '2'), 'default_value'=>$data['number'],
		'attributes' => array('class' => 'regular-text', 'name' => "number"))); ?>
    </div>
    <div class="slide-item">
        <label for="<?php print "offset{$col_id}" ?>"><?php print __('Offset', $domain); ?></label>
        <input id="<?php print "offset{$col_id}" ?>" type="text" name="<?php print "offset" ?>" value="<?php print $values["offset"] ?>" />
    </div>
</div>