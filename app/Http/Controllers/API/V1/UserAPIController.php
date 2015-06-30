<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Repositories\User\UsersEloquent;
use App\Services\Support\Validator\User\APIValidator;


class UserAPIController extends APIController
{
    protected $data_type = 'user';

    public function __construct(UsersEloquent $repository, APIValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of all the resource.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $users = $this->repository->findAll($request->input('sort_column') ?: 'created_at',
            $request->input('sort_dir') ?: 'DESC',
            $request->input('limit') ?: '100');

        return $this->outputResponse($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $user = $this->repository->findById($id);

        if (!$user) {
            return $this->outputErrorResponse(['User Not Found With ID: ' . $id]);
        }

        return $this->outputResponse($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $input = array_except($request->all(), '_method');

        if (!$this->validator->passes()) {
            $errors = $this->validator->getErrors();

            return $this->outputErrorResponse($errors->all());
        }

        $user = $this->repository->createRow($input);

        return $this->outputResponse($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $id)
    {
        $input = array_except($request->all(), '_method');

        if (!$this->validator->passes()) {

            $errors = $this->validator->getErrors();

            return $this->outputErrorResponse($errors->all());
        }

        $user = $this->repository->findById($id);
        $user->updateRow($input);

        return $this->outputResponse($user);
    }

    /**
     *  Delete resource.
     *
     * @param  int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        $count = $this->repository->deleteRow($id);

        return $this->outputResponse($count . ' Rows Deleted');
    }


    /**
     *  Search resource.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $input = array_except($request->all(), '_method');

        $users = $this->repository->APIsearch($input);

        if (!is_object($users)) {
            return $this->outputErrorResponse($users);
        }

        return $this->outputResponse($users);
    }

}