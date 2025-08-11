<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestDuringMaintenance extends Middleware
{
    protected $except = [];
}