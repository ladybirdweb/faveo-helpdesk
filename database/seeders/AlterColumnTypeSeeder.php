<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AlterColumnTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->modifyStringType(Schema::getAllTables());
    }

    private function modifyStringType($tables)
    {
        foreach ($tables as $table) {
            $tableName = (array)$table;
            $tableName = reset($tableName);

            $columns = Schema::getColumnListing($tableName);

            foreach ($columns as $column) {
                if (Schema::getColumnType($tableName, $column) == 'string') {
                    Schema::table($tableName, function ($table) use($column) {
                        $table->string($column)->nullable()->change();
                    });
                } elseif (Schema::getColumnType($tableName, $column) == 'boolean') {
                    Schema::table($tableName, function ($table) use($column) {
                        $table->boolean($column)->default(0)->change();
                    });
                }
            }
        }
    }
}
