<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HumanResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed Departments (idempotent)
        DB::table('departments')->upsert([
            [
                'name' => 'Human Resources',
                'description' => 'Handles recruitment, employee relations, and benefits.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'IT',
                'description' => 'Manages company technology and infrastructure.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Finance',
                'description' => 'Oversees budgeting, accounting, and financial planning.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ],
        // unique by 'name', update these columns when conflict occurs
        ['name'], ['description', 'status', 'updated_at', 'created_at']);

        // Seed Roles (idempotent)
        DB::table('roles')->upsert([
            [
                'name' => 'Manager',
                'description' => 'Oversees department operations and staff.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Developer',
                'description' => 'Builds and maintains software applications.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Accountant',
                'description' => 'Manages financial records and transactions.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ], ['name'], ['description', 'status', 'updated_at', 'created_at']);

        // Seed Employees and related records
        // fetch available department and role ids (after upsert)
        $departmentIds = DB::table('departments')->pluck('id')->toArray();
        $roleIds = DB::table('roles')->pluck('id')->toArray();

        for ($i = 0; $i < 5; $i++) {
            $employeeData = [
                'fullname' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
                'hire_date' => $faker->date('Y-m-d'),
                'department_id' => $faker->randomElement($departmentIds) ?? 1,
                'role_id' => $faker->randomElement($roleIds) ?? 1,
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 30000, 100000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ];

            $employeeId = DB::table('employees')->insertGetId($employeeData);

            DB::table('task')->insert([
                'title' => $faker->sentence(6, true),
                'description' => $faker->paragraph,
                'assigned_to' => $employeeId,
                'due_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // compute payroll numbers
            $salary = $faker->randomFloat(2, 30000, 100000);
            $bonuses = $faker->randomFloat(2, 1000, 5000);
            $deductions = $faker->randomFloat(2, 500, 2000);
            $netSalary = $salary + $bonuses - $deductions;

            DB::table('payrolls')->insert([
                'employee_id' => $employeeId,
                'salary' => $salary,
                'bonuses' => $bonuses,
                'deductions' => $deductions,
                'net_salary' => $netSalary,
                'pay_date' => Carbon::now()->format('Y-m-d'),
                'status' => 'paid',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('presences')->insert([
                'employee_id' => $employeeId,
                'check_in' => Carbon::now()->subHours(rand(1, 3))->format('H:i:s'),
                'check_out' => Carbon::now()->format('H:i:s'),
                'date' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('leave_requests')->insert([
                'leave_type' => $faker->randomElement(['vacation', 'sick', 'personal']),
                'employee_id' => $employeeId,
                'start_date' => Carbon::now()->addDays(rand(1, 10))->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(rand(11, 20))->format('Y-m-d'),
                'reason' => $faker->sentence,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }

}
