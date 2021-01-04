/* 1a. Produce a roster for a *specified section* sorted by student’s last name,
first name(5 points)*/

SELECT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) AS name, g.final_letter_grade, se.semester, se.class_time
FROM student AS st, section AS se, grade as g
WHERE g.studentID = st.studentID
AND se.sectionID = g.sectionID
AND se.sectionID = $san_section
ORDER BY st.l_name, st.f_name;

/* 2a. Produce a list of rooms that are equipped with *some feature*—e.g.,
“wiredinstructorstation”.(5 points)*/

SELECT b.name, r.room_num, b.str_address
FROM room AS r, building AS b, room_features AS rf
WHERE r.buildingID = b.buildingID
AND rf.roomID = r.roomID
AND rf.feature_name = '$san_feature';

/* 3a. Produce a list of all faculty and all the courses they have ever taught.
Show how many times they have taught each course.(5 points)*/

SELECT CONCAT(f.f_name, ' ', f.m_name, ' ', f.l_name) AS name, f.occupation_title, c.title, COUNT(c.title)
FROM faculty AS f, course AS c, section AS s, grade AS g
WHERE f.facultyID = g.facultyID
AND s.sectionID=g.sectionID
AND s.courseID = c.courseID
GROUP BY name, c.title
ORDER BY name, c.title;

/* 4a. Produce a list of students who are eligible to register for a
*specified course*that has a prerequisite.(5 points)*/

SELECT DISTINCT CONCAT(st.f_name, ' ', st.m_name, ' ',  st.l_name) AS name, c.title, g.final_letter_grade
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
ORDER BY name;

/* 5c. Produce a chronological list of all courses taken by a
*specified student*. Show grades earned. Include overall hours earned and GPA
at the end. (Hint: An F does not earn hours.)(15 points)*/

DROP FUNCTION IF EXISTS gpa;
DELIMITER //
CREATE FUNCTION gpa(letter_grade VARCHAR(5))
RETURNS DECIMAL(4, 2)
BEGIN
  DECLARE gpa_score DECIMAL(4,2);

  IF (letter_grade = 'A+' OR letter_grade = 'A') THEN
    SET gpa_score = 4.00;
  ELSEIF letter_grade = 'A-' THEN
    SET gpa_score = 3.70;
  ELSEIF letter_grade = 'B+' THEN
    SET gpa_score = 3.30;
  ELSEIF letter_grade = 'B' THEN
    SET gpa_score = 3.00;
  ELSEIF letter_grade = 'B-' THEN
    SET gpa_score = 2.70;
  ELSEIF letter_grade = 'C+' THEN
    SET gpa_score = 2.30;
  ELSEIF letter_grade = 'C' THEN
    SET gpa_score = 2.00;
  ELSEIF letter_grade = 'C-' THEN
    SET gpa_score = 1.70;
  ELSEIF letter_grade = 'D+' THEN
    SET gpa_score = 1.30;
  ELSEIF letter_grade = 'D' THEN
    SET gpa_score = 1.00;
  ELSEIF letter_grade = 'D-' THEN
    SET gpa_score = 0.70;
  ELSEIF letter_grade = 'F' THEN
    SET gpa_score = 0.00;
  ELSE
    SET gpa_score = 0.00;
  END IF;

  RETURN gpa_score;
END //
DELIMITER ;


SELECT c.title, g.final_letter_grade, SUM(c.num_credits) AS credits,  SUM(gpa(g.final_letter_grade)*c.num_credits)/sum(c.num_credits) AS GPA
FROM course AS c, grade AS g, section AS se, student AS st
WHERE c.courseID = se.courseID
AND se.sectionID = g.sectionID
AND st.studentID = g.studentID
AND CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) = '$san_student'
AND g.final_letter_grade != 'F'
GROUP BY c.title WITH ROLLUP;


/* 6b. Produce a list of students and faculty who were in a *particular
building* at a *particular time*.(10 points)*/

(
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
ORDER BY log_date DESC, time_enter DESC;


/*7aProduce an alphabetical list of students with their majors who are advised
by a *specified advisor*.(5 points)*/

SELECT CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) AS name, m.title, st.status, st.str_address
FROM student AS st, faculty_student AS sf, faculty AS f, major AS m, major_student AS ms
WHERE st.studentID = sf.studentID
AND f.facultyID = sf.facultyID
AND m.majorID = ms.majorID
AND st.studentID = ms.studentID
AND CONCAT(f.f_name, ' ', f.m_name, ' ',  f.l_name) = '$san_advisor'
AND f.occupation_title = 'Advisor'
ORDER BY name;

/* 8b. Produce an alphabetical list of students who have not attended during the
two most recent semesters along with their parents’ phonenumber.(10 points)
1025-1047*/

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
);


/* 9a. Produce a list of majors offered, along with the department that offers
them and their requirements to graduate (hours earned and overall GPA).
(5 points)*/

SELECT m.title AS m_name, d.title AS d_name, CONCAT(f.f_name, ' ', f.m_name, ' ', f.l_name) AS name, m.credits_req, mcr.course_name, mcr.min_grade
FROM major AS m, major_course_requirements AS mcr, department AS d, faculty AS f
WHERE m.majorID = mcr.majorID
AND d.departmentID = m.departmentID
AND d.facultyID = f.facultyID
ORDER BY d_name, m_name;

/* TWO Additional Queries */

/* Faculty in a Building at a Certain Time */

SELECT CONCAT(f.f_name, ' ', f.m_name, ' ', f.l_name) AS name, e.log_date, e.time_enter, e.time_leave
FROM enter_leave_history AS e, faculty AS f, building AS b
WHERE f.facultyID = e.facultyID AND  b.buildingID = e.buildingID AND
('$san_time' BETWEEN e.time_enter AND e.time_leave) AND (b.name = '$san_building')
ORDER BY e.log_date DESC, e.time_enter DESC;

/* Student courses that are 3 or more credit hours */

SELECT c.title, g.final_letter_grade
FROM course AS c, grade AS g, section AS se, student AS st
WHERE c.courseID = se.courseID
AND se.sectionID = g.sectionID
AND st.studentID = g.studentID
AND CONCAT(st.f_name, ' ', st.m_name, ' ', st.l_name) = '$san_student'
AND c.num_credits >= 3
ORDER BY c.title;
