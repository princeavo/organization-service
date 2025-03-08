<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = [
            'Authorization' => $request->header('Authorization'),
            'Accept' => 'application/json',
        ];
        $response = Http::withHeaders($headers)->get(config("app.APP_AUTH_URL") . "user");
        $is_user_logged = Arr::get($response,"authenticated_user") !== null;
        if(!$is_user_logged){
            return response()->json(["message" => "Unauthenticated"],403);
        }
        $input = $request->all();
        $input["user"] = $response["authenticated_user"];
        $request->replace($input);
        return $next($request);
    }
}
