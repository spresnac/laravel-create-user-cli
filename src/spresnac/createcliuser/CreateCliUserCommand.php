<?php

namespace spresnac\createcliuser;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateCliUserCommand extends Command
{
    public const E_OK = 0;
    public const E_USER_EXISTS = 1;
    public const E_UPDATING_FAILED = 2;
    public const E_CHAOS = 5;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create 
                                {name? : Inject the new users name} 
                                {email? : Inject the new users email} 
                                {password? : Inject the new users password} 
                                {--force : Do not ask questions, just do it ;)}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user from cli with artisan';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = config(
            'auth.providers.'
            .config(
                'auth.guards.'
                .config('auth.defaults.guard', 'web')
                .'.provider'
            )
            .'.model'
        );

        $user = new $class();

        $user->name = ($this->argument('name') === null)
            ? $this->ask('User name: ')
            : $this->argument('name');

        $user->email = ($this->argument('email') === null)
            ? $this->ask('User email: ')
            : $this->argument('email');

        $user->password = ($this->argument('password') === null)
            ? Hash::make($this->ask('User password: '))
            : Hash::make($this->argument('password'));

        if ($this->option('force') === true || $this->confirm('Save this user?', true)) {
            $exists = (new $class)->where([
                'name' => $user->name,
                'email' => $user->email,
            ])->first();
            if ($exists === null) { // user is not exisiting yet, just create him and return
                $user->save();
                $this->info('Created a user with id: '.$user->id);

                return self::E_OK;
            }
            // user is already existing, check the input and handle
            if ($this->option('force')) {
                if ($exists->update($user->getAttributes())) {
                    $this->info('Updated an existing user with id: '.$exists->id);

                    return self::E_OK;
                }
                $this->warn('Updating an existing user with id: '.$exists->id.' ended with errors');

                return self::E_UPDATING_FAILED;
            }
            $this->error('User already exist with id: '.$exists->id);

            return self::E_USER_EXISTS;
        }

        return self::E_CHAOS; // default end with an error to show, that this line was hit accidentially
    }
}
