<?php

/**
 * Contiene la classe Conf
 *
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.2 $
 * $Id: Conf.class.php,v 1.2 2010/07/23 14:42:02 cmair Exp $
 */

/**
 * Gestisce i dati di configurazione
 *
 * Questa classe permette di accedere ai dati di configurazione
 *
 * @package classes
 */
abstract class Conf {

   /**
    * Path al file di configurazione
    *
    * @static 
    * @access public
    */
   public static $config_file;

   /**
    * Array associativo dei valori del file di configurazione
    *
    * @static
    * @access protected
    */
   protected static $config_values;

   /**
    * Timestamp ultima modifica del file di configurazione
    *
    * @static
    * @access protected
    */
   protected static $modification_time;


   
   public static function init ($config_file, $variable=NULL) {


      if ($variable !== NULL && isset($_SESSION[$variable]) 
          && isset($_SESSION[$variable.'_mtime'])) {
         
         // E' gia' presente una configurazione in sessione
         $last_modification = filemtime($config_file);
         if ($last_modification === FALSE) {
            throw new FileException("Could not read config ".
                                    "file '$config_file'");
         }
      
         if ($last_modification != $_SESSION[$variable.'_mtime']) {
            // Dobbiamo rileggere la configurazione da file
            self::loadFromFile($config_file);
            self::writeToCache($variable);
         } else {
            self::loadFromCache($variable);
         }
      } else {
         self::loadFromFile($config_file);
         if ($variable !== NULL) {
            self::writeToCache($variable);
         }
      }

      
   }



   /**
    * Caricamento delle variabili di configurazione da file
    *
    * Legge il file di configurazione passato come parametro, e inizializza
    * le variabili di configurazione
    * 
    * @param string config_file Path al file di configurazione
    * @return bool
    * @static
    * @access protected
    */
   protected static function loadFromFile($config_file) {

      
      if (!$sx = simplexml_load_file($config_file)) {
         throw new FileException("could not read config file '$config_file'");
      }

      $config_arr = array();

      foreach ($sx->config as $p) {
         $config_arr[(string)$p['name']] = (string)$p->value;
      }

      foreach ($sx->arrconfig as $p) {
         
         $config_arr[(string)$p['name']] = array();

         foreach ($p->element as $x) {
            $k = trim((string)$x->key);
            $v = trim((string)$x->value);

            if ($k === '') {
               $config_arr[(string)$p['name']][] = $v;
            } else {
               $config_arr[(string)$p['name']][$k] = $v;
            }
         }
      }
         
      foreach ($sx->compconfig as $p) {
         
         $config_arr[(string)$p['name']] = '';
         
         foreach ($p->subvalue as $x) {

            $val = (string)$x;
            if ($val[0] == '$') {
               if (is_array($config_arr[substr($val, 1)])) {
                  if ($config_arr[(string)$p['name']] == '') {
                     $config_arr[(string)$p['name']] = array();
                  }
                  $config_arr[(string)$p['name']] = 
                     array_merge($config_arr[(string)$p['name']],
                                 $config_arr[substr($val, 1)]);
               } else {
                  $config_arr[(string)$p['name']] .= 
                     $config_arr[substr($val, 1)];
               }
            } else {
               $config_arr[(string)$p['name']] .= $val;
            }
         }
      }

      self::$config_values = $config_arr;
      self::$modification_time = filemtime($config_file);

   }


   /**
    * Carica la configurazione dalla sessione
    *
    * @param string $session_variable Nome della variabile di sessione
    *  nella quale e' salvata la configurazione
    *
    * @return boolean
    */
   protected static function loadFromCache ($session_variable) {

      self::$config_values = $_SESSION[$session_variable];
      self::$modification_time = $_SESSION[$session_variable."_mtime"];

      return TRUE;
   }


   
   /** 
    * Salva la configurazione in sessione
    *
    * @param string $name Nome della variabile di sessione
    *
    * @return boolean
    */
   protected static function writeToCache ($name) {

      $_SESSION[$name] = self::$config_values;
      $_SESSION[$name."_mtime"] = self::$modification_time;

      return TRUE;
   }



   /**
    * Permette di accedere ai valori del file di configurazione
    *
    * Attraverso questo methodo sara' possibile di accedere direttamente
    * ai valori definiti nel file di configurazione.
    *
    * @param string property     
    * @return string
    * @access public
    */
   public static function get($property) {
      
      if (!isset(self::$config_values[$property])) {
         throw new ConfigException("Configuration option not set: ".$property);
      } else {
         return self::$config_values[$property];
      }
   }

   
   /**
    * 
    */
   public static function generateVariableDefinition () {

      $text = '';
      foreach (self::$config_values as $name=>$value) {
         $text .= '
            $'.$name.' = '.var_export($value, TRUE).';
         ';
      }

      return $text;
   }
      
}

?>
