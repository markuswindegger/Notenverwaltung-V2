<?php

/**
 * Front Controller
 *
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.8 $
 */


$smarty->assign('URL', Conf::get('url_suffix'));
$smarty->assign('style_sheet', 'gen_style');
$smarty->assign('debug', Conf::get('debug'));
$smarty->assign('act_page', htmlspecialchars($_SERVER['REQUEST_URI']));

$page = NULL;


if (isset($_GET['page']) && 
    ($_GET['page'] == 'style.gen_style' || $_GET['page'] == 'js.gen_js')) {
   $page = strip_tags(trim($_GET['page']));

} elseif (isset($_COOKIE[Conf::get('cookie_name')]) && !isset($_GET['page'])) {
   $page = 'start';

  } elseif (!isset($_GET['page']) || trim($_GET['page']) == "") {
   
   if (isset($_GET['page']) && strpos($_GET['page'], 'ajax') !== FALSE) {
      header('HTTP/1.1 403 Forbidden');
      exit();
   }

   $page = 'start';
} else {
   $page = $_GET['page'];
   $page_id = @$_GET['pageid'];
}

if (strpos($page, 'ajax') !== FALSE) {
    $page = str_replace('.', '/', $page);
     
    $can_page = realpath(Conf::get('moduledir').'/'.$page.'.inc.php');
     
    if (strpos($can_page, realpath(Conf::get('moduledir'))) === FALSE) {
	header('HTTP/1.1 404 Not Found');
	exit();
    } else {
	include(Conf::get('moduledir').'/'.$page.'.inc.php');
    }
     
    exit();
 }



//getting a blockquote from the database
$con = AppDBO::getInstance();
/********************************************************************
 * selectquery to get the data from tha database
 *******************************************************************/
$selectquery="Select * from Zitat order by RAND() LIMIT 1";
if(!($stm = $con->query($selectquery)))
    {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
    }

if($agdet = $stm->fetch())
    {
	$zitat['text'] = $agdet['zitat'];
	$zitat['autor'] = $agdet['autor'];
    }
else
    {
	$zitat['text'] = "1";
	$zitat['autor'] = "2";
    }
$stm->closeCursor();
$smarty->assign('zitat', $zitat);


//getting the news from the database
/********************************************************************************************
$news = array();

$selectquery="SELECT * FROM News WHERE valid = 1 ORDER BY datum DESC LIMIT 3";
if(!($stm = $con->query($selectquery)))                                                                                                                                                                                              
    {                                                                                                                                                                                                                                  
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
    }
$counter = 3;
while($agdet = $stm->fetch())
    {
	$datum = new Datetime($agdet['datum']);
	$news[$counter]['datum'] = $datum;
	$news[$counter]['text'] = $agdet['beschreibung'];
	--$counter;
    }
$stm->closeCursor();
$smarty->assign('news', $news);
**************************************************************************************/
/**************************************************************************************************
 * This is the pattern to read something out of a file for the news field
//Testing, if somethig should be written to the news field...
if(is_readable(Conf::get('datadir').'/news.txt'))
    {
	@$file = fopen(Conf::get('datadir').'/news.txt', 'r');
	if($file)
	    {
		$news = array();
		$counter = 0;
		while($zeile = fgets($file))
		    {
			$daten = explode(';', $zeile);
			$news[$counter]['datum'] = $daten[0];
			$news[$counter]['text'] = $daten[1];
			++$counter;
		    }
		$smarty->assign('news', $news);
	    }
    }

*****************************************************************************************************/

//checking the login state
if(!isset($_SESSION['benutzer']))
    {
	$_SESSION['benutzer'] = new Benutzer();
    }
$smarty->assign('user', $_SESSION['benutzer']);


if(!isset($_SESSION['zeitraum']))
    {
      if(MyError::isError($zeitraum = ZeitraumListe::getAktuellenZeitraum()))
	{
	  return MyError::raiseError("Problem beim Bestimmen des aktuellen Zeitraums", SQL_ERROR, $zeitraum->getErrorMsg());
	}
      $_SESSION['zeitraum'] = $zeitraum;
    }
$smarty->assign('zeitraum', $_SESSION['zeitraum']);




// Verifying the $_GET['page'] parameter  
$page = str_replace('.', '/', $page);

$can_page = realpath(Conf::get('moduledir').'/'.$page.'.inc.php');


if (strpos($can_page, realpath(Conf::get('moduledir'))) === FALSE) {
    if ($page == 'style.gen_style' || $page == 'js.gen_js') {
	header('HTTP/1.1 404 Not Found');
	exit();
    } else {

	$err = MyError::raiseError(gettext('err_404'), SYS_ERROR,
				   Conf::get('moduledir').'/'.$page.'.inc.php');
	$err->displayMessage();
      
	if ($page != 'style.gen_style' && $page != 'js.gen_js') {
	    $smarty->addTemplate('header', 'header.tpl', 'logo');
	    $smarty->addTemplate('footer', 'footer.tpl');
	    $smarty->mergeInto('stylesheets', 'style.css');
         
	} else {
	    exit();
	}
    }

 } else {

    if (Conf::get('debug')) {
	include(Conf::get('moduledir').'/'.$page.'.inc.php');
    } else {
	@include(Conf::get('moduledir').'/'.$page.'.inc.php');
    }

    if ($page != 'style.gen_style' && $page != 'js.gen_js') {
	$smarty->addTemplate('header', 'header.tpl', 'logo');
	$smarty->addTemplate('footer', 'footer.tpl');
      
	$smarty->mergeInto('stylesheets', 'style.css');

    } else {
	exit();
    }
 }


   
$output = ob_get_contents();
ob_clean();



$smarty->displayPage('main.tpl');
echo $output;




function handleAjaxRequest() {

  global $page, $smarty;

}

function vdmp($array) {
   echo "<br><br><pre>";
   var_dump($array);
   echo "</pre><br><br>";
}


function strarg($str)
{
   $tr = array();
   $p = 0;

   for ($i=1; $i < func_num_args(); $i++) {
      $arg = func_get_arg($i);

      if (is_array($arg)) {
         foreach ($arg as $aarg) {
            $tr['%'.++$p] = $aarg;
         }
      } else {
         $tr['%'.++$p] = $arg;
      }
   }

   return strtr($str, $tr);
}


function translate($string)
{
   $arg = array();
   for($i = 1 ; $i < func_num_args(); $i++)
       $arg[] = func_get_arg($i);
  
   return vsprintf(gettext($string), $arg);
}
                                                  



?>