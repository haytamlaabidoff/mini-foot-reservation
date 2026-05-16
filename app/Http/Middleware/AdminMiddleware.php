<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 🚫 غير مسموح إذا ما كاينش user
        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ السماح فقط لـ admin و super_admin
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}