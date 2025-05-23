<?php

namespace App\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $AdminMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
    $DoctorMenuJson = file_get_contents(base_path('resources/menu/verticalMenuDoctor.json'));

    $Admin = json_decode($AdminMenuJson);
    $doctor = json_decode($DoctorMenuJson);

    View::composer('*', function ($view) use ($doctor, $Admin) {
        $user = Auth::user();

        if ($user && $user->role === 'Doctor') {
            $view->with('menuData', [$doctor]);
        } else {
            $view->with('menuData', [$Admin]);
        }
    });
  }
}
