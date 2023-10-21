<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'text' => $this->faker->text(),

            'company_id' => Company::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
