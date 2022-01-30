<?php

namespace App\Http\Controllers;

use App\Personnel\Users\UserStore;
use App\Personnel\Users\UserStoreException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserController extends Controller
{

    public function index(): View
    {
        return view('users.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function findUsers(UserStore $userStore, Request $request): JsonResponse
    {
        $filter = [];
        if (!empty($request->get('search'))) {
            $filter['find'] = $request->get('search');
        }
        if (!empty($request->get('excludedIds'))) {
            $filter['excludedIds'] = $request->get('excludedIds');
        }

        $sort = array();
        if (!empty($request->get('sort'))) {
            $sort = $this->getProtectedSort($request->get('sort'));
        }

        $offset = 0;
        if (!empty($request->get('offset'))) {
            $offset = $request->get('offset');
        }

        $limit = 20;
        if (!empty($request->get('limit'))) {
            $limit = $request->get('limit');
        }

        try {
            $users = $userStore->findUsers($filter, $sort, $offset, $limit);
        } catch (UserStoreException) {
            return response()->json(
                ['message' => 'Не удалось получить список пользователей'],
                500,
                [],
                JSON_UNESCAPED_UNICODE);
        }

        return response()->json($users->all(), 200, [], JSON_UNESCAPED_UNICODE);
    }

    protected function getProtectedSort(array $rawSort): array
    {
        $protectedSort = array();

        $sortableColumns = array(
            'id',
            'name',
            'lastName',
            'patronymic',
            'email',
            'position',
        );
        $allowedDirections = array(
            'asc',
            'desc'
        );

        foreach ($rawSort as $column => $direction) {
            if (!in_array($column, $sortableColumns) || !in_array($direction, $allowedDirections)) {
                continue;
            }

            $protectedSort[$column] = $direction;
        }

        return $protectedSort;
    }
}
