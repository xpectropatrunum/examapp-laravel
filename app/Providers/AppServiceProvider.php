<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        
        JsonResource::withoutWrapping();
        
        Collection::macro('paginate', function ($perPage, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage), // $items
                $this->count(),                  // $total
                $perPage,
                $page,
                [                                // $options
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
        Schema::defaultStringLength(191);
        Validator::extend('farsi', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\x{0600}-\x{06FF}\x{FB8A}\x{067E}\x{0686}\x{06AF}\x{200C}\x{200F} ]+$/u', $value);
        });
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return strlen($value) == 11 && strpos($value, "09") === 0;
        });
    }
}
