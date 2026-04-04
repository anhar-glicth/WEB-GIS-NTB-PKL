<?php
$mysqli = new mysqli("localhost", "root", "", "gis");
$res = $mysqli->query("DESCRIBE laporan");
echo "<pre>";
while($row = $res->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";
$mysqli->close();
