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
        Schema::create('oauth_personal_access_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('client_id');
            $table->timestamps();
            
            // Add a boolean column 'status' to the table
            $table->boolean('status')
                ->default(TRUE) // Set the default value to TRUE
                ->comment('Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore'
                ); // Describe the meaning of the 'status' column

            // Add a soft delete column to the table to handle soft deletes
            $table->softDeletes()
                ->comment('Soft delete column for marking records as deleted without permanent removal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oauth_personal_access_clients');
    }
};
