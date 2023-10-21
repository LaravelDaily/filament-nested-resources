<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_user', function (Blueprint $table) {
            $table->foreignIdFor(Company::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_user');
    }
};
