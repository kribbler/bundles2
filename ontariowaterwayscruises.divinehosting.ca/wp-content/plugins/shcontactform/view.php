<?php
$email=isset($email) ? $email : '';
$title=isset($title) ? $title : '';
$posthtml=isset($posthtml) ? $posthtml : '';
$prehtml=isset($prehtml) ? $prehtml : '';
$gif=isset($gif) ? $gif : plugins_url().'/shcontactform/images/loading.gif';
$sepname=isset($sepname) ? $sepname : 0;
$phone=isset($phone) ? $phone : 1;
$subject=isset($subject) ? $subject : 1;
$autoreply=isset($autoreply) ? $autoreply : '';
$from=isset($from) ? $from : '';
$emailsubject=isset($emailsubject) ? $emailsubject : 'Contact Form - '.$_SERVER['HTTP_HOST'];

$successmessage=isset($successmessage) ? $successmessage : 'Thank you for your enquiry, we will contact you back shortly.';

$placeholders=isset($placeholders) ? $placeholders : 1;
$labels=isset($labels) ? $labels : 0;

$view=(isset($view)) ? $view : 'default';
//if (basename($view)!=$view || !file_exists(dirname(__FILE__).'/'.$view.'.php'))
//	$view='default';
$id=(isset($id)) ? $id : '';

if (!$email)
	return;

$e=req('emailencrypt');
if ($e) {
	// TODO: Put straight into CRM and create customer
	$e=decrypt($e);
	$dd=$o=allpost();
	if (isset($o['emailsubject']))
		$emailsubject=decrypt($o['emailsubject']);
	$uploads=isset($o['uploads']) ? $o['uploads'] : array();
	$o=(isset($o['data'])) ? $o['data'] : array();
	foreach ($uploads as $aa) {
		$h='';
		if (!empty($o[$aa])) {
			foreach ($o[$aa] as $aaa) {
				if (!is_string($aaa))
					continue;
				$h.='<a href="'.home_url().'/uploads/'.htmlq(urlencode($aaa)).'">'.html(preg_replace('#^[a-f0-9]+\-#i','',$aaa)).'</a><br/>';
			}
			$h=new ishtml($h);	
		}
		$o[$aa]=$h;
	}
	$m=htmlarray($o);
	$sent=false;
	if ($e && $m) {
		$send=true;
		$ar=(isset($dd['autoreply'])) ? decrypt($dd['autoreply']) : '';
		$e=explode(',',$e);
		//hook('contactform',$o,$send,$ar,$dd);
		$checkedemail=false;
		if ($send) {
			foreach ($e as $ee) {
				$ee=trim($ee);
				$headers=array(
					'MIME-Version: 1.0',
					'Content-type: text/html;charset=utf-8',
					'From: '.$from.'<'.$from.'>'
				);
				if (isset($o['Email'])) {
					if ($checkedemail=isemail($o['Email'],true))
						$headers[]='Reply-To: '.$o['Email'].'<'.$o['Email'].'>';
					else
						$send=false;
				}
				if ($send)
					$sent=@mail($ee,$emailsubject,$m,implode("\r\n",$headers));
			}
		}
	}
	// TODO: Send autoreply email, make xml autoreply editor field, make sure links are relative.. or at least put in JURI::root() after processing through xml
	if ($sent)
		echo 'EMAIL_SENT_SUCCESSFULLY';
	exit;
}

if (!function_exists('cfinput')) {
	function cfinput_placeholders($p=NULL) {
		static $ph=false;
		if ($p===NULL)
			return $ph;
		$ph=$p;
	}
	function cfinput_labels($p=NULL) {
		static $ph=false;
		if ($p===NULL)
			return $ph;
		$ph=$p;
	}
	function cfinput($type,$label,$class,$attr='',$name='',$placeholder=false) {
		$n=($name) ? $name : $label;
		static $count=1;
		if ($type=='upload') {
			$multi=strpos($class,'multi')!==false;
			echo '<input type="hidden" name="uploads[]" value="',htmlq($n),'"/>';
			uploadfile('data['.$n.'][]',array(),'uploadid'.$count,'/uploads/',$multi,false);
			$count++;
			return;
		}
		$placeholders=cfinput_placeholders();
		$labels=cfinput_labels();
		$tag='input';
		$putinval=true;
		if ($type=='textarea') {
			$tag='textarea';
			$putinval=false;
			$type='';	
		}
		$attrs=array();
		if ($attr)
			$attrs[]=$attr;
		if ($labels)
			echo '<label><span class="label">',html($label),': </span><span class="input">';
		if ($placeholders && $placeholder!==false)
			$attrs[]='placeholder="'.htmlq($placeholder).'"';
		elseif ($placeholders)
			$attrs[]='placeholder="'.htmlq($label).'"';
		if ($type)
			$attrs[]='type="'.htmlq($type).'"';
		if ($class)
			$attrs[]='class="'.htmlq($class).'"';
		$attrs[]='name="data['.htmlq($n).']"';
		echo '<',$tag,' ',implode(' ',$attrs);
		if ($putinval)
			echo '/>';
		else
			echo '></',$tag,'>';
		if ($labels)
			echo '</span></label>';
	}
}
cfinput_placeholders($placeholders);
cfinput_labels($labels);


$uid=uniqid('contactform');
plugin('jquery');
if ($placeholders)
	plugin('placeholder');
wp_enqueue_script('contactformjs',plugins_url().'/shcontactform/form.js');


$data=array(
	'img'=>'',
	'type'=>'',
	'success'=>$successmessage
);
switch ($data['type']) {
	case 'fancybox':
		plugin('lightbox');
		break;
	case 'spin':
		plugin('spin');
		//$data['col']=$params->get('loadercolour');
		break;
	case 'custom':
		//$data['image']=JURI::root().$params->get('gifimage');
		break;
	default:
		$data['image']=$gif;
		break;
}

$attrs=array();
foreach (array_filter($data) as $k=>$a) {
	if (is_array($a))
		$a=json_encode($a);
	$attrs[]=' data-'.$k.'="'.htmlq($a).'"';
}

// TODO: Add extra control over adding additional fields
?>
<div data-whichform="<?php echo htmlq($id); ?>" class="contactformitem contactform contactform-<?php echo preg_replace('#[^a-z0-9\-]#','',preg_replace('#(\.[^\.]$)#','',strtolower(basename($view)))); ?>" id="cf<?php echo $uid; ?>"<?php echo implode(' ',$attrs); ?>>

<noscript>You need javascript enabled to use this contact form</noscript>
<form method="post" id="<?php echo $uid; ?>"<?php echo (req('tmpl')=='component') ? '' : ' style="display:none"'; ?>>
<input type="hidden" name="emailencrypt" value="<?php echo htmlq(encrypt($email)); ?>"/>
<input type="hidden" name="subjectencrypt" value="<?php echo htmlq(encrypt($emailsubject)); ?>"/>
<?php
$autoreply=trim($autoreply,"\r\n\t ");
if ($autoreply) {
	echo '<input type="hidden" name="autoreply" value="',htmlq(encrypt($autoreply)),'"/>';
}
$template=get_template_directory();
if (file_exists($template.'/shcontactform/'.$view.'.php'))
	include $template.'/shcontactform/'.$view.'.php';
elseif (file_exists(dirname(__FILE__).'/'.$view.'.php'))
	include dirname(__FILE__).'/'.$view.'.php';
elseif (file_exists($template.'/shcontactform/default.php'))
	include $template.'/shcontactform/default.php';
else
	include dirname(__FILE__).'/default.php';
?>
</form>
</div>
<style>
#cf<?php echo $uid; ?>.loading > form > * {
	visibility:hidden;
}
<?php if (!empty($data['image'])) { ?>
#cf<?php echo $uid; ?>.loading > form {
	background:url(<?php echo $data['image']; ?>) 50% 50% no-repeat;
}
<?php } ?>
#cf<?php echo $uid; ?> .invalid {
	border-color:red !important;	
}
#cf<?php echo $uid; ?> .error {
	font-size:12px;	
}
</style>


