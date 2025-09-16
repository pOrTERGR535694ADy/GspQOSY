<?php
// 代码生成时间: 2025-09-16 15:08:44
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Excel表格自动生成器
 *
 * 这个类提供了一个简单的接口来生成Excel文档。
 *
 * @author Your Name
 * @version 1.0
 */
class ExcelGenerator {

    /**
     * 创建一个新的Excel文档实例。
     *
     * @return Spreadsheet
     */
    private function createSpreadsheet(): Spreadsheet {
        return new Spreadsheet();
    }

    /**
     * 添加一个工作表到Excel文档。
     *
     * @param Spreadsheet $spreadsheet
     * @param string $sheetName
     * @return Spreadsheet
     */
    public function addSheet(Spreadsheet $spreadsheet, string $sheetName): Spreadsheet {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle($sheetName);
        return $spreadsheet;
    }

    /**
     * 向工作表添加数据。
     *
     * @param Spreadsheet $spreadsheet
     * @param array $data
     * @param string $sheetName
     * @return Spreadsheet
     */
    public function addDataToSheet(Spreadsheet $spreadsheet, array $data, string $sheetName): Spreadsheet {
        $sheet = $spreadsheet->getSheetByName($sheetName);
        $rowIndex = 1;
        foreach ($data as $row) {
            foreach ($row as $col => $value) {
                $sheet->setCellValueByColumnAndRow($col + 1, $rowIndex, $value);
            }
            $rowIndex++;
        }
        return $spreadsheet;
    }

    /**
     * 保存Excel文档到指定路径。
     *
     * @param Spreadsheet $spreadsheet
     * @param string $filePath
     * @return bool
     */
    public function saveSpreadsheet(Spreadsheet $spreadsheet, string $filePath): bool {
        $writer = new Xlsx($spreadsheet);
        try {
            $writer->save($filePath);
            return true;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * 生成Excel文档并保存到指定路径。
     *
     * @param array $data
     * @param string $sheetName
     * @param string $filePath
     * @return bool
     */
    public function generateExcel(array $data, string $sheetName, string $filePath): bool {
        $spreadsheet = $this->createSpreadsheet();
        $spreadsheet = $this->addSheet($spreadsheet, $sheetName);
        $spreadsheet = $this->addDataToSheet($spreadsheet, $data, $sheetName);
        return $this->saveSpreadsheet($spreadsheet, $filePath);
    }
}

// 使用示例
$excelGenerator = new ExcelGenerator();
$data = [
    ["Name", "Age"],
    ["John", 30],
    ["Jane", 25]
];
$sheetName = "User Data";
$filePath = "./output.xlsx";
$excelGenerator->generateExcel($data, $sheetName, $filePath);
