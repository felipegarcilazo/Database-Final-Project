<!doctype html>
<html>
<body>
<h2>People in a Building at a Certain Time</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "Established Database Connection </br></br>";}

$san_building = mysqli_real_escape_string($con, $_POST['form-building']);
$san_time = mysqli_real_escape_string($con, $_POST['form-time']);

$sql = "(
  SELECT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) AS name, e.log_date, e.time_enter, e.time_leave
  FROM enter_leave_history AS e, student AS st, building AS b
  WHERE st.studentID = e.studentID AND b.buildingID = e.buildingID AND
  ('$san_time' BETWEEN e.time_enter AND e.time_leave) AND (b.name = '$san_building')
)
UNION
(
  SELECT CONCAT(f.f_name, ' ', f.m_name, ' ', f.l_name) AS name, e.log_date, e.time_enter, e.time_leave
  FROM enter_leave_history AS e, faculty AS f, building AS b
  WHERE f.facultyID = e.facultyID AND  b.buildingID = e.buildingID AND
  ('$san_time' BETWEEN e.time_enter AND e.time_leave) AND (b.name = '$san_building')
)
ORDER BY log_date DESC, time_enter DESC;";

$result = mysqli_query($con, $sql);
echo "<p>The following people were in $san_building at $san_time:</p>";


if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Person</th><th>Date</th><th>Time Entered</th><th>Time Left</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td> " . $row["name"] . "</td><td>". $row["log_date"] ."</td><td>". $row["time_enter"] ."</td><td>". $row["time_leave"] ."</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "No students or faculty were in $san_building at $san_time.";
}

mysqli_close($con);
?>

</body>
</html>