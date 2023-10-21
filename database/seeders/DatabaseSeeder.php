<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $company = Company::factory()->create();

        $user = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@admin.com',
        ]);

        $user->companies()->attach($company->id);


        $company2 = Company::factory()->create();
        $user->companies()->attach($company2->id);

        $companies = [
            $company,
            $company2
        ];

        foreach ($companies as $company) {
            Course::factory()
                ->count(10)
                ->has(Lesson::factory()->count(20)->for($company))
                ->create([
                    'company_id' => $company->id,
                ]);
        }
    }
}
