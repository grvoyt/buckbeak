<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json(
                data: [
                    'message' => $e->getMessage(),
                ],
                status: Response::HTTP_UNAUTHORIZED
            );
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json(
                data: [
                    'message' => $e->getMessage(),
                ],status: Response::HTTP_NOT_FOUND
            );
        });
    }
}
