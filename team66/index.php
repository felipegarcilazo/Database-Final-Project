<!doctype html>
<html>
<body>
<h3 style="text-align:center;">Created By Team 66: Felipe Garcilazo, Mitchell Gottlieb, William Stowell, Mike Floreak </h3>
<h2>1a. Section's Roster Query</h2>
<p>Functioning Example: 1033</p>
<form action="1a.php" method="POST">
	Section Number: <select name="form-section">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct CONCAT(s.sectionID, ' ', c.title) AS name, s.sectionID AS section
    FROM section AS s, course AS c 
    WHERE c.courseID = s.courseID
    ORDER BY c.title, s.sectionID;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($name, $id);
                  $name = $row['name'];
                  $id = $row['section'];
                  echo "<option value='" . $id . "'>" . $name . '</option>';
}
mysqli_close($conn);
?> 
</select>
	</br></br>
	<input type="submit" value="View">	
</form>

<h2>2a. Classroom with Features</h2>
<p>Functioning Example: projector</p>
<form action="2a.php" method="POST">
	Classroom Feature: <select name="form-feature">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct feature_name FROM room_features ORDER BY feature_name;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($feature);
                  $feature = $row['feature_name'];
                  echo '<option value="'.$feature.'">'.$feature.'</option>';
}
mysqli_close($conn);
?> 
</select>
	</br></br>
	<input type="submit" value="Select Classrooms">	
</form>

<h2>3a. Courses Faculty Have Taught</h2>
<form action="3a.php" method="POST">
 	<input type="submit" value="Select Faculty">	
</form>
<h2>4a. Students Who are Eligible for Courses</h2>
<p>Functioning Example: Programming 2</p>
<form action="4a.php" method="POST">
	Course: <select name="form-course">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct title FROM course WHERE prereqID IS NOT NULL ORDER BY title;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($course);
                  $course = $row['title'];
                  echo '<option value="'.$course.'">'.$course.'</option>';
}
mysqli_close($conn);
?> 
</select>
	</br></br>
	<input type="submit" value="Select Students">	
</form>
<h2>5c. Student Transcript</h2>
<p>Functioning Example: Nessy Dari Fredi</p>
<form action="5c.php" method="POST">
	Student: <select name="form-student">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct CONCAT(f_name, ' ', m_name, ' ', l_name) AS name FROM student ORDER BY name;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($student);
                  $student = $row['name'];
                  echo '<option value="'.$student.'">'.$student.'</option>';
}
mysqli_close($conn);
?> 
</select>
	</br></br>
	<input type="submit" value="Select Transcript">	
</form>
<h2>6b. People in a Building at a Certain Time</h2>
<p>Functioning Example: Hodge Hall at 09:00:00</p>
<form action="6b.php" method="POST">
	Building: <select name="form-building">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct name FROM building order by name;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($building);
                  $building = $row['name'];
                  echo '<option value="'.$building.'">'.$building.'</option>';
}
mysqli_close($conn);
?> 
</select>
</br></br>
	Time: <select name="form-time">
<?php
for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
    for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
        echo "<option value='" . str_pad($hours,2,'0',STR_PAD_LEFT) . ':' 
        . str_pad($mins,2,'0',STR_PAD_LEFT) . ":00'>" . str_pad($hours,2,'0',STR_PAD_LEFT) . ':' 
        . str_pad($mins,2,'0',STR_PAD_LEFT) .':00</option>';
?> 
</select>
	</br></br>
	<input type="submit" value="Select People">	
</form>
<h2>7a. Student Advisors</h2>
<p>Functioning Example: North West Chong</p>
<form action="7a.php" method="POST">
	Advisors: <select name="form-advisor">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct CONCAT(f_name, ' ', m_name, ' ',  l_name) AS name FROM faculty WHERE occupation_title = 'Advisor' ORDER BY name;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($advisor);
                  $advisor = $row['name'];
                  echo '<option value="'.$advisor.'">'.$advisor.'</option>';
}
mysqli_close($conn);
?> 
</select>
	</br></br>
	<input type="submit" value="Select Students">	
</form>
<h2>8b. Students Who Have not Attended Past Two Semesters</h2>
<form action="8b.php" method="POST">
	<input type="submit" value="Select Students">	
</form>
<h2>9a. Majors Offered By Deparments</h2>
<form action="9a.php" method="POST">
	<input type="submit" value="Select Majors">	
</form>
<h2>Additional 1. Faculty in a Building at a Certain Time</h2>
<p>Functioning Example: Hodge Hall at 09:00:00</p>
<form action="additional.php" method="POST">
	Building: <select name="form-building">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct name FROM building order by name;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($building);
                  $building = $row['name'];
                  echo '<option value="'.$building.'">'.$building.'</option>';
}
mysqli_close($conn);
?> 
</select>
</br></br>
	Time: <select name="form-time">
<?php
for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
    for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
        echo "<option value='" . str_pad($hours,2,'0',STR_PAD_LEFT) . ':' 
        . str_pad($mins,2,'0',STR_PAD_LEFT) . ":00'>" . str_pad($hours,2,'0',STR_PAD_LEFT) . ':' 
        . str_pad($mins,2,'0',STR_PAD_LEFT) .':00</option>';
?> 
</select>
	</br></br>
	<input type="submit" value="Select People">	
</form>
<h2>Additional 2. Student courses that are 3 or more credit hours</h2>
<p>Functioning Example: Nessy Dari Fredi</p>
<form action="additional1.php" method="POST">
	Student: <select name="form-student">
<?php
$conn = mysqli_connect("db.sice.indiana.edu","i308f19_team66","my+sql=i308f19_team66","i308f19_team66");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "<br>");
}
    $result = mysqli_query($conn,"SELECT distinct CONCAT(f_name, ' ', m_name, ' ', l_name) AS name FROM student ORDER BY name;");
    while ($row = mysqli_fetch_assoc($result)) {
                  unset($student);
                  $student = $row['name'];
                  echo '<option value="'.$student.'">'.$student.'</option>';
}
mysqli_close($conn);
?> 
</select>
	</br></br>
	<input type="submit" value="Select Transcript">	
</form>
</body>
</html>
