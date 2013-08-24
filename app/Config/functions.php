<?php
function validateEmail($stEmail)
{
	$stEmailRegExp = "^[a-z0-9]+([._-][a-z0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
	if(!eregi($stEmailRegExp,$stEmail) || eregi("MIME-Version: ",$stEmail) || eregi("To:",$stEmail) || eregi("Subject:",$stEmail) || eregi("Cc:",$stEmail) || eregi("Bcc:",$stEmail))
	{
		return false;
	}
	else
	{
		/*if(checkdnsrr(array_pop(explode("@",$stEmail)),"MX"))
		{
			return true;
		}
		else
		{
			return false;
		}*/
		return true;
	}
}
// REMOVE SPECIAL CHARACTERS FROM SEARCH STRING
function remove_specialchars($str){
	
	$myreg = "/[^a-z0-9 ]+/i";					
	$keyword = preg_replace($myreg," ",$str);
	
	if(str_word_count($keyword)>1){
		$keyword = preg_replace("/\s+/"," ",$keyword);
	}
	
	return $keyword;
}
function m_DisplayMsg($errMessage,$type)
{
	foreach($errMessage as $errMessage1)
	{
	
		if ($type=='error')
		{
	
			echo '<p class="red testrb">'.$errMessage1.'</p>';
	
		}
		else if ($type=='success')
		{
			echo '<p class="green">'.$errMessage1.'</p></ br>';
		}
	}
}

function addJs(&$javascript, $jsBlock, $mode=1){
	$str = '';
	
	/***************************** Javascript Code *******************************/
	if($mode==1){
			$jsCode = $jsBlock;
			if(isset($jsCode)){
				if(is_array($jsCode) && count($jsCode)>0){
					$str .= '<script type="text/javascript">'."\n";
					foreach($jsCode as $key=>$value){
						echo $str .= $value."; \n";
					}
					$str .='</script>'."\n";
				}
			}
	}
	/***************************** Javascript Files *******************************/
	elseif($mode==2){
		$jsInclude = $jsBlock;
	
		//Important javascript files, These files must be downloaded first before page starts being downloaded.
		$impJs = array('lightbox');
	
		// eg. $this->set('jsInclude',array('Pathofjs'))
		if(isset($jsInclude) && is_array($jsInclude)){
			$strInner = '';
			$strBeforeInner = '';
			$i=1;
			$totalJs = count($jsInclude);
			foreach($jsInclude as $key => $value){
				if (strpos($value, '://')) {
					//include external javascript
					$str .= $javascript->linkOut($value);
				} else {
					$str .= $javascript->link($value);
				}
				$i=$i+1;
			}
			//Bundle javascript to one request to speed up the page.
			if($strInner!='') {
				$strInner = substr($strInner, 0, strrpos($strInner,','));
				$str .= $javascript->link($strInner)."\n";
			}
		}
	}//End mode if
	return $str;
}

function addCss(&$html, $cssBlock){
	$cssInclude = $cssBlock;
	if(isset($cssInclude) && is_array($cssInclude))
	{
		$cssAppend = '';
		$totalCss = count($cssInclude);
		$i=1;
		//Append css with each file name except the last one, because $html->css() will automatically do that.
		foreach($cssInclude as $key => $value)
		{
			$cssAppend .=$html->css($value)."\n";
		}
		return $cssAppend;
	}elseif(isset($cssInclude)){
		$str = '<style type="text/css">'."\n";
		$str .= $cssInclude;
		$str .= '</style>'."\n";
		return $str;
	}
}
function html2txt($document){
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
					'@<[\\/\\!]*?[^<>]*?>@si',            // Strip out HTML tags
					'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
					'@<![\\s\\S]*?--[ \\t\\n\\r]*>@'          // Strip multi-line comments including CDATA
	);
	$text = preg_replace($search, '', $document);
	return $text;
}
/*
Function to check null/empty arrat/variable
@param array/variable need to checked for empty value.
*/
function isNull($str){
	if(is_array($str)){
		if(count($str)==0){
			return true;
		}
	}else{
		$str=trim($str);
		if(!isset($str) || empty($str)){
			return true;
		}
	}
	return false;
}
function date_display($date='',$format=2){
	if(isNull($date) && isNull($format)){
		$date=date('Y-m-d H:i:s');
	}elseif (!isNull($date)){
	   
			switch($format){
				case 1:
					$date=date('d M Y',strtotime($date));
					break;
				case 2:
					$date=date('m/d/Y h',strtotime($date));
					break;
				case 3:
					$date=date('Y-m-d',strtotime($date));
					break;
				default:
					$date=date('F j, Y',strtotime($date));
					break;
			}
		 
	}

	return $date;
}//EF

/**
 * Function to calculate date or time difference.
 *
 * Function to check if user is not logged in
 *
 * @author       Manpreet                           <giddomains@gmail.com>
 * @param        Session Object
 * @param        Session variable
 * @return       true/false
 */
function isUserLoggedIn($sess, $var)
{
	if($sess->check($var) && $sess->read($var)!="")
	{	
		return true;
	}
	return false;
}

/**
 * Function to calculate date or time difference.
 *
 * Function to calculate date or time difference. Returns an array or
 * false on error.
 *
 * @author       J de Silva                             <giddomains@gmail.com>
 * @copyright    Copyright &copy; 2005, J de Silva
 * @link         http://www.gidnetwork.com/b-16.html    Get the date / time difference with PHP
 * @param        string                                 $start
 * @param        string                                 $end
 * @return       array
 */
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}//EF


 function isFileExists($flPath){
	if(is_file($flPath) && file_exists($flPath)){
		return true;
	}else{
		return false;
	}
 }
/*
*
* Function to validate the email address
*
*/

/*
*
* Function to validate the email address
*
*/
function validateCC($ccnum){

    // Clean up input
    $ccnum = ereg_replace('[-[:space:]]', '',$ccnum);


    // What kind of card do we have
    $type = check_type($ccnum);

    // Does the number matchup ?
    $valid = check_number($ccnum);

    return array($type, $valid);

}


// Prefix and Length checks
function check_type( $cardnumber ) {

   $cardtype = "UNKNOWN";

   $len = strlen($cardnumber);
   if     ( $len == 15 && substr($cardnumber, 0, 1) == '3' )                 { $cardtype = "amex"; }
   elseif ( $len == 16 && substr($cardnumber, 0, 4) == '6011' )              { $cardtype = "discover"; }
   elseif ( $len == 16 && substr($cardnumber, 0, 1) == '5'  )                { $cardtype = "mc"; }
   elseif ( ($len == 16 || $len == 13) && substr($cardnumber, 0, 1) == '4' ) { $cardtype = "visa"; }
   elseif ( ($len == 16) && substr($cardnumber, 0, 1) == '35' )              { $cardtype = "JCB"; }

   return ( $cardtype );

}
// MOD 10 checks
function check_number( $cardnumber ) {

    $dig = toCharArray($cardnumber);
    $numdig = sizeof ($dig);
    $j = 0;
    for ($i=($numdig-2); $i>=0; $i-=2){
        $dbl[$j] = $dig[$i] * 2;
        $j++;
    }
    $dblsz = sizeof($dbl);
    $validate =0;
    for ($i=0;$i<$dblsz;$i++){
        $add = toCharArray($dbl[$i]);
        for ($j=0;$j<sizeof($add);$j++){
            $validate += $add[$j];
        }
    $add = '';
    }
    for ($i=($numdig-1); $i>=0; $i-=2){
        $validate += $dig[$i];
    }
    if (substr($validate, -1, 1) == '0') { return 1;  }
    else { return 0; }
}
function ConertUSFormat($phone_number)
{
	if(strlen($phone_number) == 7){
		return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone_number);
	}
	elseif(strlen($phone_number) == 10){
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone_number);
	}
	else{
		return phone_number;
	}

}

function dl_file($file){

    //First, see if the file exists
    if (!is_file($file)) { die("<b>404 File not found!</b>"); }

    //Gather relevent info about file
    $len = filesize($file);
    $filename = basename($file);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    //This will set the Content-Type to the appropriate setting for the file
    switch( $file_extension ) {
          case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      case "mp3": $ctype="audio/mpeg"; break;
      case "wav": $ctype="audio/x-wav"; break;
      case "mpeg":
      case "mpg":
      case "mpe": $ctype="video/mpeg"; break;
      case "mov": $ctype="video/quicktime"; break;
      case "avi": $ctype="video/x-msvideo"; break;

      //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
      case "php":
      case "htm":
      case "html":
      case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

      default: $ctype="application/force-download";
    }

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
   
    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");

    //Force the download
    $header="Content-Disposition: attachment; filename=".$filename.";";
    header($header );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    @readfile($file);
    exit;
}
function addDays($days = 0)
{
    $retDate = date('m-d-Y',mktime(0, 0, 0, date("m")  , date("d")+$days, date("Y")));
    return $retDate;
}
/*********** function for SMF forum**********/
function sha1_smf($str)
	{
		// If we have mhash loaded in, use it instead!
		if (function_exists('mhash') && defined('MHASH_SHA1'))
			return bin2hex(mhash(MHASH_SHA1, $str));

		$nblk = (strlen($str) + 8 >> 6) + 1;
		$blks = array_pad(array(), $nblk * 16, 0);

		for ($i = 0; $i < strlen($str); $i++)
			$blks[$i >> 2] |= ord($str{$i}) << (24 - ($i % 4) * 8);

		$blks[$i >> 2] |= 0x80 << (24 - ($i % 4) * 8);

		return sha1_core($blks, strlen($str) * 8);
	}

	// This is the core SHA-1 calculation routine, used by sha1().
	function sha1_core($x, $len)
	{
		@$x[$len >> 5] |= 0x80 << (24 - $len % 32);
		$x[(($len + 64 >> 9) << 4) + 15] = $len;

		$w = array();
		$a = 1732584193;
		$b = -271733879;
		$c = -1732584194;
		$d = 271733878;
		$e = -1009589776;

		for ($i = 0, $n = count($x); $i < $n; $i += 16)
		{
			$olda = $a;
			$oldb = $b;
			$oldc = $c;
			$oldd = $d;
			$olde = $e;

			for ($j = 0; $j < 80; $j++)
			{
				if ($j < 16)
					$w[$j] = isset($x[$i + $j]) ? $x[$i + $j] : 0;
				else
					$w[$j] = sha1_rol($w[$j - 3] ^ $w[$j - 8] ^ $w[$j - 14] ^ $w[$j - 16], 1);

				$t = sha1_rol($a, 5) + sha1_ft($j, $b, $c, $d) + $e + $w[$j] + sha1_kt($j);
				$e = $d;
				$d = $c;
				$c = sha1_rol($b, 30);
				$b = $a;
				$a = $t;
			}

			$a += $olda;
			$b += $oldb;
			$c += $oldc;
			$d += $oldd;
			$e += $olde;
		}

		return sprintf('%08x%08x%08x%08x%08x', $a, $b, $c, $d, $e);
	}

	function sha1_ft($t, $b, $c, $d)
	{
		if ($t < 20)
			return ($b & $c) | ((~$b) & $d);
		if ($t < 40)
			return $b ^ $c ^ $d;
		if ($t < 60)
			return ($b & $c) | ($b & $d) | ($c & $d);

		return $b ^ $c ^ $d;
	}

	function sha1_kt($t)
	{
		return $t < 20 ? 1518500249 : ($t < 40 ? 1859775393 : ($t < 60 ? -1894007588 : -899497514));
	}

	function sha1_rol($num, $cnt)
	{
		// Unfortunately, PHP uses unsigned 32-bit longs only.  So we have to kludge it a bit.
		if ($num & 0x80000000)
			$a = ($num >> 1 & 0x7fffffff) >> (31 - $cnt);
		else
			$a = $num >> (32 - $cnt);

		return ($num << $cnt) | $a;
	}

	if (!function_exists('sha1'))
	{
		function sha1($str)
		{
			return sha1_smf($str);
		}
	}
/*********** end function for SMF forum**********/
function add_Slashes($passedString)
{
	return addslashes($passedString);
}
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 } 
 //if(!function_exists('mime_content_type')) {

    function mime_content_type_update($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
         
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
//}
?>