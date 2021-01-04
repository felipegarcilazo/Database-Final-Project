<!doctype html>
<html>
<body>
<h2>Section's Roster Query</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "</br>";}

$san_section = mysqli_real_escape_string($con, $_POST['form-section']);

$sql = "SELECT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) AS name, g.final_letter_grade, se.semester, se.class_time
FROM student AS st, section AS se, grade as g
WHERE g.studentID = st.studentID
AND se.sectionID = g.sectionID
AND se.sectionID = $san_section
ORDER BY st.l_name, st.f_name;";

$result = mysqli_query($con, $sql);
echo "<p>The following students are enrolled in section: $san_section.</p>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Full Name</th><th>Grade in Section</th><th>Semester</th><th>Start Time</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td>" . $row["name"] . "</td><td>" . $row["final_letter_grade"] . "</td><td>" . $row["semester"] . "</td><td>" . $row["class_time"] . "</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "There are no students in section $san_section.";
}

mysqli_close($con);
?>

</body>
</html>