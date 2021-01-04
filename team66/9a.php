<!doctype html>
<html>
<body>
<h2>Students Who Have not Attended Past Two Semesters</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "</br>";}

$sql = "SELECT m.title AS m_name, d.title AS d_name, CONCAT(f.f_name, ' ', f.m_name, ' ', f.l_name) AS name, m.credits_req, mcr.course_name, mcr.min_grade
FROM major AS m, major_course_requirements AS mcr, department AS d, faculty AS f
WHERE m.majorID = mcr.majorID
AND d.departmentID = m.departmentID
AND d.facultyID = f.facultyID
ORDER BY d_name, m_name;";

$result = mysqli_query($con, $sql);
echo "<p>The following are majors offered by various departments:</p>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Major</th><th>Department</th><th>Chairperson of Department</th><th>Credits Required</th><th>Required Courses</th><th>Minimum Grade Needed</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td> " . $row["m_name"] . "</td><td>". $row["d_name"] ."</td><td>". $row["name"] ."</td><td>". $row["credits_req"] ."</td><td>". $row["course_name"] ."</td><td>". $row["min_grade"] ."</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "There are no majors.";
}

mysqli_close($con);
?>

</body>
</html>