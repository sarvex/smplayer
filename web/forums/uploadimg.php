<?php

  /**
   * Automatic Image Upload with Thumbnails - uploadimg.php
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
		

		
        if (!in_array($pun_user['g_title'], $Allow_Uploads)) {
                 message($lang_uploadimg['No permission']);
                                                         }
                                                         
                                                         



//********************
		


?>
<div id="uploadimg" class="blockform">
	<h2><span><?php echo $lang_uploadimg['Upload image']; ?></span></h2>
	<div class="box">
	

  <form id="uploadimg" method="post" action="uploadimg.php?subpage=upload" enctype="multipart/form-data">


			
			<div class="inform">
				<fieldset>
					<legend><?php if ($_GET['subpage'] == "upload") { echo $lang_uploadimg['Result']; } else {echo $lang_uploadimg['Select image']; } ?></legend>
					<div class="infldset">
					
					
							<?php


$limit_sizef = $limit_size*1024; // convert Kilobytes to bytes
$file_prefix = $pun_user['id']."_"; // the pun user id is used as the prefix for all uploaded files
$absolute_path_images = dirname(__FILE__) . "/" . substr_replace($idir,"",-1);
$absolute_path_thumbs = dirname(__FILE__) . "/" . substr_replace($tdir,"",-1);

  //find forumurl:
  $domain = $_SERVER['HTTP_HOST']; // find out the domain:
  $path = $_SERVER['SCRIPT_NAME']; // find out the path to the current file:
  $urltemp = "http://" . $domain . $path ; // put it all together:
  $parts = Explode('/', $path);
  $currentFile = end($parts);
  $forumurl = substr($urltemp, 0, strpos($urltemp, "$currentFile"));


 	 function strip_ext($name)
  	 {
  	     $ext = strrchr($name, '.');
 	     if($ext !== false)
 	     {
	         $name = substr($name, 0, -strlen($ext));
 	     }
 	     return $name;
 	 }


//****
$check = $allow_jpg_uploads + $allow_png_uploads + $allow_gif_uploads;

   $i = 0;

   if ($allow_jpg_uploads == "1"){
   $type_array[$i]= "JPEG";
   $i = $i + 1;
   }

   if ($allow_png_uploads == "1"){
   $type_array[$i]= "PNG";
   $i = $i + 1;
   }

   if ($allow_gif_uploads == "1"){
   $type_array[$i]= "GIF";
   $i = $i + 1;
   }

if ($check == 0){
$message1 = $lang_uploadimg['Upload disabled'];
$message2 = "";
}

if ($check == 1){
$message1 = str_replace('<type1>', $type_array[0], $lang_uploadimg['Can only upload1']);
$message2 = str_replace('<extension1>', $type_array[0], $lang_uploadimg['Has to be1']);
$message2 = " ".$message2;
}

if ($check == 2){
$message1 = str_replace('<type1>', $type_array[0], $lang_uploadimg['Can only upload2']);
$message1 = str_replace('<type2>', $type_array[1], $message1);
$message2 = str_replace('<extension1>', $type_array[0], $lang_uploadimg['Has to be2']);
$message2 = str_replace('<extension2>', $type_array[1], $message2);
$message2 = " ".$message2;
}

if ($check == 3){
$message1 = str_replace('<type1>', $type_array[0], $lang_uploadimg['Can only upload3']);
$message1 = str_replace('<type2>', $type_array[1], $message1);
$message1 = str_replace('<type3>', $type_array[2], $message1);
$message2 = str_replace('<extension1>', $type_array[0], $lang_uploadimg['Has to be3']);
$message2 = str_replace('<extension2>', $type_array[1], $message2);
$message2 = str_replace('<extension3>', $type_array[2], $message2);
$message2 = " ".$message2;
}

if ($size_limit != "yes"){
$message3 = $lang_uploadimg['No size limit'];
}
else {
$message3 = str_replace('<MAX_SIZE>', $limit_size, $lang_uploadimg['Size limit']);
}

//****

if (!isset($_GET['subpage']) || $_FILES['imagefile']['name'] == null) {   // Image Upload Form Below   ?>
 
 <p><?php echo $lang_uploadimg['Upload message']; ?>
 </p>
  <p>
  <br><b><?php echo $lang_uploadimg['Restrictions']; ?></b>
  <br><?php echo $message1; ?>
  <?php 
  if ($resize_images_above_limit == "yes" && $size_limit == "no") {
  echo "<br>".str_replace('<MAX_SIZE>', $limit_size, $lang_uploadimg['Images above']);
  }
  else {
  echo "<br>".$message3;
  }
  ?>
  
  <br>
  </p>
  <p>
  <br></p>
  
  <form method="post" action="uploadimg.php?subpage=upload" enctype="multipart/form-data">
   <?php echo $lang_uploadimg['File']; ?><br />
  <input type="file" name="imagefile" class="form">
  
  <?php if ($allow_resize_option == "1") { ?>
	<br><br>
	<select size="1" name="resizeoption">
	<option>100x75 (<?php echo $lang_uploadimg['Avatar']; ?>)</option>
	<option>160x120 (<?php echo $lang_uploadimg['Thumbnail']; ?>)</option>
	<option selected>320x240 (<?php echo $lang_uploadimg['Websites and email']; ?>)</option>
	<option>640x480 (<?php echo $lang_uploadimg['Message boards']; ?>)</option>
	</select><br><br>
	<input type="checkbox" name="resizeimage" value="ON">&nbsp;<?php echo $lang_uploadimg['Resize image']; ?>
 <?php } ?>



  <br><br>
  <input type="submit" name="uploadimg" value="<?php echo $lang_common['Submit'] ?>" accesskey="s" />
  <br />

  
  
  <p>
      
    
    </p>
  
<? } 




if ((isset($_GET['subpage'])) && (!empty($_FILES['imagefile']['name']))) {   // Uploading/Resizing Script

  $imagefilename = $_FILES['imagefile']['name'];
  $imagefilename_rl = strip_ext($imagefilename);
  $imagefilename_ext = strtolower(end(explode('.',$imagefilename))); // get the file extension
  
  // transliterate all characters with accents,umlauts,ligatures and runes known to ISO-8859-1
  $imagefilename_rl = strtr($imagefilename_rl,"\xA1\xAA\xBA\xBF\xC0\xC1\xC2\xC3\xC5\xC7\xC8\xC9\xCA\xCB\xCC\xCD\xCE\xCF\xD0\xD1\xD2\xD3\xD4\xD5\xD8\xD9\xDA\xDB\xDD\xE0\xE1\xE2\xE3\xE5\xE7\xE8\xE9\xEA\xEB\xEC\xED\xEE\xEF\xF0\xF1\xF2\xF3\xF4\xF5\xF8\xF9\xFA\xFB\xFD\xFF","!ao?AAAAACEEEEIIIIDNOOOOOUUUYaaaaaceeeeiiiidnooooouuuyy");   
  $imagefilename_rl = strtr($imagefilename_rl, array("\xC4"=>"Ae", "\xC6"=>"AE", "\xD6"=>"Oe", "\xDC"=>"Ue", "\xDE"=>"TH", "\xDF"=>"ss", "\xE4"=>"ae", "\xE6"=>"ae", "\xF6"=>"oe", "\xFC"=>"ue", "\xFE"=>"th"));
  
  // strip all non-alphanumeric characters (except _ -) from string and replace all spaces with _ (underscore)
  $find = array("/[^a-zA-Z0-9\-\_\s]/","/\s+/");
  $replace = array("","_");
  $imagefilename_rl = strtolower(preg_replace($find,$replace,$imagefilename_rl));
  $imagefilename = $imagefilename_rl.".".$imagefilename_ext;
  
  $url = $file_prefix . $imagefilename;   // Set $url To Equal The Filename For Later Use
  if ((($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg") && ($allow_jpg_uploads == "1")) || (($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png") && ($allow_png_uploads == "1")) || (($_FILES['imagefile']['type'] == "image/gif") && ($allow_gif_uploads == "1"))) {
  


$nameoffile = $file_prefix.$imagefilename;


if(file_exists("$absolute_path_images/$nameoffile")) {


echo $lang_uploadimg['File exists']."<br>";   

echo "<br>".$lang_uploadimg['Exist message']." <b>".$_FILES['imagefile']['name']."</b><br>\n";

?>
<div style="padding: 5px 6px">
<img src="<?php echo ("$tdir$file_prefix$imagefilename"); ?>">
</div>
<?php

       echo "<br>".$lang_uploadimg['Copy and paste'].": <br>
       <textarea name='select' rows='6' cols='100'>
[url=".$forumurl.$idir.$file_prefix.$imagefilename."]
[img]".$forumurl.$tdir.$file_prefix.$imagefilename."
[/img][/url]
</textarea>
</p>";

  
}
else{ 

// the file does not exist - can now be uploaded ****


  
if (($size_limit == "yes") && ($limit_sizef < $_FILES['imagefile']['size'])) { // file size must be less than $limit_sizef ****
      echo str_replace('<MAX_SIZE>', $limit_size, $lang_uploadimg['Too big']);
} else {

// Allocate all necessary memory for the image
ini_set('memory_limit', '-1');
  
    
    
    if (!empty($_FILES['imagefile']['tmp_name'])) {   

      
      if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg") {
      $simg = imagecreatefromjpeg($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbnail From
      }
      if ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png") {
      $simg = imagecreatefrompng($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbnail From
      }
      if ($_FILES['imagefile']['type'] == "image/gif") {
      $simg = imagecreatefromgif($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbnail From
      }
      
      $currwidth = imagesx($simg);   // Current Image Width
      $currheight = imagesy($simg);   // Current Image Height
      
      
      
         $zoomw = $currwidth/$twidth;
         $zoomh = $currheight/$theight;

            if ($zoomw > $zoomh) {
              $zoom = $zoomw;
                      }

            else {
              $zoom = $zoomh;
                }

           $newwidth = $currwidth/$zoom;
           $newheight = $currheight/$zoom;

    
      if ($currwidth < $twidth ) {    // If the Current Image Width is Less than the Thumbnail Width ****
      $dimg = imagecreate($currwidth, $currheight);   // Make New Image ****
      $copy = copy($_FILES['imagefile']['tmp_name'], "$tdir" . $file_prefix . $imagefilename);   // Move Image From Temporary Location To Permanent Location ****
      
      
      }
      
else {

      
      $dimg = @imagecreatetruecolor( $newwidth, $newheight );   // Make New Image For Thumbnail
      
      if (!$dimg) { 
      $dimg = imagecreate( $newwidth, $newheight ); 
      }
      
    imagecopyresampled( $dimg, $simg,
						0,0,0,0,
						$newwidth, $newheight, $currwidth, $currheight );   // Copy Resized Image To The New Image (So We Can Save It)
    
    
      if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg") {
      imagejpeg($dimg, "$tdir" . $url,85);   // Saving The Image
      }
      if ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png") {
      imagejpeg($dimg, "$tdir" . $url,85);   // Saving The Image
      }
      if ($_FILES['imagefile']['type'] == "image/gif") {
      imagejpeg($dimg, "$tdir" . $url,85);   // Saving The Image
      }
      
}
      

      
      			if (($resize_images_above_limit == "yes") && ($limit_sizef < $_FILES['imagefile']['size']) && (!isset($_POST['resizeimage']))) {
			             if ($currwidth > $currheight) {
			               $jwidth = "640";   // Maximum Width For Resized Images
                     $jheight = "480";   // Maximum Height For Resized Images
                                   }
                   else {
                   	 $jwidth = "480";   // Maximum Width For Resized Images
                     $jheight = "640";   // Maximum Height For Resized Images
                                   }
                                   
                                   
			          }
      
      
   if (isset($_POST['resizeimage'])) {
   
	    $dimparts = Explode(' ', $_POST['resizeoption']);
	    $resizedim = $dimparts [0];
            
			      if ($resizedim == "100x75") {
			             if ($currwidth > $currheight) {
			               $jwidth = "100";   // Maximum Width For Resized Images
                     $jheight = "75";   // Maximum Height For Resized Images
                                   }
                   else {
                   	 $jwidth = "75";   // Maximum Width For Resized Images
                     $jheight = "100";   // Maximum Height For Resized Images
                                   }
			         }
			      if ($resizedim == "160x120") {
			             if ($currwidth > $currheight) {
			               $jwidth = "160";   // Maximum Width For Resized Images
                     $jheight = "120";   // Maximum Height For Resized Images
                                   }
                   else {
                   	 $jwidth = "120";   // Maximum Width For Resized Images
                     $jheight = "160";   // Maximum Height For Resized Images
                                   }
			         }
		          if ($resizedim == "320x240") {
			             if ($currwidth > $currheight) {
			               $jwidth = "320";   // Maximum Width For Resized Images
                     $jheight = "240";   // Maximum Height For Resized Images
                                   }
                   else {
                   	 $jwidth = "240";   // Maximum Width For Resized Images
                     $jheight = "320";   // Maximum Height For Resized Images
                                   }
			         }
		          if ($resizedim == "640x480") {
			             if ($currwidth > $currheight) {
			               $jwidth = "640";   // Maximum Width For Resized Images
                     $jheight = "480";   // Maximum Height For Resized Images
                                   }
                   else {
                   	 $jwidth = "480";   // Maximum Width For Resized Images
                     $jheight = "640";   // Maximum Height For Resized Images
                                   }
			         }
			}
			


			

//============= RESIZE IMAGE CODE START =============
      if (isset($jwidth)) {
      
      
      

      //resize image
      
      //----create resized image start
      

    
	       $zoomw = $currwidth/$jwidth;
         $zoomh = $currheight/$jheight;

            if ($zoomw > $zoomh) {
              $zoom = $zoomw;
                      }

            else {
              $zoom = $zoomh;
                }
            
            if (($currwidth < $jwidth) && ($currheight < $jheight)) {
            $zoom = "1";
            }    

           $newwidth = $currwidth/$zoom;
           $newheight = $currheight/$zoom;
           

      
      
        $jdimg = @imagecreatetruecolor( $newwidth, $newheight );   // Make New Image
        $gd_flag = "0";
      
        if (!$jdimg) { 
        $jdimg = imagecreate( $newwidth, $newheight );
        $gd_flag = "1";
        }

    			imagecopyresampled( $jdimg, $simg,
						0,0,0,0,
						$newwidth, $newheight, $currwidth, $currheight );   // Copy Resized Image To The New Image (So We Can Save It)
    
      if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg") {
      imagejpeg($jdimg, "$idir" . $url,85);   // Saving The Image
      }
      if ($_FILES['imagefile']['type'] == "image/png" || $_FILES['imagefile']['type'] == "image/x-png") {
          if ($gd_flag != "1") {
              imagetruecolortopalette($jdimg, TRUE, 256);  // convert to 256 colors
              }
      imagepng($jdimg, "$idir" . $url);   // Saving The Image
      }
      if ($_FILES['imagefile']['type'] == "image/gif") {
          if ($gd_flag != "1") {
              imagetruecolortopalette($jdimg, TRUE, 256);  // convert to 256 colors
              }
      imagegif($jdimg, "$idir" . $url);   // Saving The Image
      }
      
      
      imagedestroy($jdimg);   // Destroying The Temporary Image
      //----create resized image end
    
      
            
      
      
      
      }
      
      else {
      $copy = move_uploaded_file($_FILES['imagefile']['tmp_name'], "$idir" . $file_prefix . $imagefilename);   // Move Image From Temporary Location To Permanent Location

      }
      
//============= RESIZE IMAGE CODE END =============
      
      
      imagedestroy($simg);   // Destroying The Temporary Image
      imagedestroy($dimg);   // Destroying The Other Temporary Image
      
      
      echo $lang_uploadimg['Successful upload']."<br />";   // Was Able To Successfully Upload Image
      echo $lang_uploadimg['Successful thumbnail']."<br>";   // Resize successful
      
      //only delete image if thumb doesn't exist
      if(file_exists("$absolute_path_images/$nameoffile")) {
                   if(!file_exists("$absolute_path_thumbs/$nameoffile")) {
                    unlink($idir.$nameoffile);
                    }
               }
               
               
      //only delete thumb if image doesn't exist
      if(file_exists("$absolute_path_thumbs/$nameoffile")) {
                   if(!file_exists("$absolute_path_images/$nameoffile")) {
                    unlink($tdir.$nameoffile);
                    }
               }


    
    } else {
      echo "<font color=\"#FF0000\">".$lang_uploadimg['Unable to upload']."</font>";   // Error Message If Upload Failed
    }
  
  
?>
<div style="padding: 5px 6px">
<img src="<?php echo ("$tdir$file_prefix$imagefilename"); ?>">
</div>
<?php


      echo "<br>".$lang_uploadimg['Copy and paste'].": <br>
       <textarea name='select' rows='6' cols='100'>
[url=".$forumurl.$idir.$file_prefix.$imagefilename."]
[img]".$forumurl.$tdir.$file_prefix.$imagefilename."
[/img][/url]
</textarea>
</p>";
      


  }
  
  

  } 
  
  } else {
    echo "<font color=\"#FF0000\">".$lang_uploadimg['Wrong filetype'].$message2.". ".$lang_uploadimg['Yours is']." ";   // Error Message If Filetype Is Wrong
    // Show The Invalid File's Extention
    echo "<b>".$_FILES['imagefile']['type']."</b></font>";  
  }
} 



?>

						
					</div>
				</fieldset>
				
			</div>
			
			
			<?
			if (!isset($_GET['subpage']) || $_FILES['imagefile']['name'] == null) {     ?>
			
			<p align="right"><a href="uploadimg_view.php?view=gallery"><?php echo $lang_uploadimg['My uploads']; ?></a></p>
			
			<?php 
			if (in_array($pun_user['g_title'], $Allow_Stats)) {
			?>
                   <p align="right"><a href="uploadimg_stats.php"><?php echo $lang_uploadimg['Upload statistics']; ?></a></p>
             <?php 
              }
			
			} ?>
			
		
		</form>
	</div>
</div>
<?php

require PUN_ROOT.'footer.php';

?>

