<?php

/**
 * @author mosowell https://github.com/mosowell
 */

namespace App\Personnel;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;


class DepartmentEntry
{
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public ?UserEntry $head = null;
    public bool $canEdit = false;
    public bool $canDelete = false;

    /**
     * @var UserEntry[]
     */
    public array $members = [];

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromModel( $d): DepartmentEntry
    {
        $department = new DepartmentEntry($d->id);
        $department->name = $d->name;
        $department->description = $d->description;
        $department->head = UserEntry::fromModel($d->head);
        $department->canEdit = Gate::allows('update', $d);
        $department->canDelete = Gate::allows('delete', $d);

        foreach ($d->members as $m) {
            $department->members[] = UserEntry::fromModel($m);
        }

        return $department;
    }
}
