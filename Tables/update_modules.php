<?php
require_once('../db_conn.php');

try {

  $q = $conn->prepare('ALTER TABLE `modules` ADD CONSTRAINT `new` FOREIGN KEY (`course_id`) REFERENCES `courses`(`course_id`)');
  // $q = $conn->prepare("ALTER TABLE modules CHANGE field2 field2a varchar(50)");
  $q->execute();
  echo "Table modules updated successfully";
} catch (PDOException $e) {
  echo 'error' .  $e;
}

$conn = null;
