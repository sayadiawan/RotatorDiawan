<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\Option\Entities\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use DB;
use Illuminate\Contracts\Auth\Guard;
use Modules\Modules\Entities\Module;
use Modules\Modules\Entities\Roles;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(Guard $auth)
  {
    // View::share('key', 'value');
    // Schema::defaultStringLength(191);
    //settimezone
    config(['app.locale' => 'id']);
    Carbon::setLocale('id');
    date_default_timezone_set('Asia/Jakarta');

    View::composer('*', function ($view) use ($auth) {
      $view->with('AuthData', $auth->user());
    });
    $modules = Module::where('upid_module', '0')->orderby('order_module', 'ASC')->get();
    $module = new Module;
    $role = new Roles;
    $option = Options::first();

    View::share('option', $option);
    View::share('modules', $modules);
    View::share('module', $module);
    View::share('role', $role);

    Paginator::useBootstrap();
  }
}