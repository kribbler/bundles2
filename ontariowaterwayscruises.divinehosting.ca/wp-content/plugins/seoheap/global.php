<?php
define('PERMACACHE',dirname(__FILE__).'/cache/permacache/');
define('ROBOT',robotcheck());

plugin('base');

function scramble($t,$key=false) {
	$r=floor(rand(0,255));
	$o='';
	$j=strlen($t);
	$h=0;
	$last=0;
	for ($n=0;$n<$j;$n++) {
		$l=$c=ord($t[$n]);
		$h+=$c;
		$h=$h%255;
		$c=$c^$r;
		$last=$last^$c;
		$o.=chr($c);
	}
	$o=chr($r).chr($last).chr($h).$o;
	return encrypt($o,$key);
}
function descramble($t,$key=false) {
	$t=decrypt($t,$key);
	$r=ord(substr($t,0,1));
	$last=ord(substr($t,1,1));
	$h=ord(substr($t,2,1));
	$t=substr($t,3);
	$o='';
	$j=strlen($t);
	for ($n=$j-1;$n>=0;$n--) {
		$l=$c=ord($t[$n]);
		$nextlast=$last^$c;
		$c=$c^$r;
		if ($h>=$r || $c<$last || $h>$c)
			$end=1;
		else
			$end=0;
		$h-=$l;
		$h=abs($h)%255;
		$o=chr($c).$o;
		$last=$nextlast;
	}
	if ($last!=0)
		return false;
	return $o;
}
function selectbox($name,$opts,$curr=0,$attr='') {
	if (!is_array($opts)) {
		if (empty($name))
			return false;
		echo '<input type="text" readonly="readonly" name="',htmlq($name),'" value="',htmlq($opts),'"/>';
	}
	if (count($opts)<2) {
		foreach ($opts as $k=>$a) {
			echo '<input type="hidden" name="',htmlq($name),'" value="',htmlq($k),'"/>',html($a);
			return;
		}
	}
	echo '<select';
	if (is_array($curr)) {
		echo ' multiple="multiple" title="Ctrl+Click to select multiple options"';
		$name=rtrim($name,'[]').'[]';
	}
	if (!empty($name))
		echo ' name="'.htmlq($name).'"';
	if (!empty($attr))
		echo ' ',trim($attr);
	echo '>';
	foreach ($opts as $k=>$a) {
		echo '<option';
		if ((string)$k!=(string)$a)
			echo ' value="',htmlq($k),'"';
		if (is_array($curr))
			echo (in_array($k,$curr)) ? ' selected="selected"' : '';
		else
			echo ((string)$k===(string)$curr) ? ' selected="selected"' : '';
		echo '>',html($a),'</option>';
	}
	echo '</select>';
}
function printr($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
function nocache() {
	header("Expires: Sun, 14 Mar 1982 07:30:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("Cache-Control: no-store, no-cache, must-revalidate"); 
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");	
}
function json($c) {
	header('Content-Type: application/json');
	nocache();
	echo json_encode($c);
	exit;
}
function plugin($name='') {
	static $plugins=array();
	static $pluginobj=false;
	if (is_object($name))
		return $pluginobj=$name;
	if ($name=='')
		return $pluginobj;
	$name=basename($name);
	if (!$name)
		return;
	if (isset($plugins[$name]))
		return;
	$root=dirname(__FILE__).'/plugins/'.$name;
	if (!is_dir($root) || !is_file($root.'/include.php'))
		return;
	include $root.'/include.php';
	$plugins[$name]=1;
}
function qsql($sql,$parent=false,$flags=0) {
	$s=strtoupper((preg_match('#^\s*([a-z]+)#i',$sql,$r)) ? $r[1] : '');
	if ($s=='INSERT') {
		mysql_query($sql);
		if (mysql_error()) {
			return false;
		}
		return mysql_insert_id();
	} elseif ($s=='SELECT' || $s=='SHOW') {
		$o=array();
		$child=false;
		if (preg_match('#^(.*?)=>(.*?)$#',$parent,$r)) {
			$parent=$r[1];
			$child=$r[2];
		}
		$q=mysql_query($sql);
		if (mysql_error()) {
			return false;
		}
		while ($a=mysql_fetch_assoc($q)) {
			if ($parent===true) {
				$o=$a;
				break;
			} elseif ($parent!==false && ($flags & 1))
				@$o[$a[$parent]]=($child) ? $a[$child] : $a;
			elseif ($parent!==false)
				@$o[$a[$parent]][]=($child) ? $a[$child] : $a;
			 else
				$o[]=($child) ? $a[$child] : $a;
		}
		if (count($o)==0)
			return array();
		return $o;
	} else {
		mysql_query($sql);
		if (mysql_error()) {
			return false;
		}
		return mysql_affected_rows();
	}
}
function sqlq($value) {
	return '\''.mysql_escape_string($value).'\'';
}
function html($i) {
	$i=mb_convert_encoding($i,'HTML-ENTITIES','UTF-8');
	$i=htmlspecialchars($i,NULL,'UTF-8',false);
	//return $i;
	return preg_replace('#£|\xC2\xA3#u','&pound;',$i);
}
function htmlq($i) {
	$i=mb_convert_encoding($i,'HTML-ENTITIES','UTF-8');
	$i=htmlspecialchars($i,ENT_QUOTES,'UTF-8',false);
	//return $i;
	return preg_replace('#£|\xC2\xA3#u','&pound;',$i);
}
function stripslashes_gpc(&$value) {
	$value=stripslashes($value);
}
function req($value,$default='') {
	if (isset($_REQUEST[$value])) {
		if (is_string($_REQUEST[$value]))
			return ((get_magic_quotes_gpc()) ? stripslashes($_REQUEST[$value]) : $_REQUEST[$value]);
		else
			return $_REQUEST[$value];
	}
	return $default;
}
function reqi($value,$default=0) {
	return intval(isset($_REQUEST[$value]) ? $_REQUEST[$value] : $default);
}
function reqf($value,$default=0) {
	return floatval(isset($_REQUEST[$value]) ? $_REQUEST[$value] : $default);
}
function reqa($value,$default=array()) {
	if (!isset($_REQUEST[$value]) || !is_array($_REQUEST[$value]))
		return $default;
	$value=$_REQUEST[$value];
	if (get_magic_quotes_gpc())
	    array_walk_recursive($value,'stripslashes_gpc');
	return $value;
}

function get($value,$default="") {
	return isset($_GET[$value]) ? ((get_magic_quotes_gpc()) ? stripslashes($_GET[$value]) : $_GET[$value]) : $default;
}
function geti($value,$default=0) {
	return intval(isset($_GET[$value]) ? $_GET[$value] : $default);
}
function getf($value,$default=0) {
	return floatval(isset($_GET[$value]) ? $_GET[$value] : $default);
}
function geta($value,$default=array()) {
	if (!isset($_GET[$value]) || !is_array($_GET[$value]))
		return $default;
	$value=$_GET[$value];
	if (get_magic_quotes_gpc())
	    array_walk_recursive($value, 'stripslashes_gpc');
	return $value;
}
function post($value,$default="") {
	if (isset($_POST[$value])) {
		if (is_string($_POST[$value]))
			return ((get_magic_quotes_gpc()) ? stripslashes($_POST[$value]) : $_POST[$value]);
		else
			return $_POST[$value];
	}
	return $default;
}
function posti($value,$default=0) {
	return intval(isset($_POST[$value]) ? $_POST[$value] : $default);
}
function postf($value,$default=0) {
	return floatval(isset($_POST[$value]) ? $_POST[$value] : $default);
}
function posta($value,$default=array()) {
	if (!isset($_POST[$value]) || !is_array($_POST[$value]))
		return $default;
	$value=$_POST[$value];
	if (get_magic_quotes_gpc())
	    array_walk_recursive($value,'stripslashes_gpc');
	return $value;
}
function allpost() {
	$o=$_POST;
	if (get_magic_quotes_gpc())
		array_walk_recursive($o,'stripslashes_gpc');
	return $o;
}
function allget() {
	$o=$_GET;
	if (get_magic_quotes_gpc())
		array_walk_recursive($o,'stripslashes_gpc');
	return $o;
}
function allreq() {
	$o=$_REQUEST;
	if (get_magic_quotes_gpc())
		array_walk_recursive($o,'stripslashes_gpc');
	return $o;
}
class ishtml {
	var $html='';
	function __construct($text) {
		$this->html=$text;
	}
}
function htmlarray($a) {
	ob_start();
	_htmlarray($a);
	$a=ob_get_contents();
	ob_end_clean();
	return $a;
};
function _htmlarray($o) {
	echo '<ul class="htmlarray">';
	foreach ($o as $k=>$a) {
		if (empty($a))
			continue;
		echo '<li><b>',html($k),': </b> ';
		if (is_object($a) && get_class($a)=='ishtml')
			echo $a->html;
		elseif (is_array($a))
			_htmlarray($a);
		else {
			echo html((string)$a);
		}
		echo '</li>';
	}
	echo '</ul>';
}
function tidystring($content) {
	$c=strip_tags($content);
	$c=trim(preg_replace('#[\r\n\s\t]+#',' ',$c));
	$c=trim(preg_replace('#\[[^\]]+\]#','',$c));
	return $c;
}
function snippet($string, $word_limit) {
	$words = explode(' ',tidystring($string));
	return implode(' ', array_slice($words, 0, $word_limit));
}
function _encryptdecrypt($t,$hash=false) {
	$r=sha1(NONCE_SALT.SECURE_AUTH_KEY.AUTH_KEY.$hash);
	$c=0;
	$v='';
	for ($i=0;$i<strlen($t);$i++) {
		if ($c==strlen($r))
			$c=0;
		$v.=substr($t,$i,1)^substr($r,$c,1);
		$c++;
	}
	return $v;
}
function encrypt($t,$hash=false){
	$t=json_encode($t);
	srand((double)microtime()*1000000);
	$r=md5(rand(0,32000));
	$c=0;
	$v='';
	for ($i=0;$i<strlen($t);$i++){
		if ($c==strlen($r))
			$c=0;
		$v.=substr($r,$c,1).(substr($t,$i,1)^substr($r,$c,1));
		$c++;
	}
	return base64_encode(_encryptdecrypt($v,$hash));
}
function decrypt($t,$hash=false) {
	$t=_encryptdecrypt(base64_decode($t),$hash);
	$v='';
	for ($i=0;$i<strlen($t);$i++){
		$md5=substr($t,$i,1);
		$i++;
		$v.=(substr($t,$i,1)^$md5);
	}
	return json_decode($v,true);
}
function opengraph_content() {
	
}
function getforex() {
	$file=dirname(__FILE__).'/cache/forex.json';
	if (!file_exists($file))
		$old=array();
	else
		$old=json_decode(file_get_contents($file),true);
	if (!file_exists($file) || filemtime($file)<(time()-(24*60*60))) {
		$rss=curlconnect('http://currencies.seoheap.com/currencies.json','');
		$rss=json_decode($rss,true);
		$currs=0;
		if (isset($rss['GBP']) && $p=$rss['GBP']) { 
			foreach ($rss as $k=>$a) {
				$old[$k]=$a/$p;
				$currs+=1;
			}
		}
		if (!$currs) {
			@mail('james@seoheap.com','Unable to download currencies','EWS');	
		}
		file_put_contents($file,json_encode($old));
		return $old;
	} else
		return $old;
}
function curlconnect($url,$referer='',$headers=array()) {
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
	curl_setopt($ch,CURLOPT_TIMEOUT,300);
	curl_setopt($ch,CURLOPT_FAILONERROR,1);
	curl_setopt($ch,CURLOPT_MAXREDIRS,10);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_NOBODY,0);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.2) Gecko/20100316 Firefox/3.6.2');
	curl_setopt($ch,CURLOPT_REFERER,$referer);	
	if ($headers) {
		curl_setopt_array($ch,$headers);
	}
	$f=curl_exec($ch);
	curl_close($ch);
	return $f;
}
function email($to,$subject,$message,$from='',$merge=array(),$replyto='') {
	$o=array();
	foreach ($merge as $k=>$a) {
		$o[strtoupper($k)]=$a;
	}
	$message=_email($message,$o);
	$subject=_email($subject,$o);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'X-Mailer:PHP/'.phpversion()."\r\n";	
	if ($from)
		$headers .= 'From: '.$from."\r\n";
	if ($replyto) {
		$replyto=preg_replace('#[\r\n ]+#',' ',$replyto);
		$headers.='Reply-To: '.$replyto."\r\n";	
	}
	return @mail($to,$subject,$message,$headers);
}
function _email($s,$o) {
	$if=preg_match_all('#\{IF ([^\{\}]+)\}(.*?)\{/IF\}#msi',$s,$r);
	foreach ($r[1] as $a) {
		$b=strtoupper(trim($a));
		$not=false;
		if (substr($b,0,1)=='!') {
			$not=true;
			$b=substr($b,1);
		}
		if ((empty($o[$b]) || !!$o['b'])===$not) {
			$s=preg_replace('#\{IF '.preg_quote($a,'#').'\}(.*?)\{/IF\}#msi','$1',$s,1);	
		} else {
			$s=preg_replace('#\{IF '.preg_quote($a,'#').'\}(.*?)\{/IF\}#msi','',$s,1);
		}
	}
	$s=preg_replace('#\{/[^\}]*\}#','',$s);
	while (preg_match('#\{(([a-z])_)?([^\{\}]+)\}#i',$s,$r)) {
		$r[3]=strtoupper($r[3]);
		$t=(isset($o[$r[3]])) ? $o[$r[3]] : '';
		switch (strtoupper($r[2])) {
			case 'H':
				$t=html($t);
				break;
			case 'Q':
				$t=htmlq($t);
				break;
			case 'C':
				$t='&pound;'.number_format(floatval($t),2);
				break;
			case 'I':
				$t=intval($t);
				break;
			case 'F':
				$t=floatval($t);
				break;
		}
		$q='#\{'.$r[1].preg_quote($r[3],'#').'\}#i';
		$s=preg_replace($q,$t,$s);
	}
	return preg_replace('#\{\{#','{',$s);	
}
function jsdata($name,$obj) {
	echo '<script>';
	echo 'var ',$name,'=',json_encode($obj),';';
	echo '</script>';	
}
function ftype($f) {
	$f=basename($f);
	return preg_match('#\.([^\.]+)$#',$f,$r) ? strtolower($r[1]) : '';
}
function uploadimage($inputname,$currentval,$id,$directory,$x=50,$y=0,$multi=false,$enc=false) {
	if (!is_array($enc))
		$enc=array();
	$enc['filetype']='png,gif,jpg';
	$enc['x']=$x;
	$enc['y']=$y;
	$id=str_replace('.','',uniqid($id,true));
	uploadfile($inputname,$currentval,$id,$directory,$multi,$enc);
}
function uploadfile($inputname,$currentval,$id,$directory,$multi=false,$enc=false) {
	if (!is_array($currentval))
		$currentval=($currentval) ? array($currentval) : array();
	if (!$multi && $currentval) {
		$image=array_pop($currentval);
		$currentval=array($image);
	}
	$id=str_replace('.','',uniqid($id,true));
	$e=array(
		'name'=>$inputname,
		'id'=>$id,
		'dir'=>$directory,
		'multi'=>$multi
	);
	if (is_array($enc)) {
		foreach ($enc as $k=>$a) {
			$e[$k]=$a;	
		}
	}
	douploadbox($e,$currentval,$inputname);
}
function douploadbox($enc,$files,$inputname) {
	$id=$enc['id']=preg_replace('/[^a-z0-9]/i','-',$enc['id']);
	static $called=0;
	if (!$called && !empty($enc['multi'])) {
		/*plugin('jqueryui');
		plugin('livequery');
		echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".uploadfile.multi").livequery(function() {
				$("> div",this).sortable();
				$("> div",this).disableSelection();
			});
		});
		</script>';*/
		$called=1;
	}
	echo '<div id="',htmlq($id),'" class="uploadfile',((!empty($enc['multi'])) ? ' multi' : ' single'),'">';
	echo '<div id="',htmlq($id),'_uploads" class="uploadfilecontainer">';
	
	$files=uploads($files,$enc['dir']);

	foreach ($files as $k=>$a) {
		echo '<div>';
		$x=(isset($enc['x'])) ? $enc['x'] : 50;
		$y=(isset($enc['y'])) ? $enc['y'] : 0;		
		if ($a['image'])		
			echo '<img src="',htmlq($a['url'].'thumb.'.$x.'x'.$y.'.'.$a['filename']),'"/>';
		if (isset($enc['labelname'])) {
			$lab=$a['label'];
			echo '<input type="text" name="',htmlq($enc['labelname']),'" value="',htmlq($lab),'" style="padding-left:30px;background:url(/img/label.png) no-repeat 3px 5px;margin-bottom:5px;margin-right:5px"/>';	
		}
		echo '<input type="hidden" name="',htmlq($inputname),'" value="',htmlq($a['input']),'"> <span>',html($a['friendly']),'</span> ';
		echo '<img class="delete" src="/img/trash.png" width="16px" onclick="jQuery(this).parent().remove()" style="cursor:pointer"/>';
		echo '</div>';	
	}
	echo '</div>';
	$enc=rawurlencode(encrypt(json_encode($enc)));
	$path='';
	echo '<iframe width="300px" height="40px" ',((!empty($enc['nosrc'])) ? 'data-' : ''),'src="',home_url(),$path,'?seoheap=uploadframe&data=',$enc,'" frameborder="0" scrolling="no"></iframe>';
	echo '<div class="status"></div>';
	echo '</div>';	
}

function uploads($files,$dir,$stats=false) {
	// if $stats===0, then it'll only print back storage info, i.e. filename, dir and label - that's it.
	// if $stats===-1, then it'll send back an associate array, keyname=link & value=label
	$dir=trim($dir,'/\\');
	if ($dir)
		$dir='/'.$dir;
	$dir.='/';
	$labels=array();
	if (empty($files))
		return array();
	if (is_string($files))
		$files=array($files);
	if (isset($files['labels'])) {
		$labels=$files['labels'];
		unset($files['labels']);
	}
	$n=array();
	foreach ($files as $k=>$a) {
		$ex=0;
		if (substr($a,0,1)=='/')
			$tdir=dirname($a).'/';
		else
			$tdir=$dir;
		$base=basename($a);
		$o=array(
			'filename'=>$base,
			'label'=>(isset($labels[$k])) ? $labels[$k] : '',
			'dir'=>$tdir,
		);
		if ($stats===-1) {
			$n[$o['dir'].$o['filename']]=$o['label'];
			continue;
		} elseif ($stats!==0) {
			$o['input']=$a;
			$o['friendly']=ucwords(str_replace(array('-','_'),' ',preg_replace('/^[a-f0-9]+\-/','',$base)));
			$o['url']=rtrim(home_url(),'/').$tdir;
			$o['filetype']=ftype($base);
			$o['image']=preg_match('#\.(png|jpe?g|gif)#i',$base);
			if (empty($o['label']))
				$o['label']=$o['friendly'];			
		} else {
			if (empty($o['label']))
				unset($o['label']);	
		}
		if (!$ex && $stats!==0 && $stats!==-1) {
			$local=ABSPATH.$tdir.$base;
			$o['local']=$local;
			if ($stats) {
				if (!file_exists($local))
					continue;
				$o['timestamp']=filemtime($local);
				$o['size']=filesize($local);
				$o['display_size']=human_filesize($o['size']);
			}
		}
		$n[]=$o;
	}
	return $n;
}
function cdnpath() {
	$pp='http://staticfiles.co.uk/';
	//if (DEV)
	//	$pp='http://dev.testcdn.com/';
	$pps='https://staticfiles.co.uk/';
	if (!$pp) {
		$pp=$pps;
		$pps='';
	}
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off' && $pps)
		$pp=$pps;
	return rtrim($pp,'/').'/';	
}
function isemail($email,$checkdns=false) {
	$at=strrpos($email,'@');
	if ($at===false)
		return false;
	$domain=substr($email,$at+1);
	$local=substr($email,0,$at);
	if (!$domain || !$local)
		return false;
	$localLen=strlen($local);
	if ($local[0]=='.' || $local[$localLen-1]=='.')	
		return false;
	if (preg_match('/\\.\\./',$local))
		return false;
	if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',str_replace("\\\\","",$local))) {
		if (!preg_match('/^"(\\\\"|[^"])+"$/',str_replace("\\\\",'',$local)))
			return false;
	}
	return true; // TODO: stripit and tldrules
	if (!stripit($domain,$r))
		return false;
	if (isset($r['query']) || $r['scheme']<>'http' || isset($r['port']) || isset($r['user']) || isset($r['pass']) || isset($r['path']) || isset($r['fregment']))
		return false;
	if ($checkdns && !(checkdnsrr($domain,'MX') || checkdnsrr($domain,'A')))
		return false;
	if ($r['host']['ascii']['full']==='googlemail.com')
		$r['host']['ascii']['full']='gmail.com';
	$email=$local.'@'.$r['host']['ascii']['full'];
	hook('email',$email);
	return $email;
}
function span($f,$default=false) {
	static $span=false;
	if ($default===false)
		$span=$f;
	return ($span===false) ? $default : $span;
}
function dosidebar($callback=NULL,$args=array()) {
	static $cb=NULL,$cbargs=array();
	if (is_null($callback)) {
		if (!is_null($cb))
			return call_user_func_array($cb,$cbargs);
		return;
	}
	$cb=$callback;
	$cbargs=$args;
}
function sort_tree($q,$parent='parent',$toarray='children',$start_node=0) {	// TODO: this needs to not include start_node, but should just be smarter by detect what the parents should be
	if (!$q || !is_array($q))
		return array();
	$out=array();
	foreach($q as $key=>$node) {
		if ($node[$parent]==$start_node) {
			$node[$toarray]=sort_tree($q,$parent,$toarray,$key);
			unset($q[$key]);
			$out[]=$node;
		}
	}
	return $out;
}
function _permacachedir() {
	if (!is_dir(PERMACACHE)) {
		@mkdir(PERMACACHE,0777,true);	
	}
	return is_writeable(PERMACACHE);
}
function permacache($type,$hash='') {
	$fn=$type.'_'.$hash;
	$apc=apc();
	if ($apc && apc_exists($apc.$fn)) {
		$f=apc_fetch($apc.$fn);
		if (is_null($f))
			return false;
		return $f;
	}
	$f=PERMACACHE.$fn;
	if (file_exists($f)) {
		$f=json_decode(file_get_contents($f),true);
		if ($apc)
			apc_store($apc.$type.'_'.$hash,$f);
		return $f;
	}
	return NULL;
}
function permasave($type,$data,$hash='') {
	if (!_permacachedir())
		return;
	$apc=apc();
	if ($apc)
		apc_store($apc.$type.'_'.$hash,$data);
	file_put_contents(PERMACACHE.$type.'_'.$hash,json_encode($data));
}
function permaupdated($type,$hash='') {
	if (!$type)
		return;
	if (!_permacachedir())
		return;
	$apc=apc();
	if (!$hash)
		$t=glob(PERMACACHE.$type.'_'.$hash.'*');
	else
		$t=glob(PERMACACHE.$type.'_*');
	if ($t) {
		foreach ($t as $a) {
			if ($apc)
				apc_delete($apc.basename($a));
			@unlink($a);
		}
	}
}
function apc() {
	return false;
}
function slider($set=NULL) {
	static $slider=true; // true is auto
	if (!is_null($set))
		$slider=$set;
	return $slider;
}
function getrelated($id,$limit=false) {
	if (!class_exists('Related') || !is_numeric($id))
		return array();
	static $related=array();
	if (isset($related[$id.$limit]))
		return $related[$id.$limit];
    $rel=qsql('SELECT post_id,meta_value FROM wp_postmeta WHERE meta_key=\'related_posts\' AND (post_id='.$id.' OR meta_value LIKE \'%"'.$id.'"%\')');
	$ret=array();
	foreach ($rel as $a) {
		$m=unserialize($a['meta_value']);
		if ($m) {
			foreach ($m as $aa) {
				if (is_numeric($aa))
					$ret[$aa]=$aa;
			}
		}
		$ret[$a['post_id']]=$a['post_id'];
	}
	unset($ret[$id]);
	if (!$ret)
		return $related[$id.$limit]=$ret;
	$posts=array();
	$posttypes=array('sermons','ministries','post','incsub_event','people');
	if ($limit) {
		foreach ($posttypes as $posttype) {
			query_posts(array(
				'post_type'=>$posttype,
				'post__in'=>$ret,
				'orderby'=>'post_date',
				'order'=>'DESC',
				'posts_per_page'=>$limit
			));
			global $post;
			while ( have_posts() ) : the_post();
				if (!isset($posts[$post->post_type]))
					$posts[$post->post_type]=array();
				$posts[$post->post_type][$post->ID]=$post;
			endwhile;
			wp_reset_query();			
		}
	} else {
		query_posts(array(
			'post_type'=>$posttypes,
			'post__in'=>$ret,
			'orderby'=>'post_date',
			'order'=>'DESC',
			'posts_per_page'=>-1
		));
		global $post;
		while ( have_posts() ) : the_post();
			if (!isset($posts[$post->post_type]))
				$posts[$post->post_type]=array();
			$posts[$post->post_type][$post->ID]=$post;
		endwhile;
		wp_reset_query();
	}
	return $related[$id.$limit]=$posts;
}
function testcaptcha() {
	if (!isset($_SESSION['captchapassed'])) {
		$captchapassed=0;
		foreach ($_REQUEST as $k=>$a) {
			if (preg_match('#^captcha\-([a-f0-9]{32})(.+)$#',$k,$r)) {
				$a=strtoupper($a);
				$hash=decrypt($r[2],$r[1]);	
				if (expired($hash) && captchacode($r[1].$r[2])==$a)
					$captchapassed=$_SESSION['captchapassed']=1;
				else {
					unset($_SESSION['captchapassed']);
					$captchapassed=0;
				}
			}
		}
	} else
		$captchapassed=$_SESSION['captchapassed'];
	define('CAPTCHA',$captchapassed);
	return $captchapassed;
}
function robotcheck() {
	static $robot=0;
	if (is_bool($robot))
		return $robot;
	$ua=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	$robot=false;
	if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) || preg_match('#(msnbot|slurp|googlebot|teoma|jeeves|wget|xget|crawl|bot|spider|baidu|yandex|finder|libwww|perl|ia_archiver|twiceler|nutch|bing|httpclient|proxy\-cache|mj12|^java/|^[-\s\.]*$|google web preview|appengine\-google)+#',$ua))
		$robot=true;
	return $robot;
}
function captcha($attr='',$vars=array()) {
	$code=expiry(time()+(16*60*60));
	$c=md5(microtime());
	$c=$c.encrypt($code,$c);
	$vars=($vars) ? '&'.http_build_query($vars) : '';
	echo '<img src="/captcha/captcha.png?code=',urlencode($c),htmlq($vars),'" alt="Captcha" class="captchaimg"/>';
	echo '<input type="text" name="captcha-',htmlq($c),'" ',$attr,'/>';
}
function captchacode($md5) {
	$q='ABCDEFGHJKLMNPQRTWXY346789';
	$l=strlen($q);
	$j=strlen($md5);
	$v=str_split(md5(decrypt($q)));
	for ($n=0;$n<$j;$n++) {
		$r=ord($md5[$n]);
		$a=$r % 5;
		$v[$a]+=$r;
	}
	$k='';
	for ($n=0;$n<5;$n++) {
		$a=$v[$n] % $l;
		$k.=$q[$a];	
	}
	return $k;
}
function youtubeid($url) {
	$url=trim($url);
	$url=preg_replace('#^([^\#]+)\#.*$#','$1',$url);
	if (preg_match('#^[\w-]{10,12}$#',$url))
		return $url;
	$youtubepattern ='%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch.*v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
	$y=(preg_match($youtubepattern,$url,$m)) ? $m[1] : false;
	return $y;
}