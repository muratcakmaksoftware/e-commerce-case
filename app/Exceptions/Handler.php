<?php

namespace App\Exceptions;

use App\Enums\Languages\General\GeneralLanguageFile;
use App\Traits\APIResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use APIResponseTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            dd($e);
        });
    }

    public function render($request, Throwable $e)
    {
        if(config('app.debug')){
            if(isset($e)){
                dd($e);
            }
        }

        if($e instanceof ValidationException){
            return $this->responseBadRequest($e->validator->getMessageBag()->toArray());
        }
        return parent::render($request, $e);
    }
}
