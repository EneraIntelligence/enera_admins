<?php

namespace Admins\Exceptions;

use Admins\Libraries\IssueTrackerHelper;
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
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $debug = env('APP_DEBUG');
        if ($debug == 0) {
            IssueTrackerHelper::create($request, $e, 'Admins');
            if ($this->isHttpException($e)) {
                return $this->renderHttpException($e);
            } else if ($e instanceof NotFoundHttpException) {
                return response()->view('error.404', [], 404);
            } else if ($e instanceof FatalErrorException) {
                return response()->view('errors.503', [], 503);
            } else if ($e instanceof Exception) {
                return response()->view('errors.500', [], 500);
            } else {
                return response()->view('errors.500', [], 500);
            }
        } elseif ($debug == 1) {
            if ($e instanceof ModelNotFoundException) {
                $e = new NotFoundHttpException($e->getMessage(), $e);
            }
            IssueTrackerHelper::create($request, $e, 'Admins');
            return parent::render($request, $e);
        }
    }
}
