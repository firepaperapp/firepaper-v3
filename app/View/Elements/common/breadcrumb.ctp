<?php
$str='';
foreach($breadcrumbs as $label=>$url){
	if($url):
		$str.="<a href='".COMMON_URL.$url."' style='color:#9EB119'>".$label."</a>&nbsp;&raquo;&nbsp;";
	else:
		$str.="<span class='c666666'>".$label."</span>";
	endif;
}
echo $str;
?>