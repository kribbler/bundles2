<?php
wp_enqueue_script('cruise-schedule','/wp-content/plugins/sh-cruises/schedule.js');

$months=array(
	'January'=>false, // if false at end hide if none
	'February'=>false,
	'March'=>false,
	'April'=>false,
	'May'=>0,
	'June'=>0,
	'July'=>0,
	'August'=>0,
	'September'=>0,
	'October'=>0,
	'November'=>false,
	'December'=>false,
	'TBA'=>false
);
foreach ($this->items as $a) {
	$months[$a->meta['month_name']]+=1;
}

echo '<div class="schedule_view">';
echo '<div class="schedule_view_header">View</div>';
echo '<ul class="months">';
$count=0;
foreach ($months as $k=>$a) {
	$count+=1;
	if ($a===false)
		continue;
	if ($a>0)
		echo '<li><a href="#" data-month="',$count,'">',$k,'</a></li>';
	else
		echo '<li>',$k,'</li>';
}
echo '</ul>';
echo '<ul class="years">';
$min=date('Y');
if (date('m')>10)
	$min+=1;
if (!$this->year)
	$this->year=$min;
if ($min<$this->year)
	echo '<li><a href="#" class="year" data-year="',($this->year-1),'" data-cruise="',$this->cruise,'" class="previous">',($this->year-1),'</li>';
echo '<li class="active">',$this->year,'</li>';
echo '<li><a href="#" class="year" data-year="',($this->year+1),'" data-cruise="',$this->cruise,'" class="next">',($this->year+1),'</a></li>';
echo '</ul>';
echo '</div>';