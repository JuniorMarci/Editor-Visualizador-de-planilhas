<?php
if (isset($_POST['file']) && file_exists($_POST['file'])) {
    $file = $_POST['file'];
    $delimiter = $_POST['delimiter'];
    $encoding = $_POST['encoding'];

    // Define headers for CSV download
    header('Content-Type: text/csv; charset=' . $encoding);
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');

    // Output CSV content
    $handle = fopen($file, 'r');
    while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
        echo implode(',', $row) . "\r\n";
    }
    fclose($handle);
    exit;
} else {
    echo "File not found.";
}
?>
