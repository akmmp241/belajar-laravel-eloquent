<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();
        $person->first_name = 'Akmal Muhammad';
        $person->last_name = 'Pridianto';
        $person->save();

        self::assertEquals('AKMAL MUHAMMAD Pridianto', $person->full_name);

        $person->full_name = 'Joko Moro';
        $person->save();

        self::assertEquals('JOKO', $person->first_name);
        self::assertEquals('Moro', $person->last_name);
    }

    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = 'Akmal Muhammad';
        $person->last_name = 'Pridianto';
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }

    public function testCustomCast()
    {
        $person = new Person();
        $person->first_name = 'Akmal Muhammad';
        $person->last_name = 'Pridianto';
        $person->address = new Address('Jalan belum jadi', 'Semarang', 'Indonesia', 50198);
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        self::assertInstanceOf(Address::class, $person->address);
        self::assertEquals('Jalan belum jadi', $person->address->street);
        self::assertEquals('Semarang', $person->address->city);
        self::assertEquals('Indonesia', $person->address->country);
        self::assertEquals('50198', $person->address->post_code);
    }


}
