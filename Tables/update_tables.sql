ALTER TABLE `chosen_course`
ADD
  CONSTRAINT `foreign_key_ch_course_new` FOREIGN KEY (`chosen_course_id`) REFERENCES `courses`(`course_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
-- ALTER TABLE `modules`
  -- ADD
  --   CONSTRAINT `foreign_key_modules_2` FOREIGN KEY (`course_id`) REFERENCES `courses`(`course_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
  -- ALTER TABLE `chosen_course`
  -- ADD
  --   CONSTRAINT `foreign_key_ch_course_3` FOREIGN KEY (`user_email`) REFERENCES `users`(`email`) ON DELETE CASCADE ON UPDATE RESTRICT;
  -- ALTER TABLE `courses`
  -- ADD
  --   CONSTRAINT `foreign_key_authors_2` FOREIGN KEY (`author_email`) REFERENCES `authors`(`email`) ON DELETE CASCADE ON UPDATE RESTRICT