<?php
    

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    require_once __DIR__ . '/../../vendor/autoload.php';    

    $uuid = $_GET['uuid']; // Get the UUID from the query string

    // Prepare POST data to send to fetch_user.php
    $postData = http_build_query([
        'uuid' => $uuid
    ]);

    // Initialize cURL to send a POST request to fetch_user.php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, './fetch_user.php');  // Adjust to your actual PHP file path
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the response into an array
    $userData = json_decode($response, true);
    // Check if the user data was successfully retrieved
    if (!$userData || !$userData['success']) {
        die('Error fetching user data.');
    }

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers for the Excel file
    $sheet->setCellValue('A1', 'Field');
    $sheet->setCellValue('B1', 'Value');

    // Map the user data to the Excel format
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
    ];

    // Loop through the data and populate the Excel file
    $row = 2; // Starting row for data
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item[0]);
        $sheet->setCellValue('B' . $row, $item[1]);
        $row++;
    }

    // Write the Excel file to output
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="profile.xlsx"'); // Trigger file download with name "profile.xlsx"
    header('Cache-Control: max-age=0');

    // Save the Excel file to the output buffer
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>
