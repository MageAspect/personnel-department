<?php

/**
 * @author MageAspect https://github.com/mageaspect
 */

namespace App\Personnel\User\Journal;


use DateTime;


class CareerJournalEntity
{
    public string $departmentName = '';
    public string $position = '';
    public int $salary = 0;

    public ?DateTime $startedAt = null;
    public ?DateTime $endedAt = null;
}
