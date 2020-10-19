<?php

namespace spresnac\tests\createcliuser;

use Orchestra\Testbench\TestCase;
use spresnac\createcliuser\CreateCliUserCommandServiceProvider;

/**
 * Class CreateCliUserCommandTest.
 * @covers \spresnac\createcliuser\CreateCliUserCommand
 * @covers \spresnac\createcliuser\CreateCliUserCommandServiceProvider
 */
class CreateCliUserCommandTest extends TestCase
{
    public function testCanCreateUserWithNoArguments(): void
    {
        $expectedUserName = 'User Name';
        $expectedUserEmail = 'user@email.com';
        $expectedPassword = 'bad_password';

        $this->artisan('user:create')
            ->expectsQuestion('User name: ', $expectedUserName)
            ->expectsQuestion('User email: ', $expectedUserEmail)
            ->expectsQuestion('User password: ', $expectedPassword)
            ->expectsQuestion('Save this user?', 'yes')
            ->expectsOutput('Created a user with id: 1')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => $expectedUserEmail,
            'name' => 'User Name',
        ]);
    }

    public function testCanCreateUserWithAllArguments(): void
    {
        $expectedUserName = 'User Name';
        $expectedUserEmail = 'user@email.com';
        $expectedPassword = 'bad_password';

        $this->artisan(
            sprintf(
                'user:create --force "%s" %s %s',
                $expectedUserName,
                $expectedUserEmail,
                $expectedPassword
            )
        )
            ->expectsOutput('Created a user with id: 1')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => $expectedUserEmail,
            'name' => 'User Name',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            CreateCliUserCommandServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.guards.web.provider', 'users');
        $app['config']->set('auth.providers.users.model', User::class);
    }
}
