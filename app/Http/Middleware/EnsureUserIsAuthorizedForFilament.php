<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAuthorizedForFilament
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        if (
            !$user->active ||
            !in_array($user->role, ['admin', 'doctor'])
        ) {
            // 🔒 تسجيل الخروج بطريقة آمنة جدًا:
            auth()->logout();

            // ⛔ تأكد من إبطال الجلسة ومنع token mismatch
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('filament.admin.auth.login')
                ->withErrors([
                    'email' => 'الحساب غير مفعل أو لا يملك صلاحية الدخول للوحة التحكم.',
                ]);
        }

        return $next($request);
    }
}
