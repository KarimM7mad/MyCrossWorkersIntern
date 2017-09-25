<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
//Admin Permissions    
        Permission::create(['name' => 'createEvent', 'guard_name' => 'web']);
        Permission::create(['name' => 'readEvent', 'guard_name' => 'web']);
        Permission::create(['name' => 'updateEvent', 'guard_name' => 'web']);
        Permission::create(['name' => 'deleteEvent', 'guard_name' => 'web']);        
        Permission::create(['name' => 'deleteStand', 'guard_name' => 'web']);
        Permission::create(['name' => 'createStand', 'guard_name' => 'web']);
//Comapnies Permissions
        Permission::create(['name' => 'reserveStand', 'guard_name' => 'web']);
        Permission::create(['name' => 'updateStand', 'guard_name' => 'web']);
        Permission::create(['name' => 'cancelReservation', 'guard_name' => 'web']);
//Admin Role
        $role = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $role->givePermissionTo('createEvent');
        $role->givePermissionTo('readEvent');
        $role->givePermissionTo('updateEvent');
        $role->givePermissionTo('deleteEvent');
        $role->givePermissionTo('deleteStand');
        $role->givePermissionTo('createStand');
//normal user Role
        $role2 = Role::create(['name' => 'normalUser', 'guard_name' => 'web']);
        $role2->givePermissionTo('reserveStand');
        $role2->givePermissionTo('updateStand');
        $role2->givePermissionTo('cancelReservation');
    }
}