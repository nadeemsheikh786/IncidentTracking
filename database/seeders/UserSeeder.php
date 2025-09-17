<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
			['email' => 'admin@example.com'],
			['name' => 'Admin', 'password' => 'AdminPass@123', 'role' => 'admin']
		);

		foreach (range(1,4) as $i) {
			User::updateOrCreate(
				['email' => "responder{$i}@example.com"],
				['name' => "Responder {$i}", 'password' => 'ResponderPass@123', 'role' => 'responder']
			);
		}

		User::updateOrCreate(
			['email' => 'user@example.com'],
			['name' => 'Regular User', 'password' => 'UserPass@123', 'role' => 'user']
		);
    }
}
