<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel;


use App\Models\Department;


class DepartmentEntry
{
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public ?UserEntry $head = null;

    /**
     * @var UserEntry[]
     */
    public array $members = [];

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromModel(Department $d): DepartmentEntry
    {
        $department = new DepartmentEntry($d->id);
        $department->name = $d->name;
        $department->description = $d->description;
        $department->head = UserEntry::fromModel($d->head);

        foreach ($d->members as $m) {
            $department->members[] = UserEntry::fromModel($m);
        }

        return $department;
    }
}
