<?php

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
        Schema::create('pets', function (Blueprint $table) {
            // name	VARCHAR(100)	ชื่อสัตว์เลี้ยง
            // species	VARCHAR(50)	สายพันธุ์ (เช่น สุนัข, แมว, ปลา)
            // breed	VARCHAR(50)	พันธุ์ (เช่น โกลเด้นรีทรีฟเวอร์, เปอร์เซีย)
            // age	INTEGER	อายุสัตว์เลี้ยง (เป็นเดือนหรือปี)
            // price	DECIMAL(10,2)	ราคาขาย
            // status	ENUM(‘available’, ‘sold’)	สถานะว่ายังขายอยู่หรือขายไปแล้ว
            // detail	VARCHAR(250)	รายละเอียด/หมายเหตุ
            // photo	VARCHAR(100)	Photo Path สำหรับเก็บรูปภาพ
            $table->id();

            $table->string('name', 100);
            $table->string('species', 50)->nullable();
            $table->string('breed', 50)->nullable();
            $table->integer('age')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('status', ['available', 'sold']);
            $table->string('detail', 250);
            $table->string('photo', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
