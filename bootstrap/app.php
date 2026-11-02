<?php

use App\Models\Redirect as CmsRedirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Redirects managed in the CMS are only looked up for URLs that no
        // longer exist, so regular pages never pay for the extra query.
        $exceptions->render(function (NotFoundHttpException $exception, Request $request): ?RedirectResponse {
            if (! $request->isMethodSafe()) {
                return null;
            }

            $redirect = CmsRedirect::findForPath($request->getPathInfo());

            if ($redirect === null) {
                return null;
            }

            $redirect->recordHit();

            return redirect()->to($redirect->targetUrl(), $redirect->status_code);
        });
    })->create();
