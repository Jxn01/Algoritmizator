<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Class Handler
 *
 * The Handler class is responsible for handling exceptions that are not caught by the application.
 * It extends the base Handler class provided by Laravel.
 *
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * This method is called when an exception is thrown and not caught by the application.
     * It checks if the exception is a NotFoundHttpException, and if so, it renders a 'NotFound' view using Inertia.
     * Otherwise, it calls the parent render method to handle the exception.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @param  Throwable  $e  The exception that was thrown.
     * @return \Symfony\Component\HttpFoundation\Response The HTTP response.
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): \Symfony\Component\HttpFoundation\Response
    {
        if ($e instanceof NotFoundHttpException) {
            Inertia::render('NotFound');

            return new Response('', 404);
        }

        return parent::render($request, $e);
    }
}
