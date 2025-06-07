<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
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
            if (app()->bound('sentry') && env('APP_ENV') == 'prod') {
                app('sentry')->captureException($e);
            }
        });

        $this->renderable(function (ValidationException $exception) {
            Log::error("ValidationException", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 0,
                'message' => $exception->getMessage(),
                'data' => [
                    'errors' => $exception->errors(),
                ]
            ], 422);
        });

        $this->renderable(function (AccessDeniedHttpException $exception) {
            Log::error("AccessDeniedHttpException", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 0,
                'message' => env('APP_ENV') == 'local' ? $exception->getMessage() : 'unauthorize',
            ], 401);
        });

        $this->renderable(function (AuthenticationException $exception) {
            Log::error("AuthenticationException", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            $data = [
                "status" => 0,
                "message" => "wrong password",
            ];
            return response()->json($data, 401);
        });

        $this->renderable(function (ItemNotFoundException $exception) {
            Log::error("ItemNotFoundException", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 0,
                'message' => env('APP_ENV') == 'local' ? $exception->getMessage() : 'item not error',
            ], 404);
        });

        $this->renderable(function (ModelNotFoundException $exception) {
            Log::error("ModelNotFoundException", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 0,
                'message' => env('APP_ENV') == 'local' ? $exception->getMessage() : 'item not error',
            ], 404);
        });

        $this->renderable(function (NotFoundHttpException $exception) {
            Log::error("NotFoundHttpException", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 0,
                'message' => env('APP_ENV') == 'local' ? $exception->getMessage() : 'item not found',
            ], 404);
        });

        $this->renderable(function (Exception $exception) {
            Log::error("request error", [
                'error' => $exception,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 0,
                'message' => env('APP_ENV') == 'local' ? $exception->getMessage() : 'request error',
            ], 400);
        });
    }
}
