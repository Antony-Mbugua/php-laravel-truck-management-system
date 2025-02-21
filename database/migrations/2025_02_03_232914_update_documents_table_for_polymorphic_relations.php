<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Remove old trip relationship
            $table->dropForeign(['trip_id']);
            $table->dropColumn('trip_id');

            // Add polymorphic relationship columns
            $table->string('documentable_type');
            $table->unsignedBigInteger('documentable_id');
            
            // Add document type column
            $table->string('type')->comment('bol, pod, rate_confirmation, driver_license, etc');

            // Add indexes
            $table->index(['documentable_type', 'documentable_id']);
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Reverse the changes
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            
            // Remove polymorphic columns
            $table->dropColumn(['documentable_type', 'documentable_id', 'type']);
            
            // Drop indexes
            $table->dropIndex(['documentable_type_documentable_id_index']);
            $table->dropIndex(['type_index']);
        });
    }
};