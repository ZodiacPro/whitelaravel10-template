<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuthorityModel;
use Auth;

class AuthorityChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest()) return $next($request);          // access for login
        if ($request->is('logout')) return $next($request); //access for logout


        // checking access
        $data = AuthorityModel::join('table_urls','table_urls.id','=','authority.linkName_id')
                                ->where('user_id', Auth::user()->id)
                                ->get();

        foreach($data as $item){
            $linktest1 = $request->is($item->linkName.'/*');
            $linktest2 = $request->is($item->linkName);

            if($linktest1) return $next($request);
            if($linktest2) return $next($request);
        }

        // return to home if no access
        return redirect('/');
    }
}
