<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\Lesson;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExerciseImportService
{
    /**
     * Get sample exercise template rows.
     *
     * @return array<int, array<int, string>>
     */
    public function getSampleRows(): array
    {
        return [
            [
                'multiple_choice',
                'Tipe data manakah di Python yang digunakan untuk menyimpan nilai True atau False?',
                '',
                'bool (Boolean)|int (Integer)|str (String)|float (Desimal)',
                'bool (Boolean)',
                'Tipe data boolean hanya memiliki dua nilai: True atau False.',
            ],
            [
                'fill_blank',
                'Lengkapi kode Python berikut agar menampilkan teks "Halo Dunia" ke layar:',
                '____("Halo Dunia")',
                'print|echo|input|write',
                'print',
                'Fungsi bawaan Python untuk mencetak teks adalah print().',
            ],
            [
                'output_prediction',
                'Apa output yang dihasilkan dari kode Python berikut?',
                "nama = 'Andi'\nprint('Halo ' + nama)",
                'Halo Andi|Halo nama|Andi|Error',
                'Halo Andi',
                "Operator + menggabungkan string 'Halo ' dengan nilai variabel nama.",
            ],
            [
                'code_ordering',
                'Susun baris kode berikut dengan urutan yang benar untuk membuat variabel lalu mencetaknya:',
                '',
                "umur = 15|print('Umur saya:')|print(umur)",
                '1|2|3',
                'Variabel harus dideklarasikan terlebih dahulu sebelum nilainya dicetak.',
            ],
            [
                'matching_pair',
                'Cocokkan tipe data Python dengan contoh nilainya yang tepat:',
                '',
                'int => 17|str => "Belajar"|bool => True|float => 3.14',
                'int => 17|str => "Belajar"|bool => True|float => 3.14',
                'int adalah bilangan bulat, str adalah teks, bool adalah nilai kebenaran, dan float adalah bilangan desimal.',
            ],
        ];
    }

    /**
     * Generate native Microsoft Excel (.xlsx) template with formatted header styling.
     */
    public function generateTemplateXlsx(): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Soal EduSkill');

        $headers = ['question_type', 'prompt', 'code_snippet', 'options', 'answer', 'explanation'];
        $sheet->fromArray([$headers], null, 'A1');

        $rows = $this->getSampleRows();
        $sheet->fromArray($rows, null, 'A2');

        // Style header row (Royal Blue Background with White Bold Text)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Auto-fit column widths
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');

        return (string) ob_get_clean();
    }

    /**
     * Generate sample CSV template content with UTF-8 BOM.
     */
    public function generateTemplateCsv(): string
    {
        $headers = ['question_type', 'prompt', 'code_snippet', 'options', 'answer', 'explanation'];
        $rows = $this->getSampleRows();

        $output = "\xEF\xBB\xBF"; // UTF-8 BOM for Excel
        $f = fopen('php://memory', 'r+');
        fputcsv($f, $headers);

        foreach ($rows as $row) {
            fputcsv($f, $row);
        }

        rewind($f);
        $output .= stream_get_contents($f);
        fclose($f);

        return $output;
    }

    /**
     * Import exercises from uploaded XLSX, XLS, or CSV file into a Lesson.
     *
     * @return array{success: int, errors: array<string>}
     */
    public function importFromFile(UploadedFile $file, Lesson $lesson): array
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $mime = strtolower($file->getMimeType() ?? '');
        $realPath = $file->getRealPath();

        $rows = [];

        // Check if XLSX or XLS file
        if ($ext === 'xlsx' || $ext === 'xls' || str_contains($mime, 'spreadsheet') || str_contains($mime, 'excel')) {
            try {
                $spreadsheet = IOFactory::load($realPath);
                $sheet = $spreadsheet->getActiveSheet();
                $rawRows = $sheet->toArray(null, true, true, false);

                foreach ($rawRows as $row) {
                    if (! empty(array_filter($row, fn ($v) => trim((string) $v) !== ''))) {
                        $rows[] = array_map(fn ($v) => trim((string) ($v ?? '')), $row);
                    }
                }
            } catch (\Throwable $e) {
                // If PhpSpreadsheet fails, attempt fallback to CSV reader
                $rows = $this->parseCsvRows($realPath);
            }
        } else {
            $rows = $this->parseCsvRows($realPath);
        }

        if (count($rows) < 2) {
            return ['success' => 0, 'errors' => ['File harus memiliki baris header dan minimal 1 baris soal.']];
        }

        return $this->processExtractedRows($rows, $lesson);
    }

    /**
     * Fallback alias for backward compatibility.
     *
     * @return array{success: int, errors: array<string>}
     */
    public function importFromCsv(UploadedFile $file, Lesson $lesson): array
    {
        return $this->importFromFile($file, $lesson);
    }

    /**
     * Parse rows from raw CSV/text content.
     *
     * @return array<int, array<int, string>>
     */
    protected function parseCsvRows(string $filePath): array
    {
        $content = file_get_contents($filePath);
        if (! $content) {
            return [];
        }

        // Remove potential UTF-8 BOM
        if (str_starts_with($content, "\xEF\xBB\xBF")) {
            $content = substr($content, 3);
        }

        $lines = preg_split('/\r\n|\r|\n/', trim($content));
        if (empty($lines)) {
            return [];
        }

        $firstLine = $lines[0];
        $delimiter = str_contains($firstLine, ';') && substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

        $rows = [];
        $temp = fopen('php://memory', 'r+');
        fwrite($temp, $content);
        rewind($temp);

        while (($data = fgetcsv($temp, 0, $delimiter)) !== false) {
            if (! empty(array_filter($data, fn ($v) => trim((string) $v) !== ''))) {
                $rows[] = array_map(fn ($v) => trim((string) ($v ?? '')), $data);
            }
        }
        fclose($temp);

        return $rows;
    }

    /**
     * Process extracted row array into Exercise model records.
     *
     * @param  array<int, array<int, string>>  $rows
     * @return array{success: int, errors: array<string>}
     */
    protected function processExtractedRows(array $rows, Lesson $lesson): array
    {
        // Header check & mapping
        $header = array_map(fn ($h) => strtolower(trim((string) $h)), $rows[0]);
        $typeIdx = array_search('question_type', $header);
        $promptIdx = array_search('prompt', $header);
        $codeIdx = array_search('code_snippet', $header);
        $optsIdx = array_search('options', $header);
        $ansIdx = array_search('answer', $header);
        $expIdx = array_search('explanation', $header);

        if ($typeIdx === false || $promptIdx === false) {
            $typeIdx = 0;
            $promptIdx = 1;
            $codeIdx = 2;
            $optsIdx = 3;
            $ansIdx = 4;
            $expIdx = 5;
        }

        $successCount = 0;
        $errors = [];
        $maxOrder = $lesson->exercises()->max('order_index') ?? 0;

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $rowNum = $i + 1;

            $rawType = trim($row[$typeIdx] ?? '');
            $prompt = trim($row[$promptIdx] ?? '');
            $codeSnippet = trim($row[$codeIdx] ?? '');
            $rawOptions = trim($row[$optsIdx] ?? '');
            $rawAnswer = trim($row[$ansIdx] ?? '');
            $explanation = trim($row[$expIdx] ?? '');

            if (empty($prompt)) {
                continue;
            }

            $questionType = $this->normalizeQuestionType($rawType);
            if (! $questionType) {
                $errors[] = "Baris #{$rowNum}: Tipe soal '{$rawType}' tidak dikenali.";

                continue;
            }

            [$optionsJson, $answerJson] = $this->parseOptionsAndAnswer($questionType, $rawOptions, $rawAnswer);

            $maxOrder++;
            Exercise::create([
                'lesson_id' => $lesson->id,
                'question_type' => $questionType,
                'prompt' => $prompt,
                'code_snippet' => $codeSnippet ?: null,
                'options_json' => $optionsJson,
                'answer_json' => $answerJson,
                'explanation' => $explanation,
                'order_index' => $maxOrder,
            ]);

            $successCount++;
        }

        return [
            'success' => $successCount,
            'errors' => $errors,
        ];
    }

    /**
     * Normalize string to standard Exercise question types.
     */
    public function normalizeQuestionType(string $raw): ?string
    {
        $slug = strtolower(trim(str_replace([' ', '-'], '_', $raw)));

        return match ($slug) {
            'multiple_choice', 'pilihan_ganda', 'pilgan', 'mc' => 'multiple_choice',
            'fill_blank', 'isian_kosong', 'isian', 'fill_in_the_blank' => 'fill_blank',
            'output_prediction', 'tebak_output', 'output', 'predict_output' => 'output_prediction',
            'code_ordering', 'susun_kode', 'parsons', 'parsons_problem', 'ordering' => 'code_ordering',
            'matching_pair', 'cocokkan_pasangan', 'pasangan', 'matching', 'match' => 'matching_pair',
            default => null,
        };
    }

    /**
     * Parse options & answers according to question type structure.
     *
     * @return array{0: mixed, 1: mixed}
     */
    public function parseOptionsAndAnswer(string $type, string $rawOptions, string $rawAnswer): array
    {
        // Split options by pipe '|' or newline
        $optItems = array_values(array_filter(array_map('trim', preg_split('/[|\n]+/', $rawOptions)), fn ($v) => $v !== ''));

        if ($type === 'multiple_choice' || $type === 'fill_blank' || $type === 'output_prediction') {
            $optionsJson = ! empty($optItems) ? $optItems : ['Option A', 'Option B', 'Option C', 'Option D'];
            $answerJson = trim($rawAnswer) ?: ($optionsJson[0] ?? '');

            return [$optionsJson, $answerJson];
        }

        if ($type === 'code_ordering') {
            $optionsJson = [];
            foreach ($optItems as $i => $text) {
                $optionsJson[] = [
                    'id' => (string) ($i + 1),
                    'text' => $text,
                ];
            }

            // Answer is expected as list of ids, e.g. "1|2|3" or "1,2,3"
            $ansItems = array_values(array_filter(array_map('trim', preg_split('/[|,\n]+/', $rawAnswer)), fn ($v) => $v !== ''));
            if (empty($ansItems)) {
                $ansItems = array_map(fn ($item) => $item['id'], $optionsJson);
            }

            return [$optionsJson, $ansItems];
        }

        if ($type === 'matching_pair') {
            $pairs = [];
            foreach ($optItems as $item) {
                if (str_contains($item, '=>')) {
                    [$k, $v] = explode('=>', $item, 2);
                    $pairs[trim($k)] = trim($v);
                } elseif (str_contains($item, ':')) {
                    [$k, $v] = explode(':', $item, 2);
                    $pairs[trim($k)] = trim($v);
                }
            }

            if (empty($pairs)) {
                $pairs = ['A' => '1', 'B' => '2'];
            }

            return [['pairs' => $pairs], $pairs];
        }

        return [$optItems, trim($rawAnswer)];
    }
}
