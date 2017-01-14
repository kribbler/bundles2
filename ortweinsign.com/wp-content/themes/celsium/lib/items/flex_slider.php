<div id="afl-edit-composer-item-tabs" class="items slider">
    <ul>
        <li><a href="#afl-edit-item-tabs-content0">Slides</a></li>
        <li><a href="#afl-edit-item-tabs-content1">Settings</a></li>
    </ul>
    <div>
        <div id="afl-edit-item-tabs-content0">
            <table class="form-table" cellpadding="0">
				<?php
				$next_value = 0;
				if(isset($data[$_POST['itemtype'][$index]."_images"])){
					foreach($data[$_POST['itemtype'][$index]."_images"] as $image){
						?>
                <tbody>
                <tr>
                    <th><?php print __('Slider image', $domain); ?></th>
                    <td><?php print afl_render_theme_option("afl-slider-image-url{$next_value}", array('type' => 'text', 'default_value' => $image['url'], 'uploadable' => true, 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][url]"))); ?></td>

                </tr>
                    <tr>
                        <th><?php print __('Slider text', $domain); ?></th>
                        <td><?php print afl_render_theme_option("afl-slider-image-title{$next_value}", array('type' => 'text', 'default_value' => $image['title'], 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][title]"))); ?><a class="afl-slider-image-delete button" href="#"></a></td>

                    </tr>
						<?php
						$next_value++;
					}
				}
				?>
            </tbody>
                <tbody>
                <tr>
                    <th><?php print __('Slider image', $domain); ?></th>
                    <td><?php print afl_render_theme_option("afl-slider-image-url{$next_value}", array('type' => 'text', 'uploadable' => true, 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][url]"))); ?></td>
                </tr>
                <tr>
                    <th><?php print __('Slider text', $domain); ?></th>
                    <td><?php print afl_render_theme_option("afl-slider-image-title{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => $_POST['itemtype'][$index]."_images[{$next_value}][title]"))); ?>
                        <a href="#" class="afl-slider-image-add button"></a>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
        <div id="afl-edit-item-tabs-content1">
            <table class="form-table" cellpadding="0">
                <tbody>
                <tr valign="top">
                    <th><?php print __('Slideshow cycling speed', $domain); ?></th>
                    <td><?php print afl_render_theme_option("{$type}-slideshowSpeed", array('type' => 'text', 'default_value' => $data["{$type}_slideshowSpeed"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_slideshowSpeed"))); ?> milliseconds</td>
                </tr>
                <tr valign="top">
                    <th><?php print __('Slides transition speed', $domain); ?></th>
                    <td><?php print afl_render_theme_option("{$type}-slideSpeed", array('type' => 'text', 'default_value' => $data["{$type}_slideSpeed"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_slideSpeed"))); ?> milliseconds</td>
                </tr>
                <tr>
                    <th><?php print __('Direction', $domain); ?></th>
                    <td><?php print afl_render_theme_option("{$type}-direction", array('type' => 'select' ,
						'options' => array('horizontal' => 'horizontal', 'vertical' => 'vertical'),
						'default_value' => (isset($data["{$type}_direction"])?$data["{$type}_direction"]:'horizontal'),
						'attributes' => array('class' => 'regular-text', 'name' => "{$type}_direction"))); ?></td>
                </tr>
                <tr>
                    <th><?php print __('Fade or Slide?', $domain); ?></th>
                    <td><?php print afl_render_theme_option("{$type}-animation", array('type' => 'select' ,
						'options' => array('slide' => 'slide', 'fade' => 'fade'),
						'default_value' => (isset($data["{$type}_animation"])?$data["{$type}_animation"]:'slide'),
						'attributes' => array('class' => 'regular-text', 'name' => "{$type}_animation"))); ?></td>
                </tr>
                <tr>
                    <th><?php print __('Choose effect', $domain); ?></th>
                    <td><?php print afl_render_theme_option("{$type}-effect", array('type' => 'select' ,
						'options' => array('swing' => 'swing', 'easeInQuad' => 'easeInQuad', 'easeOutQuad' => 'easeOutQuad', 'easeInOutQuad' => 'easeInOutQuad', 'easeInCubic' => 'easeInCubic', 'easeOutCubic' => 'easeOutCubic', 'easeInOutCubic' => 'easeInOutCubic', 'easeInQuart' => 'easeInQuart', 'easeOutQuart' => 'easeOutQuart', 'easeInOutQuart' => 'easeInOutQuart', 'easeInSine' => 'easeInSine', 'easeOutSine' => 'easeOutSine', 'easeInOutSine' => 'easeInOutSine', 'easeInExpo' => 'easeInExpo', 'easeOutExpo' => 'easeOutExpo', 'easeInOutExpo' => 'easeInOutExpo', 'easeInQuint' => 'easeInQuint', 'easeOutQuint' => 'easeOutQuint', 'easeInOutQuint' => 'easeInOutQuint', 'easeInCirc' => 'easeInCirc', 'easeOutCirc' => 'easeOutCirc', 'easeInOutCirc' => 'easeInOutCirc', 'easeInElastic' => 'easeInElastic', 'easeOutElastic' => 'easeOutElastic', 'easeInOutElastic' => 'easeInOutElastic', 'easeInBack' => 'easeInBack', 'easeOutBack' => 'easeOutBack',
							'easeInOutBack' => 'easeInOutBack', 'easeInBounce' => 'easeInBounce', 'easeOutBounce' => 'easeOutBounce', 'easeInOutBounce' => 'easeInOutBounce'),
						'default_value' => (isset($data["{$type}_effect"])?$data["{$type}_effect"]:'jswing'),
						'attributes' => array('class' => 'regular-text', 'name' => "{$type}_effect"))); ?></td>
                </tr>
                <tr valign="top">
                    <th><?php print __('Randomize Slides', $domain); ?></th>
                    <td align="left"><?php print afl_render_theme_option("{$type}-randomize", array('type' => 'checkbox', 'default_value' => $data["{$type}_randomize"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_randomize"))); ?></td>
                </tr>
                <tr valign="top">
                    <th><?php print __('Next & Prev, buttons navigation', $domain); ?></th>
                    <td align="left"><?php print afl_render_theme_option("{$type}-navigation", array('type' => 'checkbox', 'default_value' => $data["{$type}_navigation"], 'attributes' => array('class' => 'small-text', 'name' => "{$type}_navigation"))); ?></td>
                </tr>
                <tr valign="top">
                    <th><?php print __('Loop Slides?', $domain); ?></th>
                    <td align="left"><?php print afl_render_theme_option("{$type}-loop", array('type' => 'checkbox', 'default_value' => $data["{$type}_loop"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_loop"))); ?></td>
                </tr>
                <tr valign="top">
                    <th><?php print __('Pause on hover', $domain); ?></th>
                    <td align="left"><?php print afl_render_theme_option("{$type}-hoverPause", array('type' => 'checkbox', 'default_value' => $data["{$type}_hoverPause"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_hoverPause"))); ?></td>
                </tr>
                <tr valign="top">
                    <th><?php print __('Make It Full Width', $domain); ?></th>
                    <td align="left"><?php print afl_render_theme_option("{$type}-fullwidth", array('type' => 'checkbox', 'default_value' => $data["{$type}_fullwidth"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_fullwidth"))); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>