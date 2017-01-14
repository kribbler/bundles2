<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* Footer Options
    ================================================== */
    $ccard = get_option_tree('ccard',$theme_options);  
}
?>

					<?php if($ccard){?>
					<ul class="ccard">
						<?php $card = explode(",", $ccard);
						if(in_array('amazon',$card)){?><li><span rel="tooltip" class="ttip amazon" data-placement="top" title="Amazon"></span></li><?php }?>
						<?php if(in_array('amex_alt',$card)){?><li><span rel="tooltip" class="ttip amex_alt" data-placement="top" title="Amex"></span></li><?php }?>
						<?php if(in_array('amex_gold',$card)){?><li><span rel="tooltip" class="ttip amex_gold" data-placement="top" title="Amex Gold"></span></li><?php }?>
						<?php if(in_array('amex_green',$card)){?><li><span rel="tooltip" class="ttip amex_green" data-placement="top" title="Amex Green"></span></li><?php }?>
						<?php if(in_array('amex_silver',$card)){?><li><span rel="tooltip" class="ttip amex_silver" data-placement="top" title="Amex Silver"></span></li><?php }?>
						<?php if(in_array('amex',$card)){?><li><span rel="tooltip" class="ttip amex" data-placement="top" title="Amex"></span></li><?php }?>
						<?php if(in_array('apple',$card)){?><li><span rel="tooltip" class="ttip apple" data-placement="top" title="Apple"></span></li><?php }?>
						<?php if(in_array('bank',$card)){?><li><span rel="tooltip" class="ttip bank" data-placement="top" title="Bank"></span></li><?php }?>
						<?php if(in_array('cash',$card)){?><li><span rel="tooltip" class="ttip cash" data-placement="top" title="Cash"></span></li><?php }?>
						<?php if(in_array('chase',$card)){?><li><span rel="tooltip" class="ttip chase" data-placement="top" title="Chase"></span></li><?php }?>
						<?php if(in_array('coupon',$card)){?><li><span rel="tooltip" class="ttip coupon" data-placement="top" title="Coupon"></span></li><?php }?>
						<?php if(in_array('credit',$card)){?><li><span rel="tooltip" class="ttip credit" data-placement="top" title="Credit"></span></li><?php }?>
						<?php if(in_array('debit',$card)){?><li><span rel="tooltip" class="ttip debit" data-placement="top" title="Debit"></span></li><?php }?>
						<?php if(in_array('discover_alt',$card)){?><li><span rel="tooltip" class="ttip discover_alt" data-placement="top" title="Discover"></span></li><?php }?>
						<?php if(in_array('discover_novus',$card)){?><li><span rel="tooltip" class="ttip discover_novus" data-placement="top" title="Discover Novus"></span></li><?php }?>
						<?php if(in_array('discover',$card)){?><li><span rel="tooltip" class="ttip discover" data-placement="top" title="Discover"></span></li><?php }?>
						<?php if(in_array('echeck',$card)){?><li><span rel="tooltip" class="ttip echeck" data-placement="top" title="eCheck"></span></li><?php }?>
						<?php if(in_array('generic_1',$card)){?><li><span rel="tooltip" class="ttip generic_1" data-placement="top" title="Generic"></span></li><?php }?>
						<?php if(in_array('generic_2',$card)){?><li><span rel="tooltip" class="ttip generic_2" data-placement="top" title="Generic"></span></li><?php }?>
						<?php if(in_array('generic_3',$card)){?><li><span rel="tooltip" class="ttip generic_3" data-placement="top" title="Generic"></span></li><?php }?>
						<?php if(in_array('gift_alt',$card)){?><li><span rel="tooltip" class="ttip gift_alt" data-placement="top" title="gift_alt"></span></li><?php }?>
						<?php if(in_array('gift',$card)){?><li><span rel="tooltip" class="ttip gift" data-placement="top" title="Gift"></span></li><?php }?>
						<?php if(in_array('gold',$card)){?><li><span rel="tooltip" class="ttip gold" data-placement="top" title="Gold"></span></li><?php }?>
						<?php if(in_array('googleckout',$card)){?><li><span rel="tooltip" class="ttip googleckout" data-placement="top" title="Googleckout"></span></li><?php }?>
						<?php if(in_array('itunes_2',$card)){?><li><span rel="tooltip" class="ttip itunes_2" data-placement="top" title="itunes"></span></li><?php }?>
						<?php if(in_array('itunes_3',$card)){?><li><span rel="tooltip" class="ttip itunes_3" data-placement="top" title="itunes"></span></li><?php }?>
						<?php if(in_array('itunes',$card)){?><li><span rel="tooltip" class="ttip itunes" data-placement="top" title="itunes"></span></li><?php }?>
						<?php if(in_array('mastercard_alt',$card)){?><li><span rel="tooltip" class="ttip mastercard_alt" data-placement="top" title="Mastercard"></span></li><?php }?>
						<?php if(in_array('mastercard',$card)){?><li><span rel="tooltip" class="ttip mastercard" data-placement="top" title="Mastercard"></span></li><?php }?>
						<?php if(in_array('mileage',$card)){?><li><span rel="tooltip" class="ttip mileage" data-placement="top" title="Mileage"></span></li><?php }?>
						<?php if(in_array('paypal',$card)){?><li><span rel="tooltip" class="ttip paypal" data-placement="top" title="Paypal"></span></li><?php }?>
						<?php if(in_array('sapphire',$card)){?><li><span rel="tooltip" class="ttip sapphire" data-placement="top" title="Sapphire"></span></li><?php }?>
						<?php if(in_array('solo',$card)){?><li><span rel="tooltip" class="ttip solo" data-placement="top" title="Solo"></span></li><?php }?>
						<?php if(in_array('visa_alt',$card)){?><li><span rel="tooltip" class="ttip visa_alt" data-placement="top" title="Visa"></span></li><?php }?>
						<?php if(in_array('visa',$card)){?><li><span rel="tooltip" class="ttip visa" data-placement="top" title="Visa"></span></li><?php }?>
					</ul>
					<?php }?>