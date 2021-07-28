<?php

namespace App\Exceptions;
use Response;
use Exception;
use Throwable;
use App\Exceptions\ExceptionTrait;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class Handler extends ExceptionHandler
{
    use ExceptionTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
       //
        
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'title',
        'body',
        'completed'
    ];

    public function report(Throwable $exception){
// 
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
   

 public function render($request, Throwable $exception)
 {
     if ($exception instanceof NotFoundHttpException) {
         return Route::respondWithRoute('fallback');
        
     }

     if ($exception instanceof ModelNotFoundException) {
         return Route::respondWithRoute('fallback');
     }

     if ($exception instanceof TokenInvalidException) {
        return Route::respondWithRoute('fallback');
    }

    if ($exception instanceof TokenExpiredException) {
        return Route::respondWithRoute('fallback');
    }

    if ($exception instanceof JWTException) {
        return Route::respondWithRoute('fallback');
    }

    if ($exception instanceof FileNotFoundException) {
        return Route::respondWithRoute('fallback');
    }

    if ($exception instanceof errorException) {
        return Route::respondWithRoute('fallback');
    }


     return parent::render($request, $exception);

 }

}
