<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * A list of exception types with their corresponding custom log levels.
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        \App\Exceptions\RateLimitExceededException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Handle many authentication issues
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($this->isApiRequest($request)) {
                $message = $this->getAuthenticationMessage($request, $e);

                return $this->apiErrorResponse('Unauthenticated', $message, 401);
            }
        });

        // 400 Bad Request
        $this->renderable(function (BadRequestHttpException $e, $request) {
            if ($this->isApiRequest($request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bad Request',
                    'errors' => $e->getMessage(),
                ], 400);
            }
        });

        // 403 Forbidden (Missing Abilities)
        $this->renderable(function (MissingAbilityException $e, $request) {
            if ($this->isApiRequest($request)) {
                return $this->apiErrorResponse(
                    'Forbidden',
                    'Anda tidak memiliki izin untuk mengakses resource ini.',
                    403
                );
            }
        });

        $this->renderable(function (RouteNotFoundException $e, $request) {
            if ($this->isApiRequest($request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email belum terverifikasi.',
                    'errors' => [
                        'verified' => false,
                    ],
                ], 403);
            }
        });

        // 404 Not Found (Model)
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($this->isApiRequest($request)) {
                return $this->apiErrorResponse(
                    'Not Found',
                    'Data yang diminta tidak ditemukan.',
                    404
                );
            }
        });

        // 404 Not Found (Route)
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($this->isApiRequest($request)) {
                $message = $e->getMessage();

                if (strpos($message, 'could not be found') !== false || empty($message)) {
                    $message = 'Endpoint yang diminta tidak ditemukan.';
                }

                return $this->apiErrorResponse(
                    'Not Found',
                    $message,
                    404
                );
            }
        });

        // 405 Method Not Allowed
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($this->isApiRequest($request)) {
                return $this->apiErrorResponse(
                    'Method Not Allowed',
                    'Method HTTP tidak diperbolehkan untuk endpoint ini.',
                    405
                );
            }
        });

        // 422 Validation Error
        $this->renderable(function (ValidationException $e, $request) {
            if ($this->isApiRequest($request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // 429 Too Many Requests
        $this->renderable(function (TooManyRequestsHttpException $e, $request) {
            if ($this->isApiRequest($request)) {
                $retryAfter = $e->getHeaders()['Retry-After'] ?? null;

                return response()->json([
                    'success' => false,
                    'message' => 'Too Many Requests',
                    'errors' => [
                        'message' => ['Terlalu banyak permintaan. Silakan coba lagi nanti.'],
                        'retry_after' => $retryAfter,
                    ],
                ], 429);
            }
        });

        // 500 Database Error
        $this->renderable(function (QueryException $e, $request) {
            if ($this->isApiRequest($request)) {
                Log::error('Database Error: '.$e->getMessage(), [
                    'sql' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]);

                $message = config('app.debug')
                    ? 'Database Error: '.$e->getMessage()
                    : 'Terjadi kesalahan pada database. Silakan coba lagi.';

                return $this->apiErrorResponse('Database Error', $message, 500);
            }
        });

        $this->reportable(function (Throwable $e) {});
    }

    /**
     * Handle unauthenticated requests
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isApiRequest($request)) {
            $message = $exception->getMessage() === 'Unauthenticated.'
                ? 'Token tidak valid atau sudah kadaluwarsa. Silakan login kembali.'
                : $exception->getMessage();

            return $this->apiErrorResponse('Unauthenticated', $message, 401);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated',
            'errors' => ['message' => ['Authentication required']],
        ], 401);
    }

    /**
     * Get appropriate authentication error message based on request
     */
    protected function getAuthenticationMessage($request, $exception): string
    {
        $authHeader = $request->header('Authorization');

        if (! $authHeader) {
            return 'Header Authorization diperlukan. Silakan sertakan token Bearer.';
        }

        if (! str_starts_with($authHeader, 'Bearer ')) {
            return 'Format token tidak valid. Gunakan format: Bearer <token>';
        }

        $token = str_replace('Bearer ', '', $authHeader);

        if (empty(trim($token))) {
            return 'Token kosong. Silakan sertakan token yang valid.';
        }

        if (strlen($token) < 10) {
            return 'Format token tidak valid.';
        }

        $originalMessage = $exception->getMessage();
        if ($originalMessage && $originalMessage !== 'Unauthenticated.') {
            return $originalMessage;
        }

        return 'Token tidak valid atau sudah kadaluwarsa. Silakan login kembali.';
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        if ($this->isApiRequest($request)) {
            if ($e instanceof AuthenticationException) {
                return $this->unauthenticated($request, $e);
            }

            $response = parent::render($request, $e);

            if ($response->getStatusCode() >= 500 && ! $this->isHttpException($e)) {
                return $this->handleGeneralException($e, $request);
            }

            return $response;
        }

        return parent::render($request, $e);
    }

    /**
     * Handle general exceptions for API requests
     */
    protected function handleGeneralException(Throwable $e, $request)
    {
        Log::error('Unhandled Exception: '.$e->getMessage(), [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->id(),
        ]);

        if (config('app.debug')) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'errors' => [
                    'message' => [$e->getMessage()],
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => collect($e->getTrace())->take(5)->toArray(),
                ],
            ], 500);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'errors' => [
                    'message' => ['Terjadi kesalahan internal server. Silakan coba lagi nanti.'],
                    'error_id' => uniqid(),
                ],
            ], 500);
        }
    }

    /**
     * Check if request is API request
     */
    protected function isApiRequest($request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    /**
     * Create standardized API error response
     */
    protected function apiErrorResponse(string $message, string $detail, int $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => [
                'message' => [$detail],
            ],
        ], $status);
    }
}
