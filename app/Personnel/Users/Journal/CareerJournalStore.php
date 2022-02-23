<?php

/**
 * @author Mark Prohorov <mark@intervolga.ru>
 */

namespace App\Personnel\Users\Journal;


use App\Models\CareerJournal;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class CareerJournalStore
{
    private CareerJournal $careerJournal;

    public function __construct(CareerJournal $careerJournal)
    {
        $this->careerJournal = $careerJournal;
    }

    /**
     * @throws CareerJournalException
     */
    public function addRecord(int $userId, int $salary, string $position,  ?int $departmentId = null): void
    {
        try {
            $newRecord = array(
                'user_id' => $userId,
                'salary' => $salary,
                'position' => $position,
            );

            if ($departmentId) {
                $newRecord['department_id'] = $departmentId;
            }

            DB::beginTransaction();
            $this->markAsEndedActiveRecords($userId);
            $this->careerJournal::create($newRecord);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new CareerJournalException(
                'Не удалось добавить запись в журнал', 0, $e);
        }

    }

    /**
     * @throws CareerJournalException
     */
    public function findJournal(int $userId, bool $salaryCanBeViewed = false): Collection
    {
        try {
            $records = $this->careerJournal::query()
                ->with('department')
                ->where('user_id', $userId)
                ->get();

            $result = array();
            foreach ($records as $record) {
                $r = new CareerJournalEntity();
                if ($salaryCanBeViewed) {
                    $r->salary = $record->salary;
                }
                $r->departmentName = $record->department->name;
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
