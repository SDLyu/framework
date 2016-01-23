<?php

namespace Litepie\User\Providers;

use Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Litepie\Contract\User\UserRepository;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Litepie\User\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        if (Request::is('*admin/user/*')) {
            $router->bind('user', function ($id) {
                $user = $this->app->make('\Litepie\Contracts\User\UserRepository');
                return $user->find($id);
            });

            $router->bind('role', function ($id) {
                $role = $this->app->make('\Litepie\Contracts\User\RoleRepository');
                return $role->find($id);
            });

            $router->bind('permission', function ($id) {
                $permission = $this->app->make('\Litepie\Contracts\User\PermissionRepository');
                return $permission->find($id);
            });
        }

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require __DIR__.'/../Http/routes.php';
        });
    }
}