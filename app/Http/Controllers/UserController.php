<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonHttpResponseException;
use App\Http\Requests\UserStoreRequest;
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
use Illuminate\Support\Facades\App;


class UserController extends Controller
{
    private UserStore $userStore;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userStore = App::make(UserStore::class);

            return $next($request);
        });
    }

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

    public function store(UserStoreRequest $request): JsonResponse
    {
        $u = $this->getFromRequest($request);

        return $this->jsonResponse(array(
            'id' => $this->userStore->store($u, $request->get('newPassword'))
        ));
    }

    public function update(int $id, Request $request): JsonResponse|Response
    {
        $u = $this->getFromRequest($request);
        $u->id = $id;

        $currentPassword = $request->get('currentPassword');
        if (strlen($currentPassword) > 0 && !$this->userStore->isCorrectPassword($id, $currentPassword)) {
            return response()->json(
                array('message' => 'Неверный текущий пароль'),
                422,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        if (!$this->userStore->isUniqueEmail($u->email, $id)) {
            return response()->json(
                array('message' => 'Данный email уже занят'),
                422,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }

        try {
            if ($request->get('newPassword')) {
                $this->userStore->update($u, $request->get('newPassword'));
            } else {
                $this->userStore->update($u);
            }
        } catch (Exception) {
            throw new JsonHttpResponseException('Ошибка обновления пользователя' );
        }

        return response()->noContent();
    }

    public function destroy(int $id): JsonResponse|Response
    {
        try {
            $this->userStore->delete($id);
        } catch (UserStoreException) {
            throw new JsonHttpResponseException('Ошибка удаления пользователя' );
        }

        return response()->noContent();
    }

    public function findUsers(Request $request): JsonResponse
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
            $users = $this->userStore->findUsers($filter, $sort, $offset, $limit);
            $count = $this->userStore->findUsersCount($filter);

            return $this->jsonResponse(
                array_values($users->all()),
                200,
                array('X-Total-Count' => $count),
            );
        } catch (UserStoreException) {
            throw new JsonHttpResponseException('Не удалось получить список пользователей');
        }
    }

    public function findById(int $id): JsonResponse {
        try {
            $user = $this->userStore->findById($id);

            return $this->jsonResponse($user);
        } catch (UserNotFoundException) {
            return $this->jsonResponse(
                array(),
                204
            );
        } catch (UserStoreException $e) {
            throw new JsonHttpResponseException($e->getMessage());
        }
    }

    public function findUserCareerJournal(CareerJournalStore $journalStore, int $userId): JsonResponse {
        try {
            $user = $this->userStore->findById($userId);
            $journal = $journalStore->findJournal($userId, $user->salaryCanBeViewed);

            return $this->jsonResponse(
                array_values($journal->all())
            );
        } catch (CareerJournalException|UserStoreException) {
            throw new JsonHttpResponseException('Не удалось получить Журнал пользователя');
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

        if ($request->hasFile('avatar')) {
            $u->avatar = $this->uploadAvatar($request->file('avatar'));
        }

        return $u;
    }

    protected function uploadAvatar(UploadedFile $avatar): string {
        return $avatar->storePublicly('avatars', array('disk' => 'public'));
    }
}
