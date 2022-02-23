<?php

namespace App\Http\Controllers;

use App\Personnel\Users\Journal\CareerJournalException;
use App\Personnel\Users\Journal\CareerJournalStore;
use App\Personnel\Users\UserEntity;
use App\Personnel\Users\UserNotFoundException;
use App\Personnel\Users\UserStore;
use App\Personnel\Users\UserStoreException;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;


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

    public function store(Request $request, UserStore $userStore): JsonResponse
    {
        $u = $this->getFromRequest($request);

        if (!$userStore->isUniqueEmail($request->get('email'))) {
            return response()->json(
                array('message' => 'Данный email уже занят'),
                422,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        if ($request->hasFile('avatar')) {
            $u->avatar = $this->uploadAvatar($request->file('avatar'));
        }

        $password = $request->get('newPassword');

        return response()->json(
            array('id' => $userStore->store($u, $password))
        );
    }

    public function update(int $id, Request $request, UserStore $userStore): JsonResponse|Response
    {
        $u = $this->getFromRequest($request);
        $u->id = $id;

        $currentPassword = $request->get('currentPassword');
        if (strlen($currentPassword) > 0 && !$userStore->isCorrectPassword($id, $currentPassword)) {
            return response()->json(
                array('message' => 'Неверный текущий пароль'),
                422,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        if (!$userStore->isUniqueEmail($u->email, $id)) {
            return response()->json(
                array('message' => 'Данный email уже занят'),
                422,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        if ($request->hasFile('avatar')) {
            $u->avatar = $this->uploadAvatar($request->file('avatar'));
        }

        try {
            if ($request->get('newPassword')) {
                $userStore->update($u, $request->get('newPassword'));
            } else {
                $userStore->update($u);
            }
        } catch (Exception) {
            return response()->json(
                array('message' => 'Ошибка обновления пользователя'),
                422,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        return response()->noContent();
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

    public function findById(UserStore $userStore, int $id): JsonResponse {
        try {
            $user = $userStore->findById($id);

            return response()->json(
                $user,
                200,
                array(),
                JSON_UNESCAPED_UNICODE
            );
        } catch (UserNotFoundException) {
            return response()->json(
                array(),
                204,
                array(),
                JSON_UNESCAPED_UNICODE);
        } catch (UserStoreException $e) {
            return response()->json(
                array('error' => $e->getMessage()),
                500,
                array(),
                JSON_UNESCAPED_UNICODE);
        }
    }

    public function findUserCareerJournal(CareerJournalStore $journalStore, int $userId, UserStore $userStore): JsonResponse {
        try {
            $user = $userStore->findById($userId);
            $journal = $journalStore->findJournal($userId, $user->salaryCanBeViewed);

            return response()->json(
                array_values($journal->all()),
                200,
                array(),
                JSON_UNESCAPED_UNICODE
            );
        } catch (CareerJournalException|UserStoreException) {
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

    protected function getFromRequest(Request $request): UserEntity
    {
        $u = new UserEntity();
        $u->name = $request->get('name');
        $u->lastName = $request->get('lastName');
        $u->patronymic = $request->get('patronymic');
        $u->email = $request->get('email');
        $u->phone = $request->get('phone');
        $u->position = $request->get('position');
        $u->salary = $request->get('salary');

        return $u;
    }

    protected function uploadAvatar(UploadedFile $avatar): string {
        return $avatar->storePublicly('avatars', array('disk' => 'public'));
    }
}
