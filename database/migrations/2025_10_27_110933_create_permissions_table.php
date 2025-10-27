<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('ability');
            $table->string('module');
        });

        $cruds = ['Create', 'Read', 'Update', 'Delete'];

        foreach(Permission::MODULES as $module) {
            foreach($cruds as $crud) {
                Permission::create([
                    'ability' => $crud,
                    'module' => $module
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
