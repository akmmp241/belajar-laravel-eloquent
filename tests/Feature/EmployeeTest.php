<?php

namespace Tests\Feature;

use App\Models\Employee;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function testFactory()
    {
        $empolyee1 = Employee::factory()->programmer()->make();
        $empolyee1->id = '1';
        $empolyee1->name = 'employee 1';
        $empolyee1->save();

        self::assertNotNull(Employee::where('id', '=', 1)->first());

        $empolyee2 = Employee::factory()->seniorProgrammer()->create([
            'id' => '2',
            'name' => 'employee 2'
        ]);

        self::assertNotNull($empolyee2);
        self::assertNotNull(Employee::where('id', '=', 2)->first());
    }

}
