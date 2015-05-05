<?php namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class APIController extends Controller {

    protected $repository;
    protected $validator;

    public function __construct()
    {
//        // API Auth Filter
//        Route::filter('apiauth', function($route, $request)
//        {
//            // Verify API key matches config
//            if(Request::header('x-api-key') != Config::get('app.key')) {
//                return Response::json(
//                    array(
//                        'error' => true,
//                        'message' => 'Unauthorized Request'
//                    ),
//                    401
//                );
//            }
//        });
//
//        // API Customer ID Exists Filter
//        Route::filter('id_exists', function($route)
//        {
//
//            $id = $route->getParameter('customers');
//
//            if(!isset($id) || $this->repository->findById($id) == false) {
//
//                return Response::json(
//                    array(
//                        'error' => true,
//                        'errors' => array('Customer ID not found')
//                    ),
//                    200
//                );
//            }
//        });
//
//
//
//        // Set Filters
//        $this->beforeFilter('apiauth');
//        $this->beforeFilter('id_exists', array('only' => array('show','update','destroy')));

    }

    /**
     * Generate the JSON output for API response
     *
     * @param $data
     * @return Response
     */
    protected function outputResponse($data)
    {
        return response()->json(
            [
                'error' => false,
                $this->data_type => $data
            ], 200
        );
    }


    /**
     * Generate the JSON output for API response
     *
     * @param $errors
     * @return Response
     */
    protected function outputErrorResponse($errors)
    {
        return response()->json(
            [
                'error' => true,
                'messages' => $errors
            ], 200
        );
    }
}