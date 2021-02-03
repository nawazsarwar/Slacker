<?php


namespace myPHPnotes\Slacker\Middlewares;

use App\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;

class VerifyCsrfToken extends Middleware {

    public function __construct()
    {
        parent::__construct(app(), app('encrypter'));
    }
    public function addToExcept(string $route_identifier)
    {
        $this->except[] = $route_identifier;
    }
}
