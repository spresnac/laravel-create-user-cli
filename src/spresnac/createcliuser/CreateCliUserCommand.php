<?php

namespace spresnac\createcliuser;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateCliUserCommand extends Command
{
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
            $user->save();
            $this->info('Created a user with id: '.$user->id);
        }

        return 0;
    }
}
