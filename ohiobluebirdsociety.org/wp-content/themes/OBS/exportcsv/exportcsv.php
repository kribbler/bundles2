<?php
$conn = mysql_connect("localhost","ohioblue_asif","asif123");
$selectdb = mysql_select_db("ohioblue_wrdp2",$conn);
$selectorders = "select o.id,p.title,o.status,o.payment_date,o.payer_mail,o.payer_fname,o.payer_lname,o.payer_country,o.gross,o.state,o.city,o.address,o.zip,o.phone,o.gender from wwm_orders o left join wwm_plans p ON  o.planid = p.id";
$resultorders = mysql_query($selectorders);
$num=mysql_num_rows($resultorders);
//Start Download 
if($num > 0 )
{
	if(isset($_GET["download"]))
	{
			            function cleanData(&$str) 
						{ 
						 $str = preg_replace("/\t/", "\\t", $str); 
						 $str = preg_replace("/\n/", "\\n", $str); 
						} 
						# file name for download 
						Header("Content-Disposition: attachment; filename=export.xls");
						Header("Content-Type: application/vnd.ms-excel");  
						$flag = false;	
						while($row = mysql_fetch_assoc($resultorders))
						{
							if(!$flag) { 
								# display field/column names as first row
									 $col=array("ORDER ID"=>"0","PLAN NAME"=>"1","STATUS"=>"2","PAYMENT DATE"=>"3","EMAIL"=>"4","FIRST NAME"=>"5","LAST NAME"=>"6","COUNTY"=>"7","AMOUNT"=>"8","STATE"=>"9","CITY"=>"10","ADDRESS"=>"11","ZIP"=>"12","PHONE"=>"13","GENDER"=>"14",);
									echo implode("\t", array_keys($col)) . "\n"; 
									$flag = true; 
									  } 
						array_walk($col, 'cleanData'); 
						echo implode("\t", array_values($row)) . "\n"; 
						} 
						exit;
	}
}
//End Download
?>
<html>
<body>
<div style="float:left;border:0px solid red;">
		<div style="float:left;border:0px solid red;width:830px;">
		<h2>Click on the following link for exporting the csv :&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php $_SERVER['PHP_SELF'] ?>?download=download" style='color:#ED5C0C;font-size:21px;text-underline:none;text-decoration:none;' title="Convert to Excel  Sheet">Export to csv</a>
		</h2> <br/>
        
</div>
</div>
</body>
</html>