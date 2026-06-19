<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    protected function successRedirect(string $route, string $message)
    {
        return redirect()->route($route)->with('success', $message);
    }

    protected function errorRedirect(string $message)
    {
        return back()->with('error', $message);
    }

    protected function formatRupiah(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}