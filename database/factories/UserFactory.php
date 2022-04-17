<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return array(
            'name' => $this->faker->randomElement(array(
                'Марк',
                'Андрей',
                'Максим',
                'Антон',
                'Дмитрий',
                'Владимир',
                'Анатолий',
                'Степан',
                'Демьян',
            )),
            'last_name' => $this->faker->randomElement(array(
                'Королев',
                'Кузнецов',
                'Алексеев',
                'Юдин',
                'Шмелев ',
                'Скворцов',
                'Романов',
                'Матвеев',
                'Коротков',
                'Островский',
            )),
            'patronymic' => $this->faker->randomElement(array(
                'Артёмович',
                'Ярославович',
                'Максимович',
                'Маркович',
                'Николаевич',
                'Максимович',
                'Александрович',
                'Кириллович',
                'Леонидович',
            )),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => $this->faker->randomElement(array(
                '8 (435) 222 18-43',
                '8 (435) 565 29-45',
                '8 (345) 657 18-46',
                '8 (678) 345 17-78',
                '8 (177) 127 15-43',
                '8 (396) 926 25-56',
                '8 (479) 126 74-43',
                '8 (295) 267 64-87',
                '8 (946) 566 15-85',
                '8 (257) 666 34-36',
                '8 (444) 666 44-32',
            )),
            'salary' => $this->faker->numberBetween(30, 150) * 1000,
            'position' => $this->faker->randomElement(array(
                'Руководитель отдела',
                'Менеджер',
                'Бухгалтер',
                'Помощник бухгалтера',
                'Программист',
                'Тим лид',
                'Старший программист',
            )),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return array(
                'is_admin' => true,
            );
        });
    }
}
