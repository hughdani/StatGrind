RENAME TABLE questions TO questions_tmp;

CREATE TABLE questions(
   question_id INT NOT NULL AUTO_INCREMENT,
   location VARCHAR(512) NOT NULL,
   PRIMARY KEY ( question_id )
   );

INSERT INTO questions (location)  
SELECT DISTINCT location from questions_tmp;

CREATE TABLE in_assignment(
   map_id INT NOT NULL AUTO_INCREMENT,
   assignment_id INT NOT NULL,
   question_id INT NOT NULL,
   PRIMARY KEY ( map_id ),
   FOREIGN KEY(assignment_id) REFERENCES assignments(assignment_id),
   FOREIGN KEY(question_id) REFERENCES questions(question_id)
   );
-- NOTE: Had to add a new id column as PK, due to the possibility of 
-- multiple instances of the same question being in the same assignment
   
INSERT INTO in_assignment (assignment_id, question_id)
SELECT `questions_tmp`.`assignment_id`, `questions`.`question_id` FROM
    questions LEFT JOIN questions_tmp on questions.location = questions_tmp.location
    ORDER by assignment_id;

DROP TABLE questions_tmp;

