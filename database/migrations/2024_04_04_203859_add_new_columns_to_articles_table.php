<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Core\Utils\Traits\Database\Migrations\CanDeleteTrait;
use Core\Utils\Traits\Database\Migrations\HasCompositeKey;
use Core\Utils\Traits\Database\Migrations\HasForeignKey;
use Core\Utils\Traits\Database\Migrations\HasTimestampsAndSoftDeletes;
use Core\Utils\Traits\Database\Migrations\HasUuidPrimaryKey;

class AddNewColumnsToArticlesTable extends Migration
{
    use CanDeleteTrait, HasCompositeKey, HasForeignKey, HasTimestampsAndSoftDeletes, HasUuidPrimaryKey;
    /**
     * Run the migrations.
     * 
     * @return void
     * 
     * @throws \Core\Utils\Exceptions\DatabaseMigrationException If the migration fails.
     */
    public function up(): void
    {
        // Begin the database transaction
        DB::beginTransaction();

        try {

            if (Schema::hasTable('articles')) {
                Schema::table('articles', function (Blueprint $table) {

                    if (!Schema::hasColumn('articles', 'price')) {
                        // Add a boolean column 'price' to the table
                        $table->decimal('price', 10, 2)->comment('The price of the articles');
                    }
                    if (!Schema::hasColumn('articles', 'stock')) {
                        // Add a boolean column 'stock' to the table
                        $table->decimal('stock', 10, 2)->comment('The stock of the articles');
                    }
                    if (!Schema::hasColumn('articles', 'description')) {
                        // Add a boolean column 'description' to the table
                        $table->string('description')->comment('The description of the articles');
                    }


                    if (!Schema::hasColumn('articles', 'magasin_id')) {
                        // Define a foreign key for 'magasin_id', referencing the 'magasins' table
                        $this->foreignKey(
                            table: $table,                // The table where the foreign key is being added
                            column: 'magasin_id',        // The column to which the foreign key is added ('category_id' in this case)
                            references: 'magasins',    // The referenced table (magasins) to establish the foreign key relationship
                            onDelete: 'cascade',         // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: true              // Specify whether the foreign key column can be nullable (false means it is not allows to be NULL)
                        );
                    }

                    if (!Schema::hasColumn('articles', 'categorie_article_id')) {
                        // Define a foreign key for 'categorie_article_id', referencing the 'categorie_articles' table
                        $this->foreignKey(
                            table: $table,                // The table where the foreign key is being added
                            column: 'categorie_article_id',        // The column to which the foreign key is added ('category_id' in this case)
                            references: 'categorie_articles',    // The referenced table (categorie_articles) to establish the foreign key relationship
                            onDelete: 'cascade',         // Action to perform when the referenced record is deleted (cascade deletion)
                            nullable: false              // Specify whether the foreign key column can be nullable (false means it is not allows to be NULL)
                        );
                    }
                });
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to migrate "articles" table: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     * @throws \Core\Utils\Exceptions\DatabaseMigrationException If the migration fails.
     */
    public function down(): void
    {
        // Begin the database transaction
        DB::beginTransaction();

        try {
            if (Schema::hasTable('articles')) {
                Schema::table('articles', function (Blueprint $table) {

                    if (Schema::hasColumn('articles', 'price')) {
                        // Drop the 'price' column if it exists
                        $table->dropColumn('price');
                    }

                    if (Schema::hasColumn('articles', 'description')) {
                        // Drop the 'description' column if it exists
                        $table->dropColumn('description');
                    }

                    if (Schema::hasColumn('articles', 'magasin_id')) {
                        // Drop foreign key constraint for 'magasin_id'
                        $table->dropForeign(['magasin_id']);
                        // Drop the 'magasin_id' column if it exists
                        $table->dropColumn('magasin_id');
                    }

                    if (Schema::hasColumn('articles', 'categorie_article_id')) {
                        // Drop foreign key constraint for 'categorie_article_id'
                        $table->dropForeign(['categorie_article_id']);
                        // Drop the 'categorie_article_id' column if it exists
                        $table->dropColumn('categorie_article_id');
                    }
                });
            }

            // Commit the transaction
            DB::commit();
        } catch (\Throwable $exception) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (e.g., logging, notification, etc.)
            throw new \Core\Utils\Exceptions\DatabaseMigrationException(
                message: 'Failed to drop "price" column: ' . $exception->getMessage(),
                previous: $exception
            );
        }
    }
}
