<?php

/**
 * Contains the {@link MySmarty} class wich extends the original 
 * Smarty class.
 *
 * The original Smarty class must be of version 3.0 or compatible versions 
 *
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.4 $
 */


/**
 * Including the original {@link Smarty} class
 */
require_once(Conf::get('smarty_class_path').'/Smarty.class.php');


/**
 * Personalized Smarty class
 *
 */
class MySmarty extends Smarty {

   /**
    * @var array Contains the compiled html blocks
    */
   protected $templates = array();


   
   public function __construct() {
      parent::__construct();

      $this->template_dir = Conf::get('smartydir').'/templates/';
      $this->compile_dir = Conf::get('smartydir').'/templates_c/';
      $this->config_dir = Conf::get('smartydir').'/configs/';
      $this->cache_dir = Conf::get('smartydir').'/cache/';


      if (Conf::get('smartyCache') == 1) {
         $this->caching = TRUE;
      } else {
         $this->caching = FALSE;
      }
   }


   /**
    * Aggiunge il file template indicato al blocco desiderato
    *
    * @param string blocco
    * @param string template
    * @param string nome
    * 
    * @return boolean
    */
   function addTemplate ($blocco, $template, $nome=NULL) {

      if ($nome === NULL) {
         $this->templates[$blocco][] = $this->fetch($template);
      } else {
         $this->templates[$blocco][$nome] = $this->fetch($template);
      }
   }

   
   
   /**
    * Aggiunge del contenuto a al blocco specificato
    *
    * @param string blocco
    * @param string contenuto
    * @param string nome
    * 
    * @return boolean
    */
   function addContent ($blocco, $contenuto, $nome=NULL) {

      if ($nome === NULL) {
         $this->templates[$blocco][] = $contenuto;
      } else {
         $this->templates[$blocco][$nome] = $contenuto;;
      }
   }



   /**
    * Assegna a smarty convertendo i caratteri speciali in HTML entities
    *
    * Si avvale di una funzione ricorsiva {@link recConv} che applica
    * ricorsivamente su tutti gli elementi di un array n-dimensionale
    * una funzione callback definita dall'utente. In questo caso la
    * funzione callback passata e' {@link SmartyCless::htmlEnt()}
    * Il risultato viene assegnato a Smarty utilizzando
    * {@link SmartyCless::htmlEnt()}
    */


   /**
    * Visualizza la pagina
    *
    * @param string nome del template principale
    */
   function displayPage ($nome) {


      foreach ($this->templates as $n=>$v) {
         $this->assign("bl_".$n, $v);
      }
      $this->display($nome);
   }

   /**
    * Visualizza la pagina
    *
    * @param string nome del template principale
    */
   function fetchPage ($nome) {


      foreach ($this->templates as $n=>$v) {
         $this->assign("bl_".$n, $v);
      }
      return $this->fetch($nome);
   }

   /**
    * Aggiunge il valore a un array se non gia' presente
    *
    * @param string $tpl_var Nome della variabile
    * @param string $value Valore 
    */
   function mergeInto($tpl_var, $value=null) {
      if ($tpl_var != '' && isset($value)) {
         if(!isset($this->tpl_vars[$tpl_var])) {
            $this->append($tpl_var, $value);
         }

         if (!in_array($value, $this->tpl_vars[$tpl_var]->value)) {
            $this->append($tpl_var, $value);
         }
      }
   }

   
   /**
    * Toglie il valore da un array se  presente
    *
    * @param string $tpl_var Nome della variabile
    * @param string $value Valore 
    */
   function deleteFrom($tpl_var, $value=null) {
      if ($tpl_var != '' && isset($value)) {
         
         if(isset($this->tpl_vars[$tpl_var])) {
            $res = array_search($value, $this->tpl_vars[$tpl_var]->value);
            if ($res !== FALSE) {
               unset($this->tpl_vars[$tpl_var]->value[$res]);
            }
         }
      }
   }

}
?>