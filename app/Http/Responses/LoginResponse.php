<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        // Cek role user dan arahkan ke dashboard masing-masing
        if ($user->hasRole('admin')) {
            return redirect()->to('/admin');
        }

        if ($user->hasRole('student')) {
            return redirect()->to('/student');
        }

        if ($user->hasRole('staff')) {
            return redirect()->to('/staff');
        }

        return redirect()->to('/');
    }
}
