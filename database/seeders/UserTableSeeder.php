<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $default_user_value = [
            'password'          => password_hash('password', PASSWORD_DEFAULT),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
        ];

        $userAdministrator = User::create(array_merge([
            'name'  => 'Administrator',
            'email' => 'administrator@gmail.com',
        ], $default_user_value));

        $userTeacher = User::create(array_merge([
            'name'  => 'Teacher',
            'email' => 'teacher@gmail.com',
        ], $default_user_value));

        // All Roles
        $administrator = Role::create(['name' => User::ADMINISTRATOR_ROLE]);
        $teacher = Role::create(['name' => User::TEACHER_ROLE]);
        $student = Role::create(['name' => User::STUDENT_ROLE]);

        // Teacher Permission
        $permission = Permission::create(['name' => 'read teacher']);
        $permission = Permission::create(['name' => 'create teacher']);
        $permission = Permission::create(['name' => 'update teacher']);
        $permission = Permission::create(['name' => 'delete teacher']);

        // Student Permission
        $permission = Permission::create(['name' => 'read student']);
        $permission = Permission::create(['name' => 'create student']);
        $permission = Permission::create(['name' => 'update student']);
        $permission = Permission::create(['name' => 'delete student']);

        $administrator->givePermissionTo('read teacher');
        $administrator->givePermissionTo('create teacher');
        $administrator->givePermissionTo('update teacher');
        $administrator->givePermissionTo('delete teacher');

        $administrator->givePermissionTo('read student');
        $administrator->givePermissionTo('create student');
        $administrator->givePermissionTo('update student');
        $administrator->givePermissionTo('delete student');

        $teacher->givePermissionTo('read student');
        $teacher->givePermissionTo('create student');
        $teacher->givePermissionTo('update student');
        $teacher->givePermissionTo('delete student');

        $userAdministrator->assignRole(User::ADMINISTRATOR_ROLE);
        $userTeacher->assignRole(User::TEACHER_ROLE);
    }
}
