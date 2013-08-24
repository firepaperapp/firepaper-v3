<?php
$str='';
foreach($breadcrumbs as $label=>$url){
	if($url):
		$str.="<a href='".SITE_HTTP_URL.$url."' style='color:#ff0000'>".$label."</a>&nbsp;&raquo;&nbsp;";
	else:
		$str.="<span class='c666666'>".$label."</span>";
	endif;
}
echo $str;
?>