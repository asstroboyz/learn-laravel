<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependencyInjection()
    {

        // foo = new Foo();
        $foo1 = $this->app->make(Foo::class);  // same  new foo();
        $foo2 = $this->app->make(Foo::class);  // same  new foo();


        self::assertEquals('Foo',$foo1->foo());
        self::assertEquals('Foo',$foo2->foo());
        self::assertNotSame($foo1, $foo2); // different instances
    }

    public function testBind(){
        // $person = $this->app->make(Person::class);
        // self::assertNotNull($person);
        $this->app->bind(Person::class, function ($app) {
            return new Person('Ganda', 'Gunawan');
        });
        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);
        self::assertEquals('Ganda', $person1->firstName);
        // self::assertEquals('Gunawan', $person1->lastName);
        self::assertEquals('Ganda', $person2->firstName);
        // self::assertEquals('Gunawan', $person2->lastName);
        self::assertNotSame($person1, $person2); // different instances
    }
    public function testSingleton(){
        // $person = $this->app->make(Person::class);
        // self::assertNotNull($person);
        $this->app->singleton(Person::class, function ($app) {
            return new Person('Ganda', 'Gunawan');
        });
        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);
        self::assertEquals('Ganda', $person1->firstName); // new Person('Ganda', 'Gunawan');
        self::assertEquals('Ganda', $person2->firstName); // retuns existing tidak membuat person baru
        self::assertSame($person1, $person2); 
    }
}
