<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add arquivo column to calendarios
        Schema::table('calendarios', function (Blueprint $table) {
            $table->string('arquivo')->nullable();
        });

        // 2. Create conselho_user pivot table
        Schema::create('conselho_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('conselho_id')->constrained('conselhos')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Migrate data from users.id_conselho to conselho_user
        $users = DB::table('users')->whereNotNull('id_conselho')->get();
        foreach ($users as $user) {
            DB::table('conselho_user')->insert([
                'user_id' => $user->id,
                'conselho_id' => $user->id_conselho,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Remove id_conselho from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_conselho');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('id_conselho')->nullable()->constrained('conselhos');
        });

        // Migrate data back (approximate)
        $pivots = DB::table('conselho_user')->get();
        foreach ($pivots as $pivot) {
            DB::table('users')->where('id', $pivot->user_id)->update(['id_conselho' => $pivot->conselho_id]);
        }

        Schema::dropIfExists('conselho_user');

        Schema::table('calendarios', function (Blueprint $table) {
            $table->dropColumn('arquivo');
        });
    }
};
