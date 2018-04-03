<?php
/**
 * Code generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: zhovtyj IT Solutions
 * Developer Website: http://zhovtyjitsolutions.com
 */

namespace zhovtyj\Laraadmin;

use Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use zhovtyj\Laraadmin\Helpers\LAHelper;

/**
 * Class LAProvider
 * @package zhovtyj\Laraadmin
 *
 * This is LaraAdmin Service Provider which looks after managing aliases, other required providers, blade directives
 * and Commands.
 */
class LAProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // @mkdir(base_path('resources/laraadmin'));
        // @mkdir(base_path('database/migrations/laraadmin'));
        /*
        $this->publishes([
            __DIR__.'/Templates' => base_path('resources/laraadmin'),
            __DIR__.'/config.php' => base_path('config/laraadmin.php'),
            __DIR__.'/Migrations' => base_path('database/migrations/laraadmin')
        ]);
        */
        //echo "Laraadmin Migrations started...";
        // Artisan::call('migrate', ['--path' => "vendor/zhovtyj/laraadmin/src/Migrations/"]);
        //echo "Migrations completed !!!.";
        // Execute by php artisan vendor:publish --provider="zhovtyj\Laraadmin\LAProvider"
        
        /*
        |--------------------------------------------------------------------------
        | Blade Directives for Entrust not working in Laravel 5.3
        |--------------------------------------------------------------------------
        */
        if(LAHelper::laravel_ver() >= 5.3 || LAHelper::laravel_ver() == 5.4) {
            
            // Call to Entrust::hasRole
            Blade::directive('role', function ($expression) {
                return "<?php if (\\Entrust::hasRole({$expression})) : ?>";
            });
            
            // Call to Entrust::can
            Blade::directive('permission', function ($expression) {
                return "<?php if (\\Entrust::can({$expression})) : ?>";
            });
            
            // Call to Entrust::ability
            Blade::directive('ability', function ($expression) {
                return "<?php if (\\Entrust::ability({$expression})) : ?>";
            });
        }
    }
    
    /**
     * Register the application services including routes, Required Providers, Alias, Controllers, Blade Directives
     * and Commands.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
        
        // For LAEditor
        if(file_exists(__DIR__ . '/../../laeditor')) {
            include __DIR__ . '/../../laeditor/src/routes.php';
        }
        
        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */
        
        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);
        
        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */
        
        $loader = AliasLoader::getInstance();
        
        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);
        
        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);
        
        // For LaraAdmin Code Generation
        $loader->alias('CodeGenerator', \zhovtyj\Laraadmin\CodeGenerator::class);
        
        // For LaraAdmin Form Helper
        $loader->alias('LAFormMaker', \zhovtyj\Laraadmin\LAFormMaker::class);
        
        // For LaraAdmin Helper
        $loader->alias('LAHelper', \zhovtyj\Laraadmin\Helpers\LAHelper::class);
        
        // LaraAdmin Module Model 
        $loader->alias('Module', \zhovtyj\Laraadmin\Models\Module::class);
        
        // For LaraAdmin Configuration Model
        $loader->alias('LAConfigs', \zhovtyj\Laraadmin\Models\LAConfigs::class);
        
        // For Entrust
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('role', \Zizaco\Entrust\Middleware\EntrustRole::class);
        $loader->alias('permission', \Zizaco\Entrust\Middleware\EntrustPermission::class);
        $loader->alias('ability', \Zizaco\Entrust\Middleware\EntrustAbility::class);
        
        /*
        |--------------------------------------------------------------------------
        | Register the Controllers
        |--------------------------------------------------------------------------
        */
        
        $this->app->make('zhovtyj\Laraadmin\Controllers\ModuleController');
        $this->app->make('zhovtyj\Laraadmin\Controllers\FieldController');
        $this->app->make('zhovtyj\Laraadmin\Controllers\MenuController');
        
        // For LAEditor
        if(file_exists(__DIR__ . '/../../laeditor')) {
            $this->app->make('zhovtyj\Laeditor\Controllers\CodeEditorController');
        }
        
        /*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */
        
        // LAForm Input Maker
        Blade::directive('la_input', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.3 || LAHelper::laravel_ver() == 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo LAFormMaker::input$expression; ?>";
        });
        
        // LAForm Form Maker
        Blade::directive('la_form', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.3 || LAHelper::laravel_ver() == 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo LAFormMaker::form$expression; ?>";
        });
        
        // LAForm Maker - Display Values
        Blade::directive('la_display', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.3 || LAHelper::laravel_ver() == 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo LAFormMaker::display$expression; ?>";
        });
        
        // LAForm Maker - Check Whether User has Module Access
        Blade::directive('la_access', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.3 || LAHelper::laravel_ver() == 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php if(LAFormMaker::la_access$expression) { ?>";
        });
        Blade::directive('endla_access', function ($expression) {
            return "<?php } ?>";
        });
        
        // LAForm Maker - Check Whether User has Module Field Access
        Blade::directive('la_field_access', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.3 || LAHelper::laravel_ver() == 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php if(LAFormMaker::la_field_access$expression) { ?>";
        });
        Blade::directive('endla_field_access', function ($expression) {
            return "<?php } ?>";
        });
        
        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */
        
        $commands = [
            \zhovtyj\Laraadmin\Commands\Migration::class,
            \zhovtyj\Laraadmin\Commands\Crud::class,
            \zhovtyj\Laraadmin\Commands\Packaging::class,
            \zhovtyj\Laraadmin\Commands\LAInstall::class
        ];
        
        // For LAEditor
        if(file_exists(__DIR__ . '/../../laeditor')) {
            $commands[] = \zhovtyj\Laeditor\Commands\LAEditor::class;
        }
        
        $this->commands($commands);
    }
}
