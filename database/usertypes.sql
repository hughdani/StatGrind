CREATE TABLE account_types(
   account_type INT(13) NOT NULL,
   type_description VARCHAR(25) NOT NULL,
   create_assignment_perm BOOLEAN,
   view_assignment_perm BOOLEAN,
   create_course_perm BOOLEAN,
   grade_assignment_perm BOOLEAN,
   PRIMARY KEY ( account_type )
   );
 
INSERT INTO account_types (account_type, type_description, create_assignment_perm, view_assignment_perm, create_course_perm, grade_assignment_perm)
VALUES(1, "Instructor", TRUE, TRUE, TRUE, TRUE);
INSERT INTO account_types (account_type, type_description, create_assignment_perm, view_assignment_perm, create_course_perm, grade_assignment_perm)
VALUES(2, "Student", FALSE, TRUE, FALSE, FALSE);
INSERT INTO account_types (account_type, type_description, create_assignment_perm, view_assignment_perm, create_course_perm, grade_assignment_perm)
VALUES(3, "TA", TRUE, TRUE, FALSE, TRUE);
