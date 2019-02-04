<?php
$conn = new mysqli("localhost", "root", "", "manhistDb");
$sql = "select * from posts";
$result = mysqli_query($conn, $sql);
$json_arrry = array();
    $fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/json');
    header('Content-Disposition: attachment; filename="export.json"');
    header('Pragma: no-cache');
    header('Expires: 0');
    while ($r = mysqli_fetch_assoc($result)) {
        $json_arrry[] = $r;
    }
    echo json_encode($json_arrry);
    die;
}
?>

