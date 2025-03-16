<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__. '/../utils/database_connect.php';  // Connect to DB
    
    // Check if UUID is set
    if (!isset($_GET['uuid']) || empty($_GET['uuid'])) {
        die("Error: UUID is required");
    }
    $uuid = trim($_GET['uuid']);
    
    // Query the database directly
    $stmt = $database_connection->prepare("SELECT uuid, khmer_name, latin_name, father_name, mother_name, date_of_birth, 
                                                    place_of_birth, gender, original_email, school_email, phone_number, 
                                                    profile, major, expired_date, profile FROM students WHERE uuid = ? AND is_deleted=0");
    $stmt->bind_param("s", $uuid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows !== 1) {
        die("Error: User not found");
    }
    $userData = $result->fetch_assoc();
    $stmt->close();
    $database_connection->close();
    
    // Create Excel file
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Field');
    $sheet->setCellValue('B1', 'Value');
    
    // Map user data
    $data = [
        ['ឈ្មោះខ្មែរ', $userData['khmer_name']],
        ['ឈ្មោះឡាតាំង', $userData['latin_name']],
        ['ឈ្មោះឪពុក', $userData['father_name']],
        ['ឈ្មោះម្តាយ', $userData['mother_name']],
        ['ថ្ងៃខែឆ្នាំកំណើត', $userData['date_of_birth']],
        ['ទីកន្លែងកំណើត', $userData['place_of_birth']],
        ['អ៊ីមែល', $userData['school_email'] ?? 'Not provided'],
        ['លេខទូរស័ព្ទ', $userData['phone_number']],
        ['មុខវិជ្ជា', $userData['major']],
        ['ភេទ', $userData['gender']],
        ['គណនីផុតកំណត់', $userData['expired_date'] ?? 'Not provided'],
        ['រូបថត', $userData['profile'] ?? 'Not provided'],
    ];
    
    // Populate Excel file
    $row = 2;
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item[0]);
        $sheet->setCellValue('B' . $row, $item[1]);
        $row++;
    }
    
    // Output file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename='.$userData['latin_name'].'-profile.xlsx');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

?>
