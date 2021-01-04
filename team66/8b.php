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
{ echo "Established Database Connection </br></br>";}

$sql = "
SELECT DISTINCT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) AS name, m.title, st.status, st.str_address, stpp.parent_phone
FROM student AS st, student_parent_phone AS stpp, grade AS g, section AS s, major AS m, major_student AS ms
WHERE stpp.studentID = st.studentID AND s.sectionID = g.sectionID
AND g.studentID = st.studentID
AND m.majorID = ms.majorID
AND st.studentID = ms.studentID
AND CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) NOT IN (
  SELECT DISTINCT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name)
  FROM student AS st, student_parent_phone AS stpp, grade AS g, section AS s
  WHERE stpp.studentID = st.studentID AND s.sectionID = g.sectionID
  AND g.studentID = st.studentID
  AND (s.semester = 'Spring 2020' OR s.semester = 'Fall 2019')
);";

$result = mysqli_query($con, $sql);
echo "<p>The following are students who have not signed up for classes in the past two semesters.";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'><tbody><tr><th>Student Name</th><th>Major</th><th>Status</th><th>Address</th><th>Parents Phone Number</th></tr>";
	while($row = mysqli_fetch_assoc($result)) {
		echo "<tr><td> " . $row["name"] . "</td><td>" . $row["title"] . "</td><td>" . $row["status"] . "</td><td>" . $row["str_address"] . "</td><td>" . $row["parent_phone"] . "</td></tr>";
	}
	echo "</tbody></table>";
} else {
    echo "There are no students who have not attended the past two semesters.";
}

mysqli_close($con);
?>

</body>
</html>