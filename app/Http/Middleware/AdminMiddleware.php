<?php

namespace App\Http\Middleware;


use Auth;
use Closure;
use App\Models\Manager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $manager = new Manager();

        if (auth()->check() && auth()->user()->role == $manager->role) {
            return $next($request);
        }else{
            return redirect('/');
        }
      
        
    }
}
