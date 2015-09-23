<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
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
        return parent::report($e);
    }




    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof HttpException && $e->getStatusCode() === 403) {
            return response()->json( [ 'message' => 'PHP Laravel Authentication failed!', 'code' => 403], 403 );
        }
        //$errorCode = $e->errorInfo[0];
        //$errorText = $e->errorInfo[2];
        /*/ handle 403 forbidden responses
        if ( $this->code === 403 ) {
            return response()->json( [ 'message' => 'PHP Laravel Authentication failed!', 'code' => 403], 403 );
        }*/

        // handle incorrect URLs
        if ( $e instanceof NotFoundHttpException ) {
            return response()->json( [ 'message' => 'Bad request, please verify your URL!', 'code' => 400 ], 400 );
        } else {
            return response()->json( [ 'message' => 'Unhandled error, please try again later! Code:'.$errorCode.' Error:'.$errorText, 'code' => 500 ], 500 );
        }

    }




}



