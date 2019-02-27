<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    use  ApiResponser;
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)

    {

        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }
        if($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));
            return response()->json(["Message"=> "{$modelName} not found"]);
        }
        if($exception instanceof AuthorizationException){
            
            return response()->json(["Message"=> "You are not authorized to perfom this operation"]);
        }
        if($exception instanceof AuthenticationException){
            
            return $this->unauthenticated($request,$exception);
        }
       
       
        if($exception instanceof MethodNotAllowedHttpException){
            
            return response()->json(["Message"=> "The specified method for the request is invalid.Please confirm the method and try again"]);
        }
        if($exception instanceof NotFoundHttpException){
            
            return response()->json(["Message"=> "The specified Url is incorrect or invalid.Please type the corect url"]);
        }
        if($exception instanceof HttpException){
            
            return response()->json([$exception->getMessage(),$exception->getStatusCode()]);
        }

        if($exception instanceof QueryException){
            
            $errorCode=$exception->errorInfo[1];
            if($errorCode==1451){
                return response()->json(["Message"=> "You are not allowed to remove a resource referencing other tables"]);
            }

            
        }
        if($exception instanceof TokenMismatchException){
            
            return redirect()->back()->withInput($request->input());
        }
        

        return parent::render($request, $exception);
    }
protected function unauthenticated($request, AuthenticationException $exception)

{ if($this->isFrontend($request)){
    return \redirect()->guest('login');

}

return $this->errorResponse('Unauthenticated',401);
}
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    { 
       $errors=$e->validator->errors()->getMessages();
       if($this->isFrontend($request)){
           return $request->ajax() ? response()->json($error,422):redirect()
           ->back()
           ->withInput($request->input())
           ->withErrors($errors);
       }
      
       return response()->json($errors,422);
    }
   
public function isFrontend($request){
    return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
}

}