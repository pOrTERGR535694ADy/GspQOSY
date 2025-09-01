<?php
// 代码生成时间: 2025-09-01 23:01:57
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CsvBatchProcessor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 确保数据库表存在
        Schema::create('csv_batches', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_batches');
    }

    /**
     * Process a CSV file and insert data into the database.
     *
     * @param string $filePath
     * @return void
     */
    public function processCsvFile($filePath)
    {
        try {
            // Read the CSV file
            $csv = Storage::get($filePath);

            // Convert CSV content to array
            $rows = array_map('str_getcsv', explode("\
", $csv));
            array_walk($rows, function (&$row) {
                $row = array_combine($rows[0], $row);
            });
            array_shift($rows); // Remove column header row

            // Insert data into database
            foreach ($rows as $row) {
                DB::table('csv_batches')->insert($row);
            }

            echo "CSV file processed successfully.\
";
        } catch (Exception $e) {
            // Error handling
            echo "Error processing CSV file: " . $e->getMessage() . "\
";
        }
    }
}
