<?php
if (isset($_GET['file'])) {
    $directory = 'uploads/';
    $fileName = $_GET['file'];
    $filePath = $directory . $fileName;

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "Le fichier demandé n'existe pas.";
    }
} else {
    echo "Paramètre 'file' manquant dans l'URL.";
}
?>