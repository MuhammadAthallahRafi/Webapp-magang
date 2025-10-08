<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    public const HOME = '/redirect-role'; // ini yang akan digunakan setelah login
}
