<?php
    namespace App\Service;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    class PlanilhaService {
        public static function importar(string $caminho): array {
            $spreadsheet = IOFactory::load($caminho);
            return $spreadsheet->getActiveSheet()->toArray();
        }
        public static function exportar(array $dados, array $cabecalhos): void {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($cabecalhos, null, 'A1');
            $sheet->fromArray($dados, null, 'A2');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="clientes.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        }
    }