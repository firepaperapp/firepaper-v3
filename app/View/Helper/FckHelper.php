<?php class FckHelper extends HtmlHelper {
var $Width = 520;
var $Height = 350;

function load($id, $width=null, $height=null, $toolbar = 'Default') {
$did = Inflector::camelize(str_replace('/', '_', $id));
if($width){ $this->Width = $width; }
if($height){ $this->Height = $height; }
$js = $this->request->webroot.'js/';
return <<<FCK_CODE
<script type="text/javascript">
fckLoader_$did = function () {
	var bFCKeditor_$did = new FCKeditor('$did');
	bFCKeditor_$did.BasePath = '$js';
	bFCKeditor_$did.ToolbarSet = '$toolbar';
	bFCKeditor_$did.Width=$this->Width;
	bFCKeditor_$did.Height=$this->Height;	
	bFCKeditor_$did.ReplaceTextarea();
}
fckLoader_$did();
</script>
FCK_CODE;
	}
}
?>