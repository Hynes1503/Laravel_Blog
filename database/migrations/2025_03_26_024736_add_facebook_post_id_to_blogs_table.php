<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('facebook_post_id')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('facebook_post_id');
        });
    }
};
