<?php

/**
 * Contiene la classe {@link MyErrorSmartyDisplayHandler}
 * 
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.4 $
 */

/**
 * Include della classe {@link MyErrorDisplayHandler}
 */
require_once(Conf::get('classdir').'/MyErrorDisplayHandler.class.php');


/**
 * Classe per visualizzare i messaggi d'errore generati con {@link MyError}
 * in formato html con l'aiuto di Smarty
 */
class MyErrorSmartyDisplayHandler extends MyErrorDisplayHandler {


   protected $smarty;
   
   protected $message_template = 'errors/message.tpl';


   /**
    * Setta l'istanza di smarty da utilizzare per visualizzare i
    * messaggi d'errore
    *
    * @param Smarty $smarty Istanza della classe {@link Smarty}
    */
   public function setSmarty (Smarty $smarty) {

      $this->smarty = $smarty;
   }
   
   /**
    * Setta il template da utilizzare per la visualizzazione dei messaggi
    *
    * @param string $template Nome del template smarty da utilizzare
    *
    */
   public function setTemplate($template) {
      
      $this->message_template = $template;
   }

   
   /**
    * Visualizza i messaggi d'errore corti
    *
    * @param MyError $error Errore
    */
   public function displayShortError (MyError $error) {


      $this->smarty->assign('message', 
                            $error->getMessage());
      $this->smarty->assign('mess_type', 'error');
      $this->smarty->addTemplate('errors', $this->message_template);

   }



   /**
    * Visualizza i messaggi corti per errori fatali
    *
    * @param MyError $error Errore
    */
   public function displayShortFatalError (MyError $error) {
      
      ob_clean();
      $this->smarty->assign('fatal_error', TRUE);
      $this->smarty->assign('message', $error->getMessage());
      $this->smarty->assign('mess_type', 'error');
      $this->smarty->addTemplate('errors', $this->message_template);
      
      ob_clean();
      $this->smarty->displayPage('errors/main.tpl');
      die();
   }



   /**
    * Visualizza i messaggi corti per warning
    *
    * @param MyError $error Errore
    */
   public function displayShortWarning ( MyError $error) {

      $this->smarty->assign('message', $error->getMessage());
      $this->smarty->assign('mess_type', 'warning');
      $this->smarty->addTemplate('errors', $this->message_template);
   }


   
   /**
    * Visualizza i messaggi lunghi per errori
    *
    * @param MyError $error Errore
    */
   public function displayLongError (MyError $error) {

      $message = "<b>".gettext('err_mess').":</b> ".$error->getMessage().
         "<br/><br/>";
      
      $message .= "<b>".gettext('err_dett_mess').":</b> ".
         htmlspecialchars($error->getAdditionalInfo())."<br/><br/>";

      $message .= "<b>".gettext('err_script_name').":</b> ".
         $error->getFile()." <br/><br/>";

      $message .= "<b>".gettext('err_script_line')."</b>: ".$error->getLine().
         "<br/><br/>";

      $message .= "<b>Trace:</b>".
         $this->getFormatedBacktrace($error->getBacktrace());

      $this->smarty->assign("message", $message);
      $this->smarty->assign("mess_type", "error");
      $this->smarty->addTemplate('errors', $this->message_template);

   }

   
   /**
    * Visualizza i messaggi lunghi per errori fatali
    *
    * @param MyError $error Errore
    */
   public function displayLongFatalError (MyError $error) {

      ob_clean();
      
      $message = "<b>".gettext('err_mess').":</b> ".$error->getMessage().
         "<br/><br/>";
      
      $message .= "<b>".gettext('err_dett_mess').":</b> ".
         htmlspecialchars($error->getAdditionalInfo())."<br/><br/>";

      $message .= "<b>".gettext('err_script_name').":</b> ".
         $error->getFile()." <br/><br/>";

      $message .= "<b>".gettext('err_script_line')."</b>: ".$error->getLine().
         "<br/><br/>";

      $message .= "<b>Trace:</b>".
         $this->getFormatedBacktrace($error->getBacktrace());

      $this->smarty->assign('fatal_error', TRUE);
      
      $this->smarty->assign("message", $message);
      $this->smarty->assign("mess_type", "error");
      
      ob_clean();
      $this->smarty->displayPage('errors/main.tpl');

      die();
      
   }


   
   /**
    * Visualizza i messaggi lunghi per warning
    *
    * @param MyError $error Errore
    */
   public function displayLongWarning (MyError $error) {

      $message = "<b>".gettext('err_mess').":</b> ".$error->getMessage().
         "<br/><br/>";
      
      $message .= "<b>".gettext('err_dett_mess').":</b> ".
         htmlspecialchars($error->getAdditionalInfo())."<br/><br/>";

      $message .= "<b>".gettext('err_script_name').":</b> ".
         $error->getFile()." <br/><br/>";

      $message .= "<b>".gettext('err_script_line')."</b>: ".$error->getLine().
         "<br/><br/>";

      $message .= "<b>Trace:</b>".
         $this->getFormatedBacktrace($error->getBacktrace());

      $this->smarty->assign("message", $message);
      $this->smarty->assign("mess_type", "warning");
      $this->smarty->addTemplate('errors', $this->message_template);
   }

   
   /*
    * Restituisce in una stringa il backtrace dell'errore formatato con
    * html
    *
    * @param array $backtrace Backtrace dell'errore
    *
    * @return string Codice html del backtrace
    */
   protected function getFormatedBacktrace ($backtrace) {

      $s = '';
      $MAXSTRLEN = 120;
      
      $s = '<ins style="text-decoration: none">'.
         ' <pre style="color: black; font-size: 0.9em; '.
         'font-weight: normal">';

      $traceArr = $backtrace;
      
      $traceArr = array_reverse($traceArr);
      //array_unshift($traceArr);
      array_pop($traceArr);
      $tabs = sizeof($traceArr)-1;
      foreach($traceArr as $arr)
      {
         for ($i=sizeof($traceArr); $i > $tabs; $i--) { 
            $s .= ' &nbsp; ';
         }
         
         $s .= '';
 
         $Line = (isset($arr['line'])? $arr['line'] : "unknown");
         $File = (isset($arr['file'])? $arr['file'] : "unknown");
         
         $s .= 
            sprintf("<span style=\"color:#808080\">file: %s # line %4d,</span><br/>",
                    $File, $Line);
         for ($i=sizeof($traceArr); $i > $tabs; $i--) {
            $s .= ' &nbsp; ';
         }
         $tabs -= 1;
         if (isset($arr['class'])) {
            $s .= $arr['class'].'.';
         }
         $args = array();
         if(!empty($arr['args'])) {
            foreach($arr['args'] as $v) {
               if (is_null($v)) {
                  $args[] = 'null';
               }
               else if (is_array($v)) {
                  $args[] = 'Array['.sizeof($v).']';
               }
               else if (is_object($v)) {
                  $args[] = 'Object:'.get_class($v);
               }
               else if (is_bool($v)) {
                  $args[] = $v ? 'true' : 'false';
               }
               else {
                  $v = (string) @$v;

                  $str = htmlspecialchars(substr($v,0,$MAXSTRLEN), ENT_QUOTES,
                                          'UTF-8');
                  if (strlen($v) > $MAXSTRLEN) {
                     $str .= '...';
                  }
                  $args[] = "\"".$str."\"";
               }
            }
         }
         $s .= $arr['function'].'('.implode(', ',$args).')<br/>';
         
         $s .= "\n";
      }   
      $s .= '</pre></ins>';
      return $s;
   }
}
   
?>
