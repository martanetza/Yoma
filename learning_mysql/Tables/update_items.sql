ALTER TABLE items
ADD
  FOREIGN KEY (module_id) REFERENCES modules(module_id);