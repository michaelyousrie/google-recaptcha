<?php

namespace Michael\GoogleRecaptcha\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProtectedByGoogleRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        if (
            empty($request->get('google_recaptcha_token')) or
            $this->verifyRecaptcha($request->get('google_recaptcha_token'))->success != true
        ) {
            Log::error("Recaptcha Failed.");

            return redirect()->back();
        }

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
