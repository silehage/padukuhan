<?php

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
        });

        $items = ['Super Admin', 'Ketua' ,'Sekretaris', 'Bendahara', 'Anggota'];

        foreach($items as $item) {
            Role::create([
                'name' => $item,
                'slug' => Str::slug($item)
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
