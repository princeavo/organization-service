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
        //$response = Http::withHeaders($headers)->get(url: config(key: "app.APP_AUTH_URL") . "user");
        $response = ["authenticated_user" => [
        "id" => 2,
        "name" => "Amédé Florian KOTANMI",
        "email" => "amedeflorianktm@gmail.com",
        "email_verified_at" => null,
        "created_at" => "2025-03-08T15:15:05.000000Z",
        "updated_at" => "2025-03-08T15:15:05.000000Z"
    ]];
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
