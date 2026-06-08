<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Policies\CoursePolicy;
use App\Policies\LessonPolicy;
use App\Policies\AssignmentPolicy;
use App\Policies\EnrollmentPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);
        Gate::policy(Assignment::class, AssignmentPolicy::class);
        Gate::policy(Enrollment::class, EnrollmentPolicy::class);
    }
}