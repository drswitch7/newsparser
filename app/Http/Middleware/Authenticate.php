<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;


class Authenticate extends Middleware
{
    protected $guards;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;
        return parent::handle($request, $next, ...$guards);
    }
    
    protected function redirectTo($request)
    {      
        if (!$request->expectsJson()) {
        $guard = Arr::get($this->guards,0); 
            switch ($guard) {
                case 'client':
                    $goto= 'guest.login';
                    break;
                case 'admin':
                    $goto = 'admin.login'; 
                    break;
            }
            
            return redirect()->guest(route($goto));
        }
    }
}
