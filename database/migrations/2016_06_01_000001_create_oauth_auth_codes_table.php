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
        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->uuid('user_id')->index();
            $table->uuid('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
            
            // Add a boolean column 'status' to the table
            $table->boolean('status')
                ->default(TRUE) // Set the default value to TRUE
                ->comment('Record status: 
                    - TRUE: Active record or soft delete record
                    - FALSE: permanently Deleted and can be archived in another datastore'
                ); // Describe the meaning of the 'status' column

            // Add a timestamp column for the record creation, set to the current timestamp by default
            $table->timestamp('created_at')->useCurrent()
                ->comment('Timestamp indicating when the record was created');

            // Add a timestamp column for the last update of the record, set to the current timestamp on each update
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()
                ->comment('Timestamp indicating the last update of the record');

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
        Schema::dropIfExists('oauth_auth_codes');
    }
};
