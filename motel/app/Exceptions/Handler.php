<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\User\Contracts\Authentication;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
      if ($request->expectsJson()) {
            $message = $exception->getMessage();
            $code = $exception->getCode();

            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                $code = Response::HTTP_FORBIDDEN;
            }

            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException) {
                $message = 'Too many requests. Slow your roll!';
                $code = $exception->getCode();
            }

            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $message = 'Not Found.';
                $code = Response::HTTP_NOT_FOUND;
            }

            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $message = 'Not Found.';
                $code = Response::HTTP_NOT_FOUND;
            }
            if ($exception instanceof ValidationException) {
                $message = 'Not Found.';
                $code = Response::HTTP_BAD_REQUEST;
            }

            return response()->json([
                'success' => false,
                'error' => [
                    'description' => $message,
                    'error_code' => $code,
                    'error_messages' => $exception->getMessage()
                ]
            ], Response::HTTP_OK);
        }
        return parent::render($request, $exception);
    }

    private function handleExceptions($e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        return response()->view('errors.500', [], 500);
    }
}
