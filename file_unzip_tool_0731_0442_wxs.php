<?php
// 代码生成时间: 2025-07-31 04:42:34
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Exception;

class FileUnzipTool
{
    /**
     * Path to the file that needs to be compressed or decompressed.
     *
     * @var string
     */
    protected $filePath;

    /**
     * Constructor to initialize the file path.
     *
     * @param string $filePath Path to the file.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Unzips the file specified in the file path.
     *
     * @return bool
     * @throws Exception If unable to unzip the file.
     */
    public function unzip()
    {
        try {
            $zip = new ZipArchive;
            if ($zip->open($this->filePath) === true) {
                $zip->extractTo(Storage::disk('local')->path('extracted'));
                $zip->close();
                return true;
            } else {
                throw new Exception('Unable to open zip file.');
            }
        } catch (Exception $e) {
            // Log the exception and rethrow it.
            Log::error('Unzip error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Zips the directory specified and saves the zip file in the specified file path.
     *
     * @param string $directoryPath Path to the directory to be zipped.
     * @return bool
     * @throws Exception If unable to zip the directory.
     */
    public function zip($directoryPath)
    {
        try {
            $zip = new ZipArchive;
            if ($zip->open($this->filePath, ZipArchive::CREATE) === true) {
                $zip->addGlob($directoryPath . '/*');
                $zip->close();
                return true;
            } else {
                throw new Exception('Unable to create zip file.');
            }
        } catch (Exception $e) {
            // Log the exception and rethrow it.
            Log::error('Zip error: ' . $e->getMessage());
            throw $e;
        }
    }
}
