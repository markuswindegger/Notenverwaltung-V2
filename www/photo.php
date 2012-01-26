<?php


require_once('../includes/classes/Conf.class.php');
Conf::init('../etc/conf.xml');

/**
 * Autoload
 */
function autoload($class_name) {
   
   $class = searchFile(Conf::get('classdir'), $class_name.'.class.php');
   if ($class == '') {
      // Classfile not found, fatal error will be raised
   } else {
      require_once($class);
   }
}


function searchFile ($dir, $filename) {
   if ($handle = opendir($dir)) {
      while (false !== ($file = readdir($handle))) {
         if ($file != "." && $file != "..") {

            if ($file == $filename) {
               return $dir.$file;
            }

            if (is_dir($dir.$file)) {
               if ($found = searchFile($dir.$file."/", $filename)) {
                  return $found;
               }
            }
         }
      }
      closedir($handle);
   }
}

spl_autoload_register('autoload');
date_default_timezone_set('Europe/Berlin');
$smarty = new MySmarty();
$smarty->assign('lang', $lang);
$smarty->assign('admitted_languages', $admitted_languages);

require_once(Conf::get('classdir').'/MyError.class.php');

/**
 * Including {@link MyErrorSmartyDisplayHandler}
 */
require_once(Conf::get('classdir').'/MyErrorSmartyDisplayHandler.class.php');
$error_display_handler = new MyErrorSmartyDisplayHandler();
$error_display_handler->setSmarty($smarty);

MyError::setDisplayHandler($error_display_handler);


ob_clean();
if(isset($_REQUEST['id']) && intval($_REQUEST['id'] == $_REQUEST['id']))
    {
	$foto = new Foto();
	if(MyError::isError($error = $foto->loadClass($_REQUEST['id'], true)))
	    {
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
		header("Content-type: " . finfo_file($finfo,'images/devil_256x256.png'));
		finfo_close($finfo);
		echo file_get_contents('images/devil_256x256.png');
		exit;
	    }
	if(!$foto->ausgabeFoto())
	    {
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
		header("Content-type: " . finfo_file($finfo, 'images/devil_256x256.png'));
		finfo_close($finfo);
		echo file_get_contents('images/devil_256x256.png');
		exit;
	    }
    }
?>
