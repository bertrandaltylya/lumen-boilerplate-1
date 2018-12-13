<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidatorException) {
            return $this->prettusValidation($exception);
        }

        $rendered = parent::render($request, $exception);
        return response()->json([
            'error' => [
                'code' => $rendered->getStatusCode(),
                'message' => $exception->getMessage(),
            ],
        ], $rendered->getStatusCode());
    }

    private function prettusValidation(ValidatorException $exception)
    {
        return response()->json([
            'error' => [
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $exception->getMessageBag(),
            ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
