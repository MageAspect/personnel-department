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

    public function destroy(UserStore $userStore, int $id): JsonResponse
    {
        try {
            $userStore->delete($id);
        } catch (UserStoreException $e) {
            return response()->json(
                array(
                    'error' => $e->getMessage()
                ),
                500
            );
        }

        return response()->json();
    }

    public function findUsers(UserStore $userStore, Request $request): JsonResponse
    {
        $filter = [];
        if (!empty($request->get('search'))) {
            $filter['find'] = $request->get('search');
        }

        $filter['excludedIds'] = $request->get('excludedIds') ?: array();

        $sort = $this->getProtectedSort($request->get('sort') ?: array());

        $offset = $request->get('offset') ?: 0;
        $limit = $request->get('limit') ?: 20;

        try {
            $users = $userStore->findUsers($filter, $sort, $offset, $limit);
            $count = $userStore->findUsersCount($filter);

            return response()->json(
                array_values($users->all()),
                200,
                array('X-Total-Count' => $count),
                JSON_UNESCAPED_UNICODE
            );
        } catch (UserStoreException) {
            return response()->json(
                array('message' => 'Не удалось получить список пользователей'),
                500,
                array(),
                JSON_UNESCAPED_UNICODE);
        }
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
