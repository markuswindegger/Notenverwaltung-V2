<?php

/**
 * Contiene la classe {@link MyErrorSmartyDisplayHandler}
 * 
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.1 $
 */

/**
 * Include della classe {@link MyErrorDisplayHandler}
 */
require_once(Conf::get('classdir').'/MyErrorDisplayHandler.class.php');


/**
 * Classe per visualizzare i messaggi d'errore generati con {@link MyError}
 * in formato html con l'aiuto di Smarty
 */
class MyErrorTextDisplayHandler extends MyErrorDisplayHandler {

   
   
   /**
    * Visualizza i messaggi d'errore corti
    *
    * @param MyError $error Errore
    */
   public function displayShortError (MyError $error) {


      echo 'ERROR: '.$error->getMessage();

   }



   /**
    * Visualizza i messaggi corti per errori fatali
    *
    * @param MyError $error Errore
    */
   public function displayShortFatalError (MyError $error) {
      
     echo 'FATAL ERROR: '.$error->getMessage();
     die();
   }



   /**
    * Visualizza i messaggi corti per warning
    *
    * @param MyError $error Errore
    */
   public function displayShortWarning ( MyError $error) {

      echo 'WARNING: '.$error->getMessage();
   }


   
   /**
    * Visualizza i messaggi lunghi per errori
    *
    * @param MyError $error Errore
    */
   public function displayLongError (MyError $error) {

     echo 'ERROR: '.$error->getMessage()."\n";
     echo 'ADDITIONAL INFO: '.$error->getAdditionalInfo()."\n";
     echo 'SCRIPT: '.$error->getFile()."\n";
     echo 'LINE: '.$error->getLine()."\n";
     echo 'TRACE: '.$this->getFormattedBacktrace($error->getBacktrace())."\n";
 
   }

   
   /**
    * Visualizza i messaggi lunghi per errori fatali
    *
    * @param MyError $error Errore
    */
   public function displayLongFatalError (MyError $error) {


     echo 'FATAL ERROR: '.$error->getMessage()."\n";
     echo 'ADDITIONAL INFO: '.$error->getAdditionalInfo()."\n";
     echo 'SCRIPT: '.$error->getFile()."\n";
     echo 'LINE: '.$error->getLine()."\n";
     echo 'TRACE: '.$this->getFormattedBacktrace($error->getBacktrace())."\n";
      die();
      
   }


   
   /**
    * Visualizza i messaggi lunghi per warning
    *
    * @param MyError $error Errore
    */
   public function displayLongWarning (MyError $error) {
     
     echo 'WARNING: '.$error->getMessage()."\n";
     echo 'ADDITIONAL INFO: '.$error->getAdditionalInfo()."\n";
     echo 'SCRIPT: '.$error->getFile()."\n";
     echo 'LINE: '.$error->getLine()."\n";
     echo 'TRACE: '.$this->getFormattedBacktrace($error->getBacktrace())."\n";
   }

   
   /*
    * Restituisce in una stringa il backtrace dell'errore formatato con
    * html
    *
    * @param array $backtrace Backtrace dell'errore
    *
    * @return string Codice html del backtrace
    */
   protected function getFormattedBacktrace ($backtrace) {

      $s = '';
      $MAXSTRLEN = 120;
      
      $s = '';
      $traceArr = $backtrace;
      
      $traceArr = array_reverse($traceArr);
      //array_unshift($traceArr);
      array_pop($traceArr);
      $tabs = sizeof($traceArr)-1;
      foreach($traceArr as $arr)
      {
         for ($i=sizeof($traceArr); $i > $tabs; $i--) { 
            $s .= '  ';
         }
         
         $s .= '';
 
         $Line = (isset($arr['line'])? $arr['line'] : "unknown");
         $File = (isset($arr['file'])? $arr['file'] : "unknown");
         
         $s .= 
            sprintf("file: %s # line %4d\n",
                    $File, $Line);
         for ($i=sizeof($traceArr); $i > $tabs; $i--) {
            $s .= '  ';
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
                  $str = htmlspecialchars(substr($v,0,$MAXSTRLEN));
                  if (strlen($v) > $MAXSTRLEN) {
                     $str .= '...';
                  }
                  $args[] = "\"".$str."\"";
               }
            }
         }
         $s .= $arr['function'].'('.implode(', ',$args).')
';
         
         $s .= "\n";
      }   
      $s .= "\n";
      return $s;
   }
}
   
?>
