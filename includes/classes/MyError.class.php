<?php

/**
 * Error-Handler Klasse
 *
 * Diese Klasse wird in Methoden und Funktionen verwendet, um waehrend
 * der Ausfuehrung aufgetretene Fehler an den Aufrufer weiterzuleiten.
 *
 * @package classes
 *
 * @author $Author: dkofler $
 * @version $Revision: 1.3 $
 * 
 * $Id: MyError.class.php,v 1.3 2010/08/23 15:22:06 dkofler Exp $
 */


/*
 * Error Konstanten
 */

/**
 * Errore sql che termina l'esecuzione dello script
 */
define("SQL_FATAL_ERROR", 1000);

/**
 * Errore sql che non termina l'esecuzione dello script
 */
define("SQL_ERROR", 2000);

/**
 * Warning dalle query sql
 */
define("SQL_WARNING", 3000);

/**
 * Errore script che termina l'esecuzione dello script
 */
define("SYS_FATAL_ERROR", 1001);

/**
 * Errore script che non termina l'esecuzione dello script
 */
define("SYS_ERROR", 2001);

/**
 * Warning script
 */
define("SYS_WARNING", 3001);

/**
 * Errore parametri vuoti
 *
 * Viene lanciato da metodi e/o funzioni se uno dei parametri
 * richiesti e vuoto
 */
define("ERR_PARAM_EMPTY", 2002);

/**
 * Errore parametro non settato
 *
 * Viene lanciato da metodi e/o funzioni quando un parametro (array)
 * non contiene il campo richiesto
 */
define("ERR_PARAM_NOT_SET", 2003);

/**
 * Errore tipo del parametro non corrisponde
 *
 * Viene lanciato da metodi e/o funzioni se un parametro passato
 * non e' del tipo richiesto
 */
define("ERR_PARAM_TYPE_MISMATCH", 2004);

/**
 * Errore chiave (Db) non essistente
 *
 * Viene lanciato da interrogazioni al database, se una chiave richiesta
 * e' inesistente
 */
define("ERR_UNKNOWN_KEY", 2005);

/**
 * Errore chiave (DB) gia' presente
 *
 * Viene lanciato da interrogazioni al database, se una chiave e' gia'
 * presente
 */
define("ERR_DOUBLE_ENTRY", 2006);

/**
 * Errore chiave (DB) ancora in uso
 *
 * Viene lanciato da interrogazioni al database, se una chiave e' ancora
 * in uso
 */
define("ERR_KEY_IN_USE", 2007);

/**
 * Uno degli application server ci ha restituito un errore
 *
 **/
define("ERR_APP_COMM_GEN", 2008);

/**
 * Errore Linea/corsa non trovata
 *
 */
define("ERR_APP_UNKNOWN_LINEA", 2009);

/** 
 * Errore communicazione rete
 */
define("ERR_NETWORK_ERROR", 2010);

/**
 * Errore parametro non valido
 */
define('ERR_PARAM_NOT_VALID', 2011);

/**
 * Errore input utente
 */
define('ERR_USER_INPUT', 2012);

/**
 * Errore di connessione
 */
define('ERR_NO_CONN', 2013);

/**
 * Classe gestione degli errori
 *
 * Classe per la gestione degli errori
 *
 */
class MyError {   

   /**
    * @var string Messaggio d'errore
    */
   protected $err_message;

   /**
    * @var integer Codice d'errore
    */
   protected $err_code;

   /**
    * @var string Informazioni aggiuntive
    */
   protected $err_addInfo;

   /**
    * @var string Nome del file nel quale si e' verficato l'errore
    */
   protected $err_file;

   /**
    * @protected integer Numero della riga in cui si e' verficato l'errore
    */
   protected $err_line;

   /**
    * @var array Backtrace dell' errore
    */
   protected $err_backtrace;

   /**
    * @var MyErrorDisplayHandler Oggetto che gestisce la visualizzazione di
    *  un errore
    */
   protected static $display_handler = NULL;


   /**
    * Costruttore
    * 
    * Il costruttore viene chiamato dal metodo {@link MyError::raiseError()}
    *
    * @param string $message Messaggio d'errore
    * @param integer $code Codice d'errore
    * @param string $add Informazioni aggiuntive
    * @param string $file Nome dello script in cui si e' verificato l'errore
    * @param integer $line Numero riga in cui si e' verificato l'errore
    * @param array $backtrace Array contenente il backtrace dell'errore
    */
   protected function MyError($message, $code, $add, $file, $line, $backtrace) {

      $this->err_message = $message;
      $this->err_code = $code;
      $this->err_addInfo = $add;
      $this->err_file = $file;
      $this->err_line = $line;
      $this->err_backtrace = $backtrace;

      if (!(self::$display_handler instanceof MyErrorDisplayHandler)) {
         die('No error display handler set');
      }
   }


   
   /**
    * Metodo per la generazione di un nuovo oggetto d'errore
    *
    * Questo metodo viene chiamato quando si verifica un nuovo errore.
    *
    * @param string $message Messaggio d'errore
    * @param integer $code Codice d'errore
    * @param string $add Informazioni aggiuntive
    * 
    * @return object
    */
   public static function raiseError($message="", $code=-1, $add="") {
      
      $backtrace = debug_backtrace();
      
      return new MyError($message, $code, $add, $backtrace[0]['file'],
                         $backtrace[0]['line'], $backtrace);
   }

   
   
   /**
    * Inizialiazza l'oggetto che gestisce la visualizzazione dei messaggi
    * d'errore
    *
    * @param MyErrorDisplayHandler $display_handler
    *
    * @return boolean
    */
   public static function setDisplayHandler(
      MyErrorDisplayHandler $display_handler) 
   {
      self::$display_handler = $display_handler;
   }



   /** 
    * Verifica se la variabile e' un oggetto della classe {@link MyError}
    * o meno
    *
    * @param mixed $obj Variabile da controllare
    *
    * @return boolean
    */
   public static function isError($obj) {

      if ($obj instanceof MyError) {
         return true;
      } else {
         return false;
      }
   }

   
   
   /**
    * Restituisce il messaggio d'errore
    * 
    * @return string Messaggio d'errore
    */
   public function getMessage() {
      return $this->err_message;
   }



   /**
    * Permette di settare il messaggio d'errore
    *
    * @param string $message Messaggio d'errore
    *
    */
   public function setMessage() {
      $this->err_message = $message;
   }


   /**
    * Restituisce la riga in cui si e' verificato l'errore
    *
    * @return integer Numero riga
    */
   public function getLine() {
      return $this->err_line;
   }



   /**
    * Fornisce il codice d'errore
    *
    * @return integer Codice d'errore
    */
   public function getCode() {
      return $this->err_code;
   }



   /**
    * Restituisce le informazioni aggiuntive
    *
    * @return string Informazioni aggiuntive
    */
   public function getAdditionalInfo() {
      return $this->err_addInfo;
   }


   
   /**
    * permette di settare le informazioni aggiuntive di un errore
    *
    * @param string $info Informazioni aggiuntive
    *
    */
   public function setAdditionalInfo($info) {
      $this->err_addInfo = $info;
   }


   /**
    * Fornisce il nome dello script in cui si e' verificato l'errore
    *
    * @return string Nome dello script
    */
   public function getFile() {
      return $this->err_file;
   }


   /**
    * Restituisce l'array contenete il backtrace dell'errore
    *
    * @return array backtrace
    */
   public function getBacktrace() {
      return $this->err_backtrace;
   }

    
    
   /**
    * WrapperMethode um zu entscheiden welche Form von Fehlermeldungen 
    * angezeigt werden sollen.
    *
    * Hier wird entschieden in welcher Form Fehlermeldungen angezeigt werden
    * sollen z.B. ausfuehrliche Fehlermeldungen oder kurze Fehlermeldungen.
    * <br/>
    * Der Typ der Anzeige wird normalerweise in der Konfigurationsdatei
    * eingstellt.
    *
    * @param integer $code Ein bestimmter schwierigkeitsgrad wird verlang
    */
   public function displayMessage($code='') {
      
      if (isset($code) && trim($code) != '') {
         // Il codice d'errore passato con il parametro sovrascrive quello
         // originale dell'errore
         $this->err_code = $code;
      }


      switch (Conf::get('err_mess_type')) {
      case 'long':
         $this->displayLongMessage();
         break;
      case 'short':
         $this->displayShortMessage();
         break;
      }
   }



   /**
    * WrapperMethode zur Anzeige kurzer Fehlermeldungen
    *
    * Diese Methode wird verwendet um anhand des generierten Fehlercodes, zu
    * entscheiden welcher Typ von Fehlermeldungen angezeigt werden soll.<br/>
    *
    * Der Type der Fehlermeldung wird durch die erste Ziffer des Fehlercodes
    * bestimmt.<br/>
    *
    */
   protected function displayShortMessage() {
    
      $err_class = strval($this->err_code);
      $err_class = $err_class[0];

      switch ($err_class) {
      case 1:
         /* FATAL ERROR */
         self::$display_handler->displayShortFatalError($this);
         break;
      case 2:
         /* ERROR */
         self::$display_handler->displayShortError($this);
         break;
      case 3:
         /* WARNING */
         self::$display_handler->displayShortWarning($this);
      default:
         self::$display_handler->displayShortFatalError($this);
      }
   }



   /**
    * WrapperMethode zur Anzeige langer Fehlermeldungen
    *
    * Diese Methode wird verwendet um anhand des generierten Fehlercodes, zu
    * entscheiden welcher Typ von Fehlermeldungen angezeigt werden soll.<br/>
    *
    * Der Type der Fehlermeldung wird durch die erste Ziffer des Fehlercodes
    * bestimmt.<br/>
    *
    */
   protected function displayLongMessage() {

      $err_class = strval($this->err_code);
      $err_class = $err_class[0];

      switch ($err_class) {
      case 1:
         /* FATAL ERROR */
         self::$display_handler->displayLongFatalError($this);
         break;
      case 2:
         /* ERROR */
         self::$display_handler->displayLongError($this);
         break;
      case 3:
         /* WARNING */
         self::$display_handler->displayLongWarning($this);
         break;
      default:
         self::$display_handler->displayLongFatalError($this);
      }
   }



}

?>
