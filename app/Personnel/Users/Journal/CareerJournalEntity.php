<?php

/**
 * @author Mark Prohorov <mark@intervolga.ru>
 */

namespace App\Personnel\Users\Journal;


use DateTime;


class CareerJournalEntity
{
    public string $departmentName = '';
    public string $position = '';
    public int $salary = 0;

    public ?DateTime $startedAt = null;
    public ?DateTime $endedAt = null;
}
