<?php

/**
 * Contiene la classe {@link MyErrorDisplayHandler}
 *
 * @author Christoph Mair <cmair@sad.it>
 * @version $Revision: 1.1.1.1 $
 */

/*
 * Classe astratta per la visualizzazione di messaggi d'errore
 *
 * Ogni classe che viene utilizzata per visualizzare i messaggi d'errore
 * gestiti con la classe {@link MyError} deve estendere da questa classe
 */

abstract class MyErrorDisplayHandler {

   
   /**
    * Metodo per la visualizzazione corta di un messaggio d'errore 
    *
    * @param MyError $error Errore
    */
   abstract public function displayShortError(MyError $error);


   /**
    * Metodo per la visualizzazione corta di un messaggio d'errore fatale
    * che interrompe necessariamente il programma
    *
    * @param MyError $error Errore
    */
   abstract public  function displayShortFatalError(MyError $error);


   /**
    * Metodo per la visualizzazione corta di un warning
    *
    * @param MyError $error Errore
    */
   abstract public function displayShortWarning(MyError $error);

   
   /**
    * Metodo per la visualizzazione lunga di un errore
    *
    * @param MyError $error Errore
    */
   abstract public function displayLongError(MyError $error);


   /**
    * Metodo per la visualizzazione lunga di un messaggio d'errore fatale
    *
    * @param MyError $error Errore
    */
   abstract public function displayLongFatalError(MyError $error);


   /**
    * Metodo per la visualizzazione lunga di un warning
    *
    * @param MyError $error Errore
    */
   abstract public function displayLongWarning(MyError $error);


}


?>