<?php

namespace App\Http\Controllers;

use App\Exceptions\JsonHttpResponseException;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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
        try {
            $u = $this->getFromRequest($request);

            return $this->jsonResponse(array(
                'id' => $this->userStore->store($u, $request->get('newPassword'))
            ));
        } catch (Exception) {
            throw new JsonHttpResponseException('Ошибка добавления пользователя');
        }
    }

    public function update(UserUpdateRequest $request): JsonResponse|Response
    {
        try {
            $u = $this->getFromRequest($request);

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
            return $this->jsonResponse($this->userStore->findById($id));
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

    /**
     * @throws UserStoreException
     * @throws UserNotFoundException
     */
    protected function getFromRequest(Request $request): UserEntity
    {
        $user = new UserEntity();

        $userId = $request->route()->parameter('id');
        if ($userId > 0) {
            $user = $this->userStore->findById($userId);
        }

        $user->name = $request->get('name');
        $user->lastName = $request->get('lastName');
        $user->patronymic = $request->get('patronymic');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->position = $request->get('position');
        $user->salary = $request->get('salary');

        if (
            $request->hasFile('avatar')
            && in_array($request->file('avatar')->getMimeType(), array('image/png','image/jpg','image/jpeg'))
        ) {
            $user->avatar = $this->uploadAvatar($request->file('avatar'));
        }

        if ($request->has('clearAvatar')) {
            $user->avatar = null;
        }

        return $user;
    }

    protected function uploadAvatar(UploadedFile $avatar): string {
        return $avatar->storePublicly('avatars', array('disk' => 'public'));
    }
}
