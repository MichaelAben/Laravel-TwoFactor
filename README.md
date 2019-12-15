### Installation
`composer require maben-dev/laravel-twofactor` \
`php artisan migrate`

Now you need to make your user model use MabenDev\TwoFactor\Traits\HasTwoFactor
 
DONE!

### Usage
On the user model you have acces to the function `$user->setupTwoFactor`, with this function you give the user a 2fa secret.

From here on out the user needs to give his 2fa code every time his session is lost and the user tries to access a route that has the TwoFactor middleware on it.

To delete his 2fa, just do `$user->twoFactor->delete()`.

To edit the views, localization and config do: `php artisan vendor:publish --provider="MabenDev\TwoFactor\ServiceProvider"`

### How it works under water
If the user access a route with the TwoFactor middleware on it, the middleware will check if the user is logged in, if not it does nothing. \
If the user is logged in and has the session required, the middleware will do nothing. \
If the user does not have a 2fa, the middleware will do nothing. \
If anything else the middleware will redirect the user to the 2fa-form route, created by the package.

On the 2fa form the user will see a qr code if it's the first time using it, after this the qr will never show up again.

The user gives his 2fa code, the package checks it and if the code is good, the user will be redirected back to the location he came from, or the redirect_url of the config or if both are no valid url's to /home. \
If the user gives a bad code, he will be shown with a error and can try again.

### IMPORTANT NOTES
There are some functions on your user model that can help you with customizing the user experience, but be aware the getQr function should never be used if the 2fa is already setup. \
The secret should never be visible by anyone, besides the user on the first time setting things up. \
If in any way the secret is compromised delete it and setup a new 2fa secret. \
