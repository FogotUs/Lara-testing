<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthenticateOnceWithBasicAuth
{
    /**
     * Проверяет входящие запросы - есть ли данные авторизации в БД, если есть,
     * то пропускает дальше, если нет - возвращает 401.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        return Auth::onceBasic('login') ?: $next($request);
    }

}
