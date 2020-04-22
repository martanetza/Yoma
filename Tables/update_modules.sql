ALTER TABLE `items`
ADD
  CONSTRAINT `foreign_key_module` FOREIGN KEY (`module_id`) REFERENCES `modules`(`module_id`)