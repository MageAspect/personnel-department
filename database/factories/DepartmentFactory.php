<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->keyBy('id');
        return array(
            'name' => $this->faker->unique()->randomElement(array(
               'Отдел продаж',
               'Отдел разработки',
               'Отдел маркетинга',
               'Бухгалтерия',
               'Руководство',
               'Отдел проектов',
               'Техподдержка',
               'Дизайн',
               'SEO',
            )),
            'description' => $this->faker->randomElement(array(
                'Представляет коллаборацию двух дружественных проектов из Калифорнии, которые объединились вокруг ностальгии по атмосфере 90-х.',
                'Структурное подразделение в гражданских или военных организациях и управлениях некоторых формирований.',
                'Один из первый отделов в компании.',
            )),
            'head_id' => $this->faker->randomElement($users)
        );
    }
}
