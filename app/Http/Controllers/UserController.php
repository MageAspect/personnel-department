<?php

namespace App\Http\Controllers;

use App\Personnel\Users\Journal\CareerJournalException;
use App\Personnel\Users\Journal\CareerJournalStore;
use App\Personnel\Users\UserNotFoundException;
use App\Personnel\Users\UserStore;
use App\Personnel\Users\UserStoreException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function index(): View
    {
        return view('users.list');
    }

    public function create(): View
    {
        return view('users.create');

    }

    public function show(int $id): View
    {
        return view('users.show', array('userId' => $id));
    }

    public function edit(int $id): View
    {
        return view('users.edit', array('userId' => $id));
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

    public function findUserCareerJournal(CareerJournalStore $journalStore, int $userId): JsonResponse {
        try {
            $journal = $journalStore->findJournal($userId);

            return response()->json(
                array_values($journal->all()),
                200,
                array(),
                JSON_UNESCAPED_UNICODE
            );
        } catch (CareerJournalException) {
            return response()->json(
                array('message' => 'Не удалось получить Журнал пользователя'),
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
