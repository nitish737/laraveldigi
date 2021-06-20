<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessOwner;
use App\Models\BusinessStaffMember;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/business';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        //pattern filter to get the user by the code
        Route::bind('user', function($value){
            return User::where('id', $value)
                ->orWhere('code', $value)
                ->first();
        });

        //pattern filter to get the business owner by the code
        Route::bind('businessOwner', function($value){
            return BusinessOwner::where('id', $value)
                ->orWhere('code', $value)
                ->first();
        });

        //pattern filter to get the business by the code
        Route::bind('business', function($value){
            return Business::where('id', $value)
                ->orWhere('code', $value)
                ->first();
        });

        //pattern filter to get the business location by the code
        Route::bind('businessLocation', function($value){
            return BusinessLocation::where('id', $value)
                ->orWhere('code', $value)
                ->first();
        });

        //pattern filter to get the business location by the code
        Route::bind('businessStaffMember', function($value){
            return BusinessStaffMember::where('id', $value)
                ->orWhere('code', $value)
                ->first();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
