<?php

use App\Models\Pengurus;
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
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan');
            $table->unsignedTinyInteger('sort')->default(1);
        });

        $items = [
            'Ketua', 
            'Sekretaris', 
            'Bendahara', 
            'Seksi Humas', 
            'Seksi Pembangunan', 
            'Seksi Pemuda & Olahraga',
            'Seksi Kebudayaan & Kerohanian',
            'Seksi Keamanan & Ketertiban',
            'Seksi Kebersihan & Fasum',
            'Seksi Sosial PKK & Kewanitaan',
            'Anggota'
        ];

        $sort = 1;

        foreach($items as $item) {
            Pengurus::create([
                'jabatan' => $item,
                'sort' => $sort
            ]);

            $sort ++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
};
