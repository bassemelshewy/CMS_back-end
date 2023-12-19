<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkCategory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $count = Category::all()->count();
        if ($count == 0) {
            session()->flash('error', 'First you need to add some categories.');
            return redirect()->route('categories.index');
        }
        return $next($request);
    }
}
