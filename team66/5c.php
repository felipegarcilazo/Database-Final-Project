<!doctype html>
<html>
<body>
<h2>Student Transcript</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "Established Database Connection </br></br>";}

$san_student = mysqli_real_escape_string($con, $_POST['form-student']);

$sql = "SELECT c.title, g.final_letter_grade, SUM(c.num_credits) AS credits,  SUM(gpa(g.final_letter_grade)*c.num_credits)/sum(c.num_credits) AS GPA
FROM course AS c, grade AS g, section AS se, student AS st
WHERE c.courseID = se.courseID
AND se.sectionID = g.sectionID
AND st.studentID = g.studentID
AND CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) = '$san_student'
AND g.final_letter_grade != 'F'
GROUP BY c.title WITH ROLLUP;";

$result = mysqli_query($con, $sql);
echo "<p>Transcript of $san_student:</p>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Course</th><th>Grade</th><th>Credits Earned</th><th>GPA</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		if ($row["title"] == "")
		{echo "<tr><td>Total/Cumulative</td><td></td><td>" . $row["credits"] . "</td><td>" . $row["GPA"] . "</td></tr>";}
		else
		{echo "<tr><td>" . $row["title"] . "</td><td>". $row["final_letter_grade"] ."</td><td>" . $row["credits"] . "</td><td>" . $row["GPA"] . "</td></tr>";}
	}
	echo "</tbody></table>";
} else {
    echo "$san_student has not taken any courses.";
}

mysqli_close($con);
?>

</body>
</html>