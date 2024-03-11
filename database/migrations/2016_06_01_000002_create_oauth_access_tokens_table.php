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
        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->uuid('client_id');
            $table->string('name')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->timestamps();
            $table->dateTime('expires_at')->nullable();
            
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
        Schema::dropIfExists('oauth_access_tokens');
    }
};
