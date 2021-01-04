<!doctype html>
<html>
<body>
<h2>Students Who are Eligible for Courses</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "</br>";}

$san_course = mysqli_real_escape_string($con, $_POST['form-course']);

$sql = "SELECT DISTINCT CONCAT(st.f_name, ' ', st.m_name, ' ',  st.l_name) AS name, c.title, g.final_letter_grade
FROM course AS c, section AS se, student AS st, grade AS g
WHERE st.studentID=g.studentID
AND se.sectionID=g.sectionID
AND c.courseID=se.courseID
AND CONCAT(st.f_name, ' ', st.m_name, ' ',  st.l_name) NOT IN (
  SELECT DISTINCT CONCAT(st.f_name, ' ', st.m_name, ' ',  st.l_name)
  FROM course AS c, section AS se, student AS st, grade AS g
  WHERE st.studentID=g.studentID
  AND se.sectionID=g.sectionID
  AND c.courseID=se.courseID
  AND c.title = '$san_course'
)
AND c.courseID IN (
  SELECT c.prereqID
  FROM course AS c, section AS se, student AS st, grade AS g
  WHERE st.studentID=g.studentID
  AND se.sectionID=g.sectionID
  AND c.courseID=se.courseID
  AND c.title='$san_course'
)
ORDER BY name;";
  
$result = mysqli_query($con, $sql);
echo "<p>The following students have the prerequisite course complete for $san_course:</p>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Student Name</th><th>Course Name</th><th>Grade in the Prerequisite Course</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td>" . $row["name"] . "</td><td>". $row["title"] ."</td><td>". $row["final_letter_grade"] ."</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "There are no students eligible to register for $san_course.";
}

mysqli_close($con);
?>

</body>
</html>