CREATE PROCEDURE users_plus(param1 INT) BEGIN
UPDATE courses
SET
  no_of_paparticipants = no_of_paparticipants + 1
WHERE
  course_id = param1;
END