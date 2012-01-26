<?php

/**
 * Initialization module
 *
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.5 $
 */


/**
 * Including {@link Conf}
 */
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

set_time_limit(0);
session_name('PHP_'.Conf::get('cookie_name'));
session_start();
ob_start();

$admitted_languages = array('de', 'it');

$default_lang = Conf::get('defaultLanguage');
$lang = $default_lang;

if (isset($_POST['newlang_hidden'])) {
   if (in_array($_POST['newlang_hidden'], $admitted_languages)) {
      $_SESSION['lang'] = $_POST['newlang_hidden'];
      $lang = $_POST['newlang_hidden'];
   } else {
      $_SESSION['lang'] = $default_lang;
      $lang = $default_lang;
   }
} else {
   if (isset($_SESSION['lang'])) {
      $lang = $_SESSION['lang'];
   } else {
      $lang = $default_lang;
      $_SESSION['lang'] = $lang;
   }
}

if ($lang == 'it') {
   putenv('LANG=it_IT');
   setlocale(LC_MESSAGES, 'it_IT.UTF-8');
   setlocale(LC_NUMERIC, 'it_IT.UTF-8');
   setlocale(LC_TIME, 'it_IT.UTF-8');
} elseif ($lang == 'de') {
   putenv('LANG=de_DE');
   setlocale(LC_MESSAGES, 'de_DE.UTF-8');
   setlocale(LC_NUMERIC, 'de_DE.UTF-8');
   setlocale(LC_TIME, 'de_DE.UTF-8');
}

date_default_timezone_set('Europe/Berlin');
/**
 * Including {@link MySmarty.class.php} class
 */
require_once(Conf::get('classdir').'/MySmarty.class.php');
$smarty = new MySmarty();
$smarty->assign('lang', $lang);
$smarty->assign('admitted_languages', $admitted_languages);

/**
 * Including {@link MyError} class
 */
require_once(Conf::get('classdir').'/MyError.class.php');

/**
 * Including {@link MyErrorSmartyDisplayHandler}
 */
require_once(Conf::get('classdir').'/MyErrorSmartyDisplayHandler.class.php');
$error_display_handler = new MyErrorSmartyDisplayHandler();
$error_display_handler->setSmarty($smarty);

MyError::setDisplayHandler($error_display_handler);

require_once(Conf::get('incdir').'/index.inc.php');


?>