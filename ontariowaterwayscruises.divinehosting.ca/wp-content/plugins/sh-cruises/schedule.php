<?php
echo '<div id="schedule_container">';
if ($this->hasfullybooked) {
	echo '<div class="fullybooked_warning">';
	echo 'An asterisk <span class="fully_booked">*</span> beside any cruise date means that cruise is fully booked and a wait list is available. There is no obligation to place your name on any wait list. We usually get a couple of cancelations per cruise.';
	echo '</div>';	
}

$this->go('schedule_months');


if (empty($this->items)) {
	echo '<p class="no-results">There is nothing to show here at the moment.</p>';
} else {
?>
<table class="schedule_table">
<thead>
<tr><th>Date</th><th>Cruise Type</th><th>Route</th><th>Nights</th><th></th></tr>
</thead>
<tbody>
<?php
$current_month='';
$count=0;
foreach ($this->items as $a) {
	if ($a->meta['month_name']!=$current_month) {
		echo '<tr class="subheader" data-month="',$a->meta['month'],'"><th colspan="5">',$a->meta['month_name'],'</th></tr>';
		$current_month=$a->meta['month_name'];
	}
	echo '<tr data-month="',$a->meta['month'],'" class="',($count%2==0 ? 'even' : 'odd'),'">';
	echo '<td>';
	echo $a->meta['friendly_date'];
	if (!empty($a->meta['cruise_schedule_booked']))
		echo ' <span class="fully_booked">*</span>';
	echo '</td><td>';
	echo html($a->post_title);
	echo '</td><td class="cruise_type">';
	echo $a->post_content;
	echo '</td><td>';
	echo $a->meta['nights'];
	echo '</td><td class="springtime_',(empty($a->meta['cruise_schedule_spring_time']) ? 'no' : 'yes'),'">';
	echo empty($a->meta['cruise_schedule_spring_time']) ? 'No' : 'Yes';
	echo '</td>';	
	echo '</tr>';
	$count+=1;
}
?>
</tbody>
</table>
<?php
}
echo '</div>';
