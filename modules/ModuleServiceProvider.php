<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 1/6/18
 * Time: 2:55 PM
 */
namespace Modules;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $modules = config("module.modules");
        while (list(,$module) = self::myEach($modules)) {
            if(file_exists(__DIR__.'/'.$module.'/routes/routes.php')) {
                include __DIR__.'/'.$module.'/routes/routes.php';
            }
            if(is_dir(__DIR__.'/'.$module.'/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    //each is deprecated so make a custom each function
    protected function myEach(&$arr) {
        $key = key($arr);
        $result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];
        next($arr);
        return $result;
    }

}