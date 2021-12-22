<?php

namespace Michael\GoogleRecaptcha;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class GoogleRecaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        Blade::directive('google_recaptcha', function($formId) {
            $googleClientId = config('google_recaptcha.id');

            return <<<HTML
<input type="hidden" id="google-recaptcha-token" name="google_recaptcha_token">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render={$googleClientId}"></script>
<script>
    $(document).on('submit', '#$formId', function(e) {
        let token_input = $('input#google-recaptcha-token');

        if (token_input.val().length === 0) {
            e.preventDefault();

            grecaptcha.ready(function() {
                grecaptcha.execute('{$googleClientId}', {action: 'submit'}).then(function (token) {
                    token_input.val(token);

                    $('form#{$formId}').submit();
                });
            });
        }
    });
</script>
HTML;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/google_recaptcha.php' => config_path('/google_recaptcha.php')
        ]);
    }
}
