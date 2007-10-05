<?php

  /**
   * Automatic Image Upload with Thumbnails - uploadimg_view.php
   * 
   * @author : Koos
   * @email  : pampoen10@yahoo.com
   * @version 1.3.2
   * @release date : 2007-05-26
   */

  /* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY
   * OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
   * LIMITED   TO  THE WARRANTIES  OF  MERCHANTABILITY,
   * FITNESS    FOR    A    PARTICULAR    PURPOSE   AND
   * NONINFRINGEMENT.  IN NO EVENT SHALL THE AUTHORS OR
   * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES
   * OR  OTHER  LIABILITY,  WHETHER  IN  AN  ACTION  OF
   * CONTRACT,  TORT OR OTHERWISE, ARISING FROM, OUT OF
   * OR  IN  CONNECTION WITH THE SOFTWARE OR THE USE OR
   * OTHER DEALINGS IN THE SOFTWARE.
   */
   
   


include "uploadimg_config.php";


define('PUN_ROOT', './');


require PUN_ROOT.'include/common.php';

// Load the uploadimg.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/uploadimg.php';


// Detect two byte character sets
$multibyte = (isset($lang_common['lang_multibyte']) && $lang_common['lang_multibyte']) ? true : false;




$page_title = pun_htmlspecialchars($pun_config['o_board_title']).' / '.$lang_uploadimg['Upload image'];



require PUN_ROOT.'header.php';


			if ($pun_user['is_guest']) {
		message($lang_common['Not logged in']);
		}


$showdel=1;
$searchadmin = $_GET['id'];

if (!empty($searchadmin)){ //if not empty, your are a visitor
$preid = $searchadmin;

        $result_view = $db->query('SELECT id, username FROM '.$db->prefix.'users WHERE id = '.$preid);
        $krydit = $db->fetch_assoc($result_view);
        $displayname = $krydit ['username'];
        
                if (empty($displayname)){
        $displayname = $lang_uploadimg['Deleted user'];
        }



		if (!in_array($pun_user['g_title'], $Allow_Stats)) {
                   message($lang_common['No permission']);
            }

if ($pun_user['g_id'] == "1" || $searchadmin == $pun_user['id']) {
$showdel=1;
}
else {
$showdel=0;
}

}


else {
$preid = $pun_user['id'];
$displayname = $pun_user['username'];
}




$file_prefix = $preid."_"; // the pun user id is used as the prefix for all uploaded files

$prefix_length = strlen($file_prefix);
$absolute_path_images = dirname(__FILE__) . "/" . substr_replace($idir,"",-1);
$absolute_path_thumbs = dirname(__FILE__) . "/" . substr_replace($tdir,"",-1);

  //find forumurl:
  $domain = $_SERVER['HTTP_HOST']; // find out the domain:
  $path = $_SERVER['SCRIPT_NAME']; // find out the path to the current file:
  $urltemp = "http://" . $domain . $path ; // put it all together:
  $parts = Explode('/', $path);
  $currentFile = end($parts);
  $forumurl = substr($urltemp, 0, strpos($urltemp, "$currentFile"));


//delete file:
$deletethis = $_GET['deletefile'];

if (!empty($deletethis)){

 $partsf = Explode('_', $deletethis);
 $dienr = $partsf[0];
 
if (($dienr == $pun_user['id'] || $pun_user['g_id'] == "1") && (in_array($pun_user['g_title'], $Allow_Delete))){

      //only delete image if it exists
      if(file_exists("$absolute_path_images/$deletethis")) {
       unlink($idir.$deletethis);
               }

      //only delete thumb if it exists
      if(file_exists("$absolute_path_thumbs/$deletethis")) {
       unlink($tdir.$deletethis);
               }

     
}


}



function prefix( $word, $prefix) {
        if ( strlen($word) < strlen($prefix)) {
                $tmp = $prefix;
                $prefix = $word;
                $word = $tmp;
        }

        $word = substr($word, 0, strlen($prefix));

        if ($prefix == $word) {
                return 1;
        }

        return 0;
}





// Color of alternate rows on the index page.  

//$RowColor = "#e9e9e9";



$Exclude_File = array();
//
// Listed below are two file names that are automatically excluded from the listings.  
// 
$Exclude_File[] = ".htaccess";
$Exclude_File[] = "index.php";
$Exclude_File[] = "readme.txt";



$Exclude_Folder = array();
//
// Listed below is a folder name that is automatically excluded from the listings.  
//
// $Exclude_Folder[] = "MY_FOLDER";
//
$Exclude_Folder[] = "Restricted";



$Exclude_Extension = array();
//
// Listed below is an extension that automatically excludes ANY file with this extension from the listings.  
//
// $Exclude_Extension[] = "MY_EXTENSION";
//
$Exclude_Extension[] = "hidden";



// set all GET/POST vars
if($HTTP_GET_VARS) 
{ 
	foreach($HTTP_GET_VARS as $key => $val) 
	{ 
		$$key = $val;
	}
}
// Get all vars from the POST method.  Assign variable and value
if($HTTP_POST_VARS) 
{ 
	foreach($HTTP_POST_VARS as $key => $val) 
	{ 
		$$key = $val;
	}
}

// get file extension
function GetExt($val) {
	
	$val = strtolower($val);
	switch($val) {
	case "gif";
		$type = "GIF";
		$image = "uploadimg_icon.gif";
		break;
	case "jpg";
		$type = "JPEG";
		$image = "uploadimg_icon.gif";
		break;
	case "jpeg";
		$type = "JPEG";
		$image = "uploadimg_icon.gif";
		break;
    case "png";
		$type = "PNG";
		$image = "uploadimg_icon.gif";
		break;
	//--- New Here---//
	default:
		$type = $lang_uploadimg['Unknown filetype'];
		$image = "uploadimg_icon.gif";
	}
	// return both values (to be split)
	return $type."?".$image;
}



// Path to icon folder with ending slash
$iconfolder = $forumurl;

$_GLOBAL['image'] = "";

// Open folder directory
if(!isset($fdir)) {
	$fdir = "./".$idir;
}
$fdir = str_replace("../", "", $fdir);

// check to see if still inside directory boundry
$check = substr($fdir, 0, 2);
if($check != "./") {
	$fdir = "./";
}

// setup file properties class
class File_Properties
{
	var $file_name;		// just the file name
	var $file_ext;		// file extension
	var $file_size;		// size of file
	var $file_dim;		// image dimesions
	var $file_date;		// date modified
	var $file_icon;		// icon for file type
	var $file_type;		// short description for file type

	// constructor method - build object
	function Build($file)
	{
		$this->setFname($file);
		$this->setFext($file);
		$this->setFsize($file);
		$this->setFdim($file);
		$this->setFdate($file);
		$this->setFicon_type();
	}

	// Set file name
	function setFname($file)
	{
		$this->file_name = basename($file);
	}
	// set file extension
	function setFext($file)
	{
		$this->file_ext = array_pop(explode('.', $file));
	}
	// set file size
	function setFsize($file)
	{
		$kbs = filesize($file) / 1024;
		if (($kbs < 1) && ($kbs > 0)) {
		$kbs = 1;
		}
		$this->file_size = $kbs;
	}
	// set image dimensions
	function setFdim($file)
	{
        $fsize = getimagesize($file);
        $fwidth = $fsize[0];
        $fheight = $fsize[1];
        $farea = $fheight*$fwidth;
		$this->file_dim = $farea;
	}
	// set date modified
	function setFdate($file)
	{
		$modified = filectime($file);
		//$this->file_date = format_time($modified);
		$this->file_date = $modified;
	}
	// set file type
	function setFicon_type()
	{
		list($this->file_type, $this->file_icon) = split("\?", GetExt($this->file_ext), 2);
	}

	// setup all get/return methods for class vars
	function getFname()
	{
		return $this->file_name;
	}
	function getFext()
	{
		return $this->file_ext;
	}
	function getFsize()
	{
		return $this->file_size;
	}
	function getFdim()
	{
		return $this->file_dim;
	}
	function getFdate()
	{
		return $this->file_date;
	}
	function getFicon()
	{
		return $this->file_icon;
	}
	function getFtype()
	{
		return $this->file_type;
	}
}



// initialize file and folder arrays
$file_array = array();
$dir_array = array();
$Fname_array = array();
$Dname_array = array();

// open directory
$dir = opendir($fdir);

// Read files into array
while(false !== ($file = readdir($dir))) 
{	
	if($file != "." && $file != ".." && prefix($file,$file_prefix)) 
	{	
		$type = filetype($fdir.$file);
		$info = pathinfo($file);
		if($type != "dir")
		{
			if(isset($info["extension"]))
			{
				$file_extension = $info["extension"];
			}
		}
		
		if($type == "dir" && !in_array($file, $Exclude_Folder)) 
		{
			// setup folder object
			$This_Dir = new Folder_Properties;
			$This_Dir->Build($fdir.$file);
			$dir_array[] = $This_Dir;
		}
		elseif($type == "file" && !in_array($file, $Exclude_File) && !in_array($file_extension, $Exclude_Extension))
		{
			// setup file object
			$This_File = new File_Properties;
			$This_File->Build($fdir.$file);
			$file_array[] = $This_File;
		}
	}
}
closedir($dir);

// Set default sort by method
if(!isset($SortBy) || $SortBy != 0 && $SortBy != 1) {
	$SortBy = 1;
}

// Number of the column to sort by (0-4) set default to 0
if(!isset($NumSort) || $NumSort != 0 && $NumSort != 1 && $NumSort != 2 && $NumSort != 3 && $NumSort != 4) {
	$NumSort = 4;
}

// determin object sorting methods
switch($NumSort) 
{
	case 0;
		$Fsort_method = "file_name";
		$Dsort_method = "dir_name";
	break;
	case 1;
		$Fsort_method = "file_size";
		$Dsort_method = "dir_name";
	break;
	case 2;
		$Fsort_method = "file_type";
		$Dsort_method = "dir_name";
	break;
	case 3;
		$Fsort_method = "file_dim";
		$Dsort_method = "dir_name";
	break;
	case 4;
		$Fsort_method = "file_date";
		$Dsort_method = "dir_date";
	break;
	default:
		$Fsort_method = "file_name";
		$Dsort_method = "dir_name";
}

// object sorting functions
function ASC_sort_file_objects($a, $b) 
{
	global $Fsort_method;
	$obj1 = strtolower($a->$Fsort_method);
	$obj2 = strtolower($b->$Fsort_method);
   	if ($obj1 == $obj2) return 0;
    return ($obj1 < $obj2) ? -1 : 1;
}
function ASC_sort_dir_objects($a, $b) 
{
	global $Dsort_method;
	$obj1 = strtolower($a->$Dsort_method);
	$obj2 = strtolower($b->$Dsort_method);
   	if ($obj1 == $obj2) return 0;
   	return ($obj1 < $obj2) ? -1 : 1;
}
function DESC_sort_file_objects($a, $b) 
{
	global $Fsort_method;
	$obj1 = strtolower($a->$Fsort_method);
	$obj2 = strtolower($b->$Fsort_method);
   	if ($obj1 == $obj2) return 0;
    return ($obj1 > $obj2) ? -1 : 1;
}
function DESC_sort_dir_objects($a, $b) 
{
	global $Dsort_method;
	$obj1 = strtolower($a->$Dsort_method);
	$obj2 = strtolower($b->$Dsort_method);
   	if ($obj1 == $obj2) return 0;
   	return ($obj1 > $obj2) ? -1 : 1;
}

// sort ascending
if($SortBy == 0) {
	// sort arrays (ASCENDING)
	usort($file_array, 'ASC_sort_file_objects');
	usort($dir_array, 'ASC_sort_dir_objects');
	
	$arrow = "&#9650;";
	$SortBy = 1;
	$sortbyopp = 0;
}
// sort descending
else {
	// sort arrays (DESCENDING)
	usort($file_array, 'DESC_sort_file_objects');
	usort($dir_array, 'DESC_sort_dir_objects');
	
	$arrow = "&#9660;";
	$SortBy = 0;
	$sortbyopp = 1;
}




		
								                  if (!empty($searchadmin)) {
			                                  $addthis = "&id=$preid";
			                                  }
			
			                             else {
			                               $addthis = "";
			                                   } 
			                                   
			                    
		


?>
 

<script type="text/javascript"> 
function confirmdelete() { 
 return confirm("<?php echo $lang_uploadimg['Delete confirm']; ?>");   
} 
</script> 



<?php 
//------------list view start------------

$getnumsort = $_GET['NumSort'];


if (($_GET['view']) == "list") {



?>
	<div id="users1" class="blocktable">
		<div class="box">
		<div class="inbox">
	<h2><span><?php echo $displayname." - ".$lang_uploadimg['Uploads']; ?></span></h2>
	
	
	<?php

echo "
    
    <table table cellspacing='0'>
    		<thead>
      <tr>
        <th width='29%' align='left'><a href='uploadimg_view.php?view=list$addthis&NumSort=0&SortBy=$SortBy'>".$lang_uploadimg['Filename']." $arrow</a></th>
        <th width='10%' align='center'><a href='uploadimg_view.php?view=list$addthis&NumSort=1&SortBy=$SortBy'>".$lang_uploadimg['Size']."</a></th>
        <th width='10%' align='center'><a href='uploadimg_view.php?view=list$addthis&NumSort=2&SortBy=$SortBy'>".$lang_uploadimg['Filetype']."</a></th>
        <th width='10%' align='center'><a href='uploadimg_view.php?view=list$addthis&NumSort=3&SortBy=$SortBy'>".$lang_uploadimg['Dimensions']."</a></th>";
        
        
        if ((in_array($pun_user['g_title'], $Allow_Delete)) && ($showdel)) {
        echo "
        <th width='19%' align='left'><a href='uploadimg_view.php?view=list$addthis&NumSort=4&SortBy=$SortBy'>".$lang_uploadimg['Date']."</a></th>
        <th width='7%'>&nbsp;</td>
        <th width='7%'>&nbsp;</td>";
        }
       else {
       echo "
            <th width='23%' align='left'><a href='uploadimg_view.php?view=list$addthis&NumSort=4&SortBy=$SortBy'>".$lang_uploadimg['Date']."</a></th>
        <th width='10%'>&nbsp;</td>";
       }
        
        
    echo "    
      </tr>
      </thead>
      <tbody>
";





$othernum = 0;


// alternate row counter
$count = 0;


// output file info
for($y = 0; $y < count($file_array); $y++)
//while (list($key, $val) = each($Fname_array))
{


	// alternate row colors
	if($count % 2 != 0) {
		$special = "bgcolor='$RowColor'";
	}
	else {
		$special = "";
	}
	$count++;
	
	$filenm = $file_array[$y]->getFname();
    $isize = getimagesize("$idir$filenm");
    $iwidth = $isize[0];
    $iheight = $isize[1];

	echo "
		    
	<tr>
        <td width='29%' align='left'><img src=\"uploadimg_icon.gif\">&nbsp;<a href=\"".$idir.$file_array[$y]->getFname()."\">".substr($file_array[$y]->getFname(),$prefix_length)."</td>
        <td width='10%' align='center'>".round($file_array[$y]->getFsize(), 0)." ".$lang_uploadimg['Kilobyte']."</td>
        <td width='10%' align='center'>".$file_array[$y]->getFtype()." ".$lang_uploadimg['Image']."</td>
        <td width='10%' align='center'>".$iwidth."x".$iheight."</td>";
        
        if ((in_array($pun_user['g_title'], $Allow_Delete)) && ($showdel)) {
        
        echo "
        <td width='19%' align='left'>".format_time($file_array[$y]->getFdate())."</td>
        <td width='7%' align='center'><a href=\"".$forumurl."uploadimg_view.php?filename=".$file_array[$y]->getFname() . "\">".$lang_uploadimg['Get code']."</a></td>
        <td width='7%' align='center'>
        <a href=\"uploadimg_view.php?view=list$addthis&NumSort=$NumSort&SortBy=$sortbyopp&deletefile=".$file_array[$y]->getFname()."\" onClick=\"return confirmdelete();\">".$lang_uploadimg['Delete']."</a>
        </td></tr>";
        }
        else {
        echo "<td width='23%' align='left'>".format_time($file_array[$y]->getFdate())."</td>
        <td width='10%'><a href=\"".$forumurl."uploadimg_view.php?filename=".$file_array[$y]->getFname() . "\">".$lang_uploadimg['Get code']."</a></td>
      </tr>
	";
        }
        
        
        
        
}





echo "
	    </tbody>
	</table>
	</div>
	</div>
	</div>


";

			                        
	?>
	
		<div class="linksb">
	<div class="inbox">
	

<p class="pagelink">
<?php
echo "<a href='uploadimg_view.php?view=gallery$addthis'>".$lang_uploadimg['View as gallery']."</a>";
?>
</p>
	
		


	</div>
</div>

	<?
	

	
	
}
//------------list view end------------
?>






<?php 
//------------gallery view start------------

if (($_GET['view']) == "gallery") {

		$rows = $images_per_row;
		$row = "0"; ?>
		
<script type="text/javascript">

function highlight(field) {
        field.focus();
        field.select();
}

</script>
		
<div class="block">
	<h2><span><?php echo $displayname." - ".$lang_uploadimg['Uploads']; ?></span></h2>
		<div class="box">
			<div class="inbox">
<center>
<table cellpadding="0">
<tr>

<?php



$othernum = 0;


// alternate row counter
$count = 0;


$num_pages = ceil(count($file_array) / $images_per_page);
if (!empty($_GET['p'])){
$p = $_GET['p'];
}
else {
$p = 1;
}


$koos2 = (($p-1)*$images_per_page) + $images_per_page;

if ($koos2 > count($file_array)){
$koos2 = count($file_array);
}

// output file info
for($y = (($p-1)*$images_per_page); $y < $koos2; $y++)
//while (list($key, $val) = each($Fname_array))
{
	// alternate row colors
	if($count % 2 != 0) {
		$special = "bgcolor='$RowColor'";
	}
	else {
		$special = "";
	}
	$count++;


$filenm = $file_array[$y]->getFname();


//only display thumbnail if it exists:
if(file_exists("$absolute_path_thumbs/$filenm")){

$getcode = "[url=".$forumurl.$idir.$filenm."][img]".$forumurl.$tdir.$filenm."[/img][/url]";
$getimg = "[img]".$forumurl.$idir.$filenm."[/img]";
$geturi = "$forumurl$idir$filenm";
$boxwidth = $twidth - 4;



             if($row == $rows)
            {
            echo"</tr>";
            if ($display_img_box == "0") {
            //display Thumb code only start
			echo "<td style=\"text-align: center;border: 0px;\">";
            
            if ((in_array($pun_user['g_title'], $Allow_Delete)) && ($showdel)) {
  echo "<p><a href=\"uploadimg_view.php?view=gallery$addthis&p=$p&deletefile=".$file_array[$y]->getFname()."\" onClick=\"return confirmdelete();\" style=\"text-decoration:none\">".$lang_uploadimg['Delete cap']."</a></p>";
            }
            
          echo "
            <a href=".$idir.$file_array[$y]->getFname()."><img src=\"".$tdir.$file_array[$y]->getFname()."\"></a><br><INPUT onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0; width: ".$boxwidth."px;\" value=\"".$getcode."\" readonly><br><br></td>";
			//display Thumb code only end
            }
            else {
            //display Thumb and Image code start
            echo "<td style=\"text-align: center;border: 0px;\">";
            
            if ((in_array($pun_user['g_title'], $Allow_Delete)) && ($showdel)) {
  echo "<p><a href=\"uploadimg_view.php?view=gallery$addthis&p=$p&deletefile=".$file_array[$y]->getFname()."\" onClick=\"return confirmdelete();\" style=\"text-decoration:none\">".$lang_uploadimg['Delete cap']."</a></p>";
            }
            
          echo "
            <a href=".$idir.$file_array[$y]->getFname()."><img src=\"".$tdir.$file_array[$y]->getFname()."\"></a><br><div align=\"center\"><table style=\"width: 10%; margin: 1px; \"><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><b>".$lang_uploadimg['Thumb'].":&nbsp;</b></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><INPUT onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getcode."\" readonly></td></tr><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><b>".$lang_uploadimg['Image'].":</b></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><INPUT onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getimg."\"></td></tr></table></div><br><br></td>";
            //display Thumb and Image code end
            }
            $row="1";
            }
        else
        {
            
            if ($display_img_box == "0") {
            //display Thumb code only start
			echo "<td style=\"text-align: center;border: 0px;\">";
            
            if ((in_array($pun_user['g_title'], $Allow_Delete)) && ($showdel)) {
  echo "<p><a href=\"uploadimg_view.php?view=gallery$addthis&p=$p&deletefile=".$file_array[$y]->getFname()."\" onClick=\"return confirmdelete();\" style=\"text-decoration:none\">".$lang_uploadimg['Delete cap']."</a></p>";
            }
            
          echo "
            <a href=".$idir.$file_array[$y]->getFname()."><img src=\"".$tdir.$file_array[$y]->getFname()."\"></a><br><INPUT onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0; width: ".$boxwidth."px;\" value=\"".$getcode."\" readonly><br><br></td>"; 
            //display Thumb code only end
            }
            else {
            //display Thumb and Image code start
            echo "<td style=\"text-align: center;border: 0px;\">";
            
            if ((in_array($pun_user['g_title'], $Allow_Delete)) && ($showdel)) {
  echo "<p><a href=\"uploadimg_view.php?view=gallery$addthis&p=$p&deletefile=".$file_array[$y]->getFname()."\" onClick=\"return confirmdelete();\" style=\"text-decoration:none\">".$lang_uploadimg['Delete cap']."</a></p>";
            }
            
          echo "
            <a href=".$idir.$file_array[$y]->getFname()."><img src=\"".$tdir.$file_array[$y]->getFname()."\"></a><br><div align=\"center\"><table style=\"width: 10%; margin: 1px; \"><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><b>".$lang_uploadimg['Thumb'].":&nbsp;</b></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><INPUT onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getcode."\" readonly></td></tr><tr><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><b>".$lang_uploadimg['Image'].":</b></td><td style=\"text-align: left; margin: 0; border: 0px; padding: 2px; \"><INPUT onmouseup=\"highlight(this);\" onclick=\"highlight(this);\" style=\"border: 1px solid #808080; border-right: 0; border-bottom: 0;\" value=\"".$getimg."\"></td></tr></table></div><br><br></td>";
            //display Thumb and Image code end
            }            
            $row++;
        }



	
	}
}
echo "
</tr></table>
</center>
			</div>
		</div>
	</div>";
	
	
	?>
	<div class="linksb">
	<div class="inbox">
	
		<p class="pagelink">
		
		<?php
		
$paging_links = $lang_common['Pages'].': '.paginate($num_pages, $p, 'uploadimg_view.php?view=gallery'.$addthis);
echo $paging_links;
?>

</p>

<p class="pagelink">
<?php
echo "<a href='uploadimg_view.php?view=list$addthis'>".$lang_uploadimg['View as list']."</a>";
?>
</p>
	
		

		
		
	</div>
</div>

<?php

}

//------------gallery view end------------
?>


<?php

//------------code view start------------

if (!empty($_GET['filename']))  {

?>


			
<div id="uploadimg_view" class="blockform">
<h2><span><?php echo $displayname." - ".$lang_uploadimg['Uploads']; ?></span></h2>
<div class="box">
	
<form id="uploadimg_view" method="post" action="uploadimg_view.php?subpage=upload" enctype="multipart/form-data">
			
			
			
				<div class="inform">
				<fieldset>
				<legend><?php echo $lang_uploadimg['Copy and paste']; ?></legend>
				<div class="infldset">
			
			
<?php
$imagefilename = $_GET['filename'];
?>
<div style="padding: 5px 6px">
<img src="<?php echo ("$tdir$imagefilename"); ?>">
</div>
			
			<?php

echo "<br>
       <textarea name='select' rows='6' cols='100'>
[url=".$forumurl.$idir.$_GET['filename']."]
[img]".$forumurl.$tdir.$_GET['filename']."
[/img][/url]
</textarea>
  ";



echo "
			</div>
			</fieldset>
			</div>
			
			<p align=\"right\"><a href=\"javascript: history.go(-1)\">".$lang_uploadimg['Back']."</a> </p>

			
			</form>
		</div>
	</div>";


}



//------------code view end------------
?>



<?php

require PUN_ROOT.'footer.php';

?>