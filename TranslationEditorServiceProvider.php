<?php namespace Bgies\TranslationEditor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class TranslationEditorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;    
    
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $viewPath = __DIR__.'/views'; 
		$this->loadViewsFrom(realpath(__DIR__ . '/views'), 'translationeditor');
		
		
//		$this->loadTranslationsFrom(__DIR__.'/lang', 'translationeditor');
		$this->setupRoutes($this->app->router);
		// this  for conig
		$this->publishes([
			__DIR__.'/config/translationeditor.php' => config_path('translationeditor.php')
	    ], 'config');
		
		$this->publishes([
            __DIR__.'/views' => base_path('resources/views/bgies/translationeditor')
	    ], 'views');
		
	    $this->publishes([
		    __DIR__.'/assets' => public_path('bgies/translationeditor')
		], 'assets');
	    
	    $this->app->make('Bgies\TranslationEditor\TranslationEditorController');	    
   }
   
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
//       $this->app->make('Bgies\TranslationEditor\TranslationEditorController');   
//       $this->app->make('Bgies\TranslationEditor\AllLanguages');
    }
    
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
       $router->group(['namespace' => 'Bgies\TranslationEditor'], function($router)
       {
          require __DIR__.'/routes/routes.php';
       });
    }
    
    
    
}