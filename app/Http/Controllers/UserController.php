<?php

namespace App\Http\Controllers;

use App\Personnel\Users\UsersStore;
use App\Personnel\Users\UsersStoreException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findUsers(UsersStore $usersStore, Request $request): JsonResponse
    {
        $filter = [];
        if ($request->get('search')) {
            $filter['find'] = $request->get('search');
        }
        if (!empty($request->get('excludedIds'))) {
            $filter['excludedIds'] = $request->get('excludedIds');
        }

        try {
            $users = $usersStore->findUsers($filter, []);
        } catch (UsersStoreException) {
            return response()->json(
                ['message' => 'Не удалось получить список пользователей'],
                500,
                [],
                JSON_UNESCAPED_UNICODE);
        }

        return response()->json(['users' => $users->all()], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
