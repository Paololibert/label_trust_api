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
        Schema::create('oauth_clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->string('name');
            $table->string('secret', 100)->nullable();
            $table->string('provider')->nullable();
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
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
        // Drop foreign key constraints
        Schema::dropIfExists('oauth_clients');
    }
};
