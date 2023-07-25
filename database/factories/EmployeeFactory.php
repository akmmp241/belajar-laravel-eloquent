<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'id' => '',
            'name' => '',
            'title' => '',
            'salary' => 0
        ];
    }

    public function programmer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Programmer',
                'salary' => 5000000
            ];
        });
    }

    public function seniorProgrammer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Senior Programmer',
                'salary' => 10000000
            ];
        });
    }
}
