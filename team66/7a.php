<!doctype html>
<html>
<body>
<h2>Student Advisors</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "Established Database Connection </br></br>";}

$san_advisor = mysqli_real_escape_string($con, $_POST['form-advisor']);

$sql = "SELECT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) AS name, m.title, st.status, st.str_address
FROM student AS st, faculty_student AS sf, faculty AS f, major AS m, major_student AS ms
WHERE st.studentID = sf.studentID
AND f.facultyID = sf.facultyID
AND m.majorID = ms.majorID
AND st.studentID = ms.studentID
AND CONCAT(f.f_name, ' ', f.m_name, ' ',  f.l_name) = '$san_advisor'
AND f.occupation_title = 'Advisor'
ORDER BY name;";

$result = mysqli_query($con, $sql);
echo "<p>The following students are advised by $san_advisor";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Student Name</th><th>Major</th><th>Status</th><th>Student Address</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td> " . $row["name"] . "</td><td> " . $row["title"] . "</td><td> " . $row["status"] . "</td><td> " . $row["str_address"] . "</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "No students are assigned to $san_advisor.";
}

mysqli_close($con);
?>

</body>
</html>