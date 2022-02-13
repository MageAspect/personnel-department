<?php

/**
 * @author Mark Prohorov <mark@intervolga.ru>
 */

namespace App\Personnel\Users\Journal;


use App\Models\CareerJournal;
use App\Models\Department;
use App\Personnel\Users\UserStore;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class CareerJournalStore
{
    private CareerJournal $careerJournal;
    private Department $department;
    private UserStore $userStore;

    public function __construct(CareerJournal $careerJournal, Department $department, UserStore $userStore)
    {
        $this->careerJournal = $careerJournal;
        $this->department = $department;
        $this->userStore = $userStore;
    }

    /**
     * @throws CareerJournalException
     */
    public function addRecord(int $userId, int $departmentId, int $salary, string $position): void
    {
        try {
            $department = $this->department::query()->findOrFail($departmentId);

            $newRecord = array(
                'user_id' => $userId,
                'department_id' => $departmentId,
                'department_name' => $department->name,
                'salary' => $salary,
                'position' => $position,
            );

            DB::beginTransaction();
            $this->markAsEndedActiveRecords($userId);
            $this->careerJournal::create($newRecord);
            DB::commit();
        } catch (ModelNotFoundException $e) {
            throw new CareerJournalException(
                'Не удалось добавить запись в журнал - отдел не существет',
                0,
                $e
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new CareerJournalException(
                'Не удалось добавить запись в журнал', 0, $e);
        }

    }

    /**
     * @throws CareerJournalException
     */
    public function findJournal(int $userId): Collection
    {
        try {
            $user = $this->userStore->findById($userId);

            $records = $this->careerJournal::query()
                ->with('department')
                ->where('user_id', $userId)
                ->get();

            $result = array();
            foreach ($records as $record) {
                $r = new CareerJournalEntity();
                if ($user->salaryCanBeViewed) {
                    $r->salary = $record->salary;
                }
                $r->position = $record->position;
                $r->startedAt = $record->started_at;
                $r->endedAt = $record->ended_at;

                $result[] = $r;
            }

            return collect($result);
        } catch (Exception $e) {
            throw new CareerJournalException(
                'Не получить журнал продвижения пользователя', 0, $e);
        }
    }

    /**
     * @throws CareerJournalException
     */
    protected function markAsEndedActiveRecords(int $userId): void
    {
        try {
            $this->careerJournal::query()
                ->where('user_id', $userId)
                ->whereNull('ended_at')
                ->update(
                    array(
                        'ended_at' => Carbon::now()
                    )
                );
        } catch (Exception $e) {
            throw new CareerJournalException(
                'Не удалось завершить запись в журнале', 0, $e);
        }
    }
}
