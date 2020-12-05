<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class RegisterAdminCommand extends Command
{
    protected $signature = 'register:admin';

    protected $description = 'Register admin';

    public function handle(): int
    {
        $role = Role::where('name', Role::ROLE_ADMIN)->first();
        if (!$role) {
            $this->alert('Admin role does not exist! Please run php artisan db:seed --class=RoleSeeder');
            return 1;
        }
        $name = $this->ask('Please add name', 'admin');
        $this->validateName($name);
        $this->line("Name: {$name}");
        $email = $this->ask('Please add email', 'admin@gmail.com');
        $this->validateEmail($email);
        $this->line("Email: {$email}");
        $password = $this->secret('Please add password');
        $password_confirmation = $this->secret('Please confirm password');
        $this->validatePassword($password, $password_confirmation);
        $this->registerAdmin([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->info('Registration completed successfully');

        return 0;
    }

    private function registerAdmin(array $data): void
    {
        $user = User::firstOrCreate($data);
        $user->markEmailAsVerified();
        if (!$user->hasRole(Role::ROLE_ADMIN)) {
            $user->assignRole(Role::ROLE_ADMIN);
        }
    }

    private function validateName(string $name): void
    {
        $this->validate(
            [
                'name' => $name
            ],
            [
                'name' => ['required', 'string', 'min:2', 'max:30']
            ]
        );
    }

    private function validateEmail(string $email): void
    {
        $this->validate(
            [
                'email' => $email
            ],
            [
                'email' => ['required', 'string', 'email', 'unique:users']
            ]
        );
    }

    private function validatePassword(string $password, $password_confirmation): void
    {
        $this->validate(
            [
                'password' => $password,
                'password_confirmation' => $password_confirmation
            ],
            [
                'password' => ['required', 'confirmed', 'min:8', 'max:30']
            ]
        );
    }

    /**
     * @param array $data
     * @param array $rules
     */
    private function validate(array $data, array $rules): void
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $this->error($validator->messages());
        }
    }
}
