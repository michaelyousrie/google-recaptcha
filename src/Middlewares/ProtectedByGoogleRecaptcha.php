<?php

namespace Michael\GoogleRecaptcha\Middlewares;

use Closure;
use Illuminate\Http\Request;

class ProtectedByGoogleRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        //TODO: implement calling google.

        return $next($request);
    }

    /**
     * @param string $token
     * @return mixed
     */
    private function verifyRecaptcha(string $token): mixed
    {
        $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
        curl_setopt_array($ch, [
            CURLOPT_POSTFIELDS => ['secret' => config('google_recaptcha.secret'), 'response' => $token],
            CURLOPT_RETURNTRANSFER => true
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
