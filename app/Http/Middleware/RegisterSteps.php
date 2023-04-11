<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegisterSteps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      $status = $request->user() ? $request->user()->step_status : null;
      if($status !== null && $status == false)
      {
        return redirect()->route('user.register.steps');
      }
      return $next($request);
    }
}
