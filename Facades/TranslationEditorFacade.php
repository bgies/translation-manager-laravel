<?php namespace Bgies\TranslationEditor;

class TranslationEditorFacade extends \Illuminate\Support\Facades\Facade
{
   /**
    * Get the registered name of the component.
    *
    * @return string
    */
   protected static function getFacadeAccessor()
   {
      return 'Bgies\TranslationEditor\TranslationEditorController';
   }
}