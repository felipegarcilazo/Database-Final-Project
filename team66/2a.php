<!doctype html>
<html>
<body>
<h2>Classroom with Features</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "</br>";}

$san_feature = mysqli_real_escape_string($con, $_POST['form-feature']);

$sql = "SELECT b.name, r.room_num, b.str_address
FROM room AS r, building AS b, room_features AS rf
WHERE r.buildingID = b.buildingID
AND rf.roomID = r.roomID
AND rf.feature_name = '$san_feature';";

$result = mysqli_query($con, $sql);
echo "<p>The following rooms have $san_feature in the room.</p>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Building</th><th>Room Number</th><th>Address</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td>" . $row["name"] . "</td><td>". $row["room_num"] ."</td><td>". $row["str_address"] ."</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "There are no rooms equipped with the $san_feature feature.";
}

mysqli_close($con);
?>

</body>
</html>