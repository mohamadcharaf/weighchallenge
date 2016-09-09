<?php

require_once( 'dbconfig.php' );
$db = new Database();
$conn = $db->dbConnection();  // This will die if it fails.

echo '<br>Connected successfully';

/*

-- This is a reference table
CREATE TABLE calendar_table (
 dt DATE NOT NULL PRIMARY KEY
) ENGINE=InnoDB;

CREATE PROCEDURE insert_dates()
BEGIN
  DECLARE endDate DATE;
  DECLARE iterDate DATE;
  SET endDate = '2116-12-31';
  SET iterDate = '2016-01-01';

label1: LOOP
   INSERT INTO calendar_table( dt ) VALUES( iterDate );
   SET iterDate = DATE_ADD( iterDate, INTERVAL 1 DAY );
   IF iterDate <= endDate THEN
     ITERATE label1;
   END IF;
   LEAVE label1;
  END LOOP label1;
END;

CALL insert_dates();

DROP PROCEDURE insert_dates;


DROP TABLE users;
CREATE TABLE IF NOT EXISTS users(
   user_id INT(11) NOT NULL AUTO_INCREMENT
  ,user_name VARCHAR(15) NOT NULL
  ,user_email VARCHAR(40) NOT NULL
  ,user_pass VARCHAR(255) NOT NULL
  ,join_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
  ,CONSTRAINT PRIMARY KEY ( user_id )
) ENGINE=InnoDB;
--) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
INSERT INTO users(user_id, user_name, user_email, user_pass, join_date) VALUES( 1, 'kyle', 'kyle.brazell@ymail.com', '$2y$10$BbEIYQUUFMD7GwCQYWWqsuagDJjjDxdlirOnVTwMIugNrNXEM4o9i', '2016-08-31 11:53:26');
INSERT INTO users(user_id, user_name, user_email, user_pass, join_date) VALUES( 2, 'bogus1', 'bogus1@bogus.org', '$2y$10$1PNKvjHzM2ol5u9b.tbmI.J3.WRaDbz3v/bxR1urQFl4/WYrLj0la', '2016-08-31 12:00:00');
INSERT INTO users(user_id, user_name, user_email, user_pass, join_date) VALUES( 3, 'bogus2', 'bogus2@bogus.org', '$2y$10$zpc19DIPR1vcpjM44bf7UOSWHGHW5TL7JD09JPTMC0bzjBzBMI79q', '2016-08-31 13:00:00');

DROP TABLE challenge_participant; -- Drop this one first because of foreign key issues
DROP TABLE challenges;
CREATE TABLE challenges
(
  challenge_id INT(10) NOT NULL AUTO_INCREMENT
, fk_created_by INT NOT NULL
, challenge_name VARCHAR(255) NOT NULL
, start_date DATETIME NOT NULL COMMENT 'date on which the challenge begins'
, end_date DATETIME NOT NULL COMMENT 'date on which the challenge ends'
, challenge_type INT(10) NOT NULL DEFAULT 1 COMMENT '1 = Weight loss, 2 = weight gain'
, CONSTRAINT PRIMARY KEY ( challenge_id )
) ENGINE=InnoDB;
INSERT INTO challenges(challenge_id, fk_created_by, challenge_name, start_date, end_date, challenge_type) VALUES( 1, 1, 'First challenge', '2016-01-01 12:00:00', '2016-01-31 12:00:00', 1);
INSERT INTO challenges(challenge_id, fk_created_by, challenge_name, start_date, end_date, challenge_type) VALUES( 2, 1, 'Second challenge', '2016-02-01 12:00:00', '2016-02-27 12:00:00', 1);
INSERT INTO challenges(challenge_id, fk_created_by, challenge_name, start_date, end_date, challenge_type) VALUES( 3, 1, 'third challenge', '2016-03-01 12:00:00', '2016-03-31 12:00:00', 1);



CREATE TABLE challenge_participant
(
  fk_challenge_id INT(10) NOT NULL
 ,fk_user_id INT(10) NOT NULL
 ,start_date DATETIME NOT NULL COMMENT 'copy this data value when challenge is joined'
 ,end_date DATETIME NOT NULL COMMENT 'copy this data value when challenge is joined'
 ,challenge_type INT(10) NOT NULL DEFAULT 1 COMMENT 'copy this data value when challenge is joined'
 ,start_weight INT(10) NULL
 ,goal_weight INT(10) NOT NULL
 ,rank INT(10) NULL
 ,team_size INT(10) NOT NULL  COMMENT 'update this every time a team member joins'
,CONSTRAINT FOREIGN KEY (fk_challenge_id) REFERENCES challenges(challenge_id)
,CONSTRAINT FOREIGN KEY (fk_user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 1, 1, '2016-01-01 12:00:00', '2016-01-31 12:00:00', 260, 250, 1, 5 );
INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 1, 2, '2016-01-01 12:00:00', '2016-01-31 12:00:00', 260, 250, 1, 5 );
INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 1, 3, '2016-01-01 12:00:00', '2016-01-31 12:00:00', 260, 250, 1, 5 );

INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 2, 1, '2016-02-01 12:00:00', '2016-02-27 12:00:00', 260, 250, 1, 5 );
INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 2, 2, '2016-02-01 12:00:00', '2016-02-27 12:00:00', 260, 250, 1, 5 );
INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 2, 3, '2016-02-01 12:00:00', '2016-02-27 12:00:00', 260, 250, 1, 5 );

INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 3, 1, '2016-03-01 12:00:00', '2016-03-31 12:00:00', 260, 250, 1, 5 );
INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 3, 2, '2016-03-01 12:00:00', '2016-03-31 12:00:00', 260, 250, 1, 5 );
INSERT INTO challenge_participant(fk_challenge_id, fk_user_id, start_date, end_date, start_weight, goal_weight, rank, team_size) VALUES( 3, 3, '2016-03-01 12:00:00', '2016-03-31 12:00:00', 260, 250, 1, 5 );

DROP TABLE user_weigh_in;

CREATE TABLE user_weigh_in
(
  fk_user_id INT(10) NOT NULL
 ,weigh_date DATETIME NOT NULL
 ,weight INT(10) NULL
,CONSTRAINT FOREIGN KEY (fk_user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-01 08:50:00', 250 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-02 09:00:00', 249 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-03 08:40:00', 248 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-04 09:01:00', 247 );

-- Jan 5 will show as MISSING! (to be repaired by user viewing of data) (add a NULL for this date)
--INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-05 08:30:00', 246 );

INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-06 14:32:00', 246 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-07 08:50:00', 247 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-08 09:20:00', 247 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-09 08:30:00', 245 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-10 09:05:00', 246 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-11 08:40:00', 248 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-12 09:00:00', 246 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-13 08:00:00', 245 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-14 09:00:00', 244 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-15 09:00:00', 243 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-16 09:00:00', 243 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-17 08:00:00', 244 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-18 08:00:00', 243 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-19 09:00:00', 242 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-20 08:00:00', 242 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-21 09:00:00', 241 );
-- Jan 22, 23, & 24 will show as MISSING! (to be repaired by user viewing of data) (add a NULL for this date)
--INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-22 08:00:00', 243 );
--INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-23 09:00:00', 244 );
--INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-24 08:00:00', 243 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-25 09:00:00', 242 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-26 09:00:00', 242 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-27 08:00:00', 243 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-28 08:00:00', 242 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-29 08:00:00', 241 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-30 09:00:00', 241 );
INSERT INTO user_weigh_in( fk_user_id, weigh_date, weight ) VALUES( 1, '2016-01-31 09:00:00', 241 );


*/

echo '<br>Describe table';
echo '<br>';
$sql = 'DESCRIBE users';
$stmt = $conn->prepare( $sql );
$stmt->execute();

$result = $stmt->fetch( PDO::FETCH_ASSOC );
print_r( $result );

?>