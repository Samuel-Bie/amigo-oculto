<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller
{
    public function install()
    {
        // Artisan::call('migrate:fresh');
        return 'done';
    }

    public function artisan()
    {
        exec('composer dump');
        exec('composer dump-auto');
        exec('composer dump-autoload');
        Artisan::call('key:generate');
        Artisan::call('clear-compiled');
        Artisan::call('auth:clear-resets');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('view:cache');
        Artisan::call('storage:link');
        return 'sucesso';
    }
}
