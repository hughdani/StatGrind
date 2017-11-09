CREATE TABLE users(
   user_id INT NOT NULL AUTO_INCREMENT,
   username VARCHAR(512) NOT NULL,
   password VARCHAR(512) NOT NULL,
   account_type INT NOT NULL,
   PRIMARY KEY ( user_id, username )
   );
   
CREATE TABLE courses(
   course_id INT NOT NULL AUTO_INCREMENT,
   course_name VARCHAR(512) NOT NULL,
   course_desc VARCHAR(5096) NOT NULL,
   PRIMARY KEY ( course_id )
   );
  
CREATE TABLE taking_course(
   map_id INT NOT NULL AUTO_INCREMENT,
   course_id INT NOT NULL,
   user_id INT NOT NULL,
   PRIMARY KEY ( map_id ),
   FOREIGN KEY(course_id) REFERENCES courses(course_id),
   FOREIGN KEY(user_id) REFERENCES users(user_id)
   );
   
CREATE TABLE teaching_course(
   map_id INT NOT NULL AUTO_INCREMENT,
   course_id INT NOT NULL,
   user_id INT NOT NULL,
   PRIMARY KEY ( map_id ),
   FOREIGN KEY(course_id) REFERENCES courses(course_id),
   FOREIGN KEY(user_id) REFERENCES users(user_id)
   );
