<!doctype html>
<html>
<body>
<h2>Courses Faculty have Taught</h2>

<?php
$con = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");

// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>"; }
else 
{ echo "</br>";}

$sql = "SELECT CONCAT(f.f_name, ' ', f.m_name, ' ', f.l_name) AS name, f.occupation_title, c.title, COUNT(c.title)
FROM faculty AS f, course AS c, section AS s, grade AS g
WHERE f.facultyID = g.facultyID
AND s.sectionID=g.sectionID
AND s.courseID = c.courseID
GROUP BY name, c.title
ORDER BY name, c.title;";

$result = mysqli_query($con, $sql);

echo "<p>The following are the faculty and the number of times they have taught.</p>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Faculty Name</th><th>Occupation</th><th>Course Name</th><th>Number of Times Taught This Course</</tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td>" . $row["name"] . "</td><td>". $row["occupation_title"] ."</td><td>" . $row["title"] . "</td><td>" . $row["COUNT(c.title)"] . "</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "Faculty have never taught a course.";
}

mysqli_close($con);
?>

</body>
</html>