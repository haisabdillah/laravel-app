<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Notifications\LoginAlert;

class LoginForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        //Send Notification Alert
        $ipAddress = request()->ip();
        $dateTime = \Carbon\Carbon::now();
        $location = null;
        if ((!Cache::get('limit-fetch-ip-address') ) && ($ipAddress !== '127.0.0.1' && ($ipAddress !== '::1'))) {
            $response = Http::get("http://ip-api.com/php/".$ipAddress."?fields=country,regionName,city,as,query");
            $responseJson = unserialize($response->body());
            $responseJson['xrl'] = (int) $response->getHeader('x-rl')[0];
            $responseJson['xttl'] = (int) $response->getHeader('x-ttl')[0];
            if (!$responseJson['xrl']) {
                Cache::add('limit-fetch-ip-address', 'value', $responseJson['xttl']);
            }
            $location = $responseJson['regionName'].",".$responseJson['country'];
        }

        auth()->user()->notify(new LoginAlert($ipAddress,$location,$dateTime));
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
