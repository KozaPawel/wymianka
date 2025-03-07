<?php

use App\Models\Category;
use App\Models\Town;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')
                ->constrained('users');
            $table->foreignIdFor(Category::class, 'category_id')
                ->constrained('categories');
            $table->foreignIdFor(Town::class, 'town_id')
                ->constrained('towns');
            $table->string('name');
            $table->text('description');
            $table->boolean('is_hidden')
                ->default(false);
            $table->boolean('hidden_by_admin')
                ->default(false);
            $table->timestamp('traded_at')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
