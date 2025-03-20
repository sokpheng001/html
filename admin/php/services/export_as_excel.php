<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../utils/database_connect.php';  // Connect to DB
    
    // Query the database to get all students
    $stmt = $database_connection->prepare("SELECT uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, 
                                                    place_of_birth, original_email, school_email, phone_number, 
                                                    major, expired_date, gender, profile FROM students WHERE is_deleted = 0");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("Error: No students found");
    }
    
    // Create Excel file
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set column headers
    $sheet->setCellValue('A1', 'UUID');
    $sheet->setCellValue('B1', 'ឈ្មោះខ្មែរ');
    $sheet->setCellValue('C1', 'ឈ្មោះឡាតាំង');
    $sheet->setCellValue('D1', 'ឈ្មោះឪពុក');
    $sheet->setCellValue('E1', 'ឈ្មោះម្តាយ');
    $sheet->setCellValue('F1', 'ថ្ងៃខែឆ្នាំកំណើត');
    $sheet->setCellValue('G1', 'ទីកន្លែងកំណើត');
    $sheet->setCellValue('H1', 'អ៊ីមែលដើម');
    $sheet->setCellValue('I1', 'អ៊ីមែលសាលា');
    $sheet->setCellValue('J1', 'លេខទូរស័ព្ទ');
    $sheet->setCellValue('K1', 'ជំនាញ');
    $sheet->setCellValue('L1', 'គណនីផុតកំណត់');
    $sheet->setCellValue('M1', 'ភេទ');
    $sheet->setCellValue('N1', 'រូបថត');
    
    // Populate data for each student in a new row
    $row = 2;
    while ($student = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $student['uuid']);
        $sheet->setCellValue('B' . $row, $student['khmer_name']);
        $sheet->setCellValue('C' . $row, $student['latin_name']);
        $sheet->setCellValue('D' . $row, $student['father_name']);
        $sheet->setCellValue('E' . $row, $student['mother_name']);
        $sheet->setCellValue('F' . $row, $student['date_of_birth']);
        $sheet->setCellValue('G' . $row, $student['place_of_birth']);
        $sheet->setCellValue('H' . $row, $student['original_email'] ?? 'Not provided');
        $sheet->setCellValue('I' . $row, $student['school_email'] ?? 'Not provided');
        $sheet->setCellValue('J' . $row, $student['phone_number'] ?? 'Not provided');
        $sheet->setCellValue('K' . $row, $student['major'] ?? 'Not provided');
        $sheet->setCellValue('L' . $row, $student['expired_date'] ?? 'Not provided');
        $sheet->setCellValue('M' . $row, $student['gender'] ?? 'Not provided');
        $sheet->setCellValue('N' . $row, $student['profile'] ?? 'Not provided');
        $row++;
    }
    
    $stmt->close();
    $database_connection->close();
    
    // Output the Excel file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="students-data.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>
