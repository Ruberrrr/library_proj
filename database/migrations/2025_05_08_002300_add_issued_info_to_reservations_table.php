<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('librarian_id')->nullable()->after('user_id');
            $table->timestamp('issued_at')->nullable()->after('expires_at');

            $table->foreign('librarian_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['librarian_id']);
            $table->dropColumn(['librarian_id', 'issued_at']);
        });
    }
};