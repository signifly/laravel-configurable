<?php

namespace Signifly\Configurable\Test;

use Illuminate\Support\Facades\Event;
use Signifly\Configurable\Test\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigurableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_saves_to_config()
    {
        $user = $this->createUser();

        $user->config()->some_key = 'some val';
        $user->config()->set('some_other_key', 'some other val');
        $user->save();

        tap($user->fresh(), function ($user) {
            $this->assertEquals($user->config()->some_key, 'some val');
            $this->assertEquals($user->config()->get('some_other_key'), 'some other val');
            $this->assertEquals($user->config()->all(), [
                'some_key' => 'some val',
                'some_other_key' => 'some other val',
            ]);
        });
    }

    /** @test */
    function it_retrieves_from_config()
    {
        $user = $this->createUser(['config' =>  [
            'some_key' => 'some val',
            'some_array' => [
                'nested' => 'nested value',
            ],
        ]]);

        $this->assertTrue($user->config()->has('some_key'));
        $this->assertTrue($user->config()->has('some_array.nested'));
        $this->assertEquals($user->config()->some_key, 'some val');
        $this->assertEquals($user->config()->get('some_array'), ['nested' => 'nested value']);
        $this->assertEquals($user->config()->get('some_array.nested'), 'nested value');
    }

    /** @test */
    function it_removes_from_config()
    {
        $user = $this->createUser(['config' =>  [
            'some_key' => 'some val',
            'some_array' => [
                'nested' => 'nested value',
            ],
        ]]);

        $user->config()->remove('some_key');
        $user->save();

        tap($user->fresh(), function ($user) {
            $this->assertFalse($user->config()->has('some_key'));
            $this->assertTrue($user->config()->has('some_array'));
        });
    }

    /** @test */
    function it_modifies_config_without_saving()
    {
        $user = $this->createUser();

        $user->config()->some_key = 'some val';

        $this->assertEquals($user->config()->some_key, 'some val');
        $this->assertFalse($user->fresh()->config()->has('some_key'));
    }

    /** @test */
    function it_can_count_attributes_in_config()
    {
        $user = $this->createUser(['config' =>  [
            'some_key' => 'some val',
            'some_array' => [
                'nested' => 'nested value',
            ],
        ]]);

        $this->assertEquals($user->config()->count(), 2);
    }

    /** @test */
    function it_can_retrieve_all_attributes_from_config()
    {
        $user = $this->createUser(['config' =>  [
            'some_key' => 'some val',
            'some_array' => [
                'nested' => 'nested value',
            ],
        ]]);

        $this->assertEquals($user->config()->all(), [
            'some_key' => 'some val',
            'some_array' => [
                'nested' => 'nested value',
            ],
        ]);
    }

    protected function createUser(array $overwrites = [])
    {
        return User::create(array_merge([
            'name' => 'John Doe',
            'email' => 'jd@example.org',
            'config' => null,
        ], $overwrites));
    }
}
