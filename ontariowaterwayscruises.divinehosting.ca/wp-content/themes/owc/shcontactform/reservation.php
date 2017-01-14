<?php
$cruises=cruises::instance();
$cruises->schedule();
$year=date('Y');
if (date('m')>10) // out of season -show next year
	$year+=1;
$thisyear=$cruises->schedule($year);
$year+=1;
$nextyear=$cruises->schedule($year);
$p=array_merge($thisyear,$nextyear);
$dates=array();
foreach ($p as $a) {
	if ($a->meta['cruise_schedule_start']<time())
		continue;
	$c=$a->meta['cruise_schedule_cruise'];
	if (!isset($dates[$c]))
		$dates[$c]=array();
	$dates[$c][]=$a->meta['friendly_date'].' '.$a->post_title;	
}
?>
<div class="reservation">
<h2>Request a Reservation</h2>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<select name="data[Cruise]" required class="style_select cruise">
				<option value="">Select Cruise</option>
				<?php
				global $post;
				$list=posts::title_list(array(
					'post_type'=>'cruises',
					'numberposts' => -1,
					'post_status' => 'any'
				));
				foreach ($list as $k=>$a) {
					echo '<option';
					if ($post->ID==$k)
						echo ' selected="selected"';
					echo '>',html($a),'</option>';
				}
				?>
			</select>
			<br />
		</div>
		<div class="col-lg-6">
			<select name="data[Date]" class="style_select dates">
				<option value="">Select a Date</option>
                <?php 
				foreach ($dates as $k=>$a) {
					foreach ($a as $aa) {
						if (!isset($list[$k]))
							continue;
						echo '<option data-cruise="',$list[$k],'">',html($aa),'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="reserve">
				<label><b>Reserve</b></label>
				<select name="data[Reserve Double Occupancy]" class="style_select doubleoccupant">
					<option>0</option>
					<option selected>1</option>
					<option>2</option>
					<option>3</option>
				</select><br />
				<label>Cabin(s) for double occupancy (Max 6 Passengers)</label>
				<br /><br />
			</div>
		</div>
		<div class="col-lg-6">
			<div class="reserve">
				<label><b>Reserve</b></label>
					<select name="data[Reserve Single Occupancy]" class="style_select singleoccupant">
						<option selected>0</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
					</select>
					<br />
				<label>Cabin(s) for single occupancy (Max 6 Passengers)</label>
			</div>
		</div>
	</div>
</div>
<script type="text/template" id="occupant">
    <div>
		<h4>Occupant <span class="num"></span></h4>
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<label class="name"><span class="label">Name</span> <span><input type="text" name="data[Name][]"/></span></label>
				</div>
				<div class="col-lg-3">
					<label class="sameaddress"><input type="checkbox" value="1"/> <span class="label">Use same address as Occupant One</span></label>
				</div>

				<div class="col-lg-3">
					<label class="address"><span class="label">Address</span> <span><textarea name="data[Address][]"></textarea></span></label>
				</div>

				<div class="col-lg-3">
					<label class="tel"><span class="label">Telephone</span> <span><input type="text" name="data[Telephone][]"/></span></label>
				</div>
			</div>
		</div>
        
        
		
        
    </div>
</script>
<div id="occupants">

</div>

<p>Some text</p>
<div class="terms_checkbox">
<label><input type="checkbox" required/> I have read and understood the <a href="/terms-conditions/" target="_blank">Terms &amp Conditions</a></label> 
</div>
<div class="submit">
<input type="submit" value="Submit" class="btn margin_top_40 margin_bottom_40 center_me block_me" />
</div>

<p>If you don't wish to request a reservation online you may download a reservation form and send it to us at the address at the bottom of the page</p>

<div class="reservation_form_link"><a href="#">Download a Reservation Form</a></div>
</div>

<script>
jQuery(document).ready(function($) {
	var changecruise=function() {
		var val=$('.reservation .cruise').val();
		var s=$('.reservation .dates');
		$('option',s).each(function() {
			var dt=$(this).data('cruise');
			if (dt==val)
				$(this).removeAttr('disabled');
			else if (dt)
				$(this).attr('disabled','disabled');
		});
		s.val('');
		if (s.prev().hasClass('dropcontainer')) {
			s.prev().find('li').each(function() {
				if (this.sel.disabled)
					$(this).hide();
				else
					$(this).show();
			});
			s.prev().prev().text('Select a Date');	
		}
		//s.show();
		switch ($('option:not(:disabled)',s).length) {
			case 0:
			case 1: // placeholder
				//s.hide();
				break
			case 2:
				s.find('option:last').attr('selected','selected');
				break;
		}
		s.trigger('updated');
	};
	$('.reservation .cruise').change(changecruise);
	changecruise();
	
	var nums=['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen'];
	var dooccupants=function() {
		var n;
		var o=$('#occupants > div').length;
		var need=(parseInt($('.doubleoccupant').val())*2)+parseInt($('.singleoccupant').val());
		if (need==0)
			need=1;
		if (o==need)
			return;
		var addoccupant=function() {
			var h=$($('#occupant').html());
			h.find('.sameaddress input').change(function() {
				if ($(this).prop('checked')) {
					h.find('.address textarea,.tel input').attr('disabled','disabled').val('');
				} else {
					h.find('.address textarea,.tel input').removeAttr('disabled');
					h.find('.address textarea').focus();
				}
			});
			h.find('.address,.tel').click(function(event) {
				console.log(event.target);
				var c=$(this).find('textarea,input');
				if (c.prop('disabled')) {
					h.find('.sameaddress input').prop('checked',false).change();
					$(event.target).focus();	
				}
			});
			$('#occupants').append(h);
		};
		if (need>o) {
			for (n=o;n<need;n++) {
				addoccupant();
			}
		} else {
			while (o>need) {
				$('#occupants > div:last').remove(); // maybe better to remove only empty first
				o-=1;	
			}
		}
		$('.name,.address,.tel').find('input,textarea').removeAttr('required');
		$('.name:eq(0),.address:eq(0),.tel:eq(0)').find('input,textarea').attr('required','required');
		$('.sameaddress').show();
		$('.sameaddress:eq(0)').hide();
		$('.sameaddress:eq(0) .address,.sameaddress:eq(0) .tel').find('textarea,input').prop('disabled',false);
		n=0;
		$('#occupants .num').each(function() {
			n+=1;
			$(this).text((typeof(nums[n])!='undefined') ? nums[n] : n);
		});
	};
	$('.singleoccupant,.doubleoccupant').change(dooccupants);
	dooccupants();
});
</script>