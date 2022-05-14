<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Personnel\User\Journal;


use App\Models\CareerJournal;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;


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
    public function addRecord(string $userId, int $salary, string $position,  ?string $departmentId = null): void
    {
        try {
            $newRecord = array(
                'user_id' => $userId,
                'salary' => $salary,
                'position' => $position,
                'started_at' => Carbon::now(),
                'ended_at' => null,
            );

            if ($departmentId) {
                $newRecord['department_id'] = $departmentId;
            }

            $this->markAsEndedActiveRecords($userId);
            $this->careerJournal::create($newRecord);
        } catch (Exception $e) {
            throw new CareerJournalException(
                'Не удалось добавить запись в журнал', 0, $e);
        }
    }

    /**
     * @throws CareerJournalException
     */
    public function findJournal(string $userId, bool $salaryCanBeViewed = false): Collection
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
                if ($record->department) {
                    $r->departmentName = $record->department->name;
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
    protected function markAsEndedActiveRecords(string $userId): void
    {
        try {
            $this->careerJournal::query()
                ->where('user_id', $userId)
                ->whereNull('ended_at')
                ->update(
                    array(
                        'ended_at' => $this->careerJournal->freshTimestamp()
                    )
                );
        } catch (Exception $e) {
            throw new CareerJournalException(
                'Не удалось завершить запись в журнале', 0, $e);
        }
    }
}
