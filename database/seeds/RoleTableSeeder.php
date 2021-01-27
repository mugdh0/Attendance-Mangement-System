<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            [
                'name'=>"Super Admin",
                'display_name'=>"Super Admin",
                'description'=>"super admin role"
            ],
            [
                'name'=>"Admin",
                'display_name'=>"Admin",
                'description'=>"admin role"
            ],
            [
                'name'=>"Editor",
                'display_name'=>"Editor",
                'description'=>"editor role"
            ]
        ];
        foreach ($roles as $key=>$value)
            Role::create($value);
    }
}
