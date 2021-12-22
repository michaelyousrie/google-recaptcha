# what is this?

This is a simple package that implements google recaptcha V3 into a laravel application to make it super easy to protect forms against bots and spammers (hopefully).

# How to use it?

Simple: 
- you install it from composer using: `composer require michaelyousrie/google-recaptcha`
- Publish the config file using `php artisan vendor:publish` and choose the correct number for the service provider `Michael\GoogleRecpatcha\GoogleRecaptchaServiceProvider`
- A new config file will be published to your configuration folder (config/google_recaptcha.php). Add your google recaptcha key and secret credentials there.
- Then go to your form and add the blade directive `@google_recaptcha([FORM-ID])` which will be responsible for the front-end side of the integration.
- Add the middleware `Michael\GoogleRecaptcha\Middlewares\ProtectedByGoogleRecaptcha` which will be responsible for the back-end side of the integration.

## On a failed recaptcha verification, the user will be redirected back to the previous page `redirect()->back()` and a log entry will be added to your logs. Very simple.
