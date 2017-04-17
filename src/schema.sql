CREATE TABLE IF NOT EXISTS namespace (
  namespace_path TEXT,
  namespace      TEXT
);

CREATE TABLE IF NOT EXISTS use (
  usage_path TEXT,
  namespace  TEXT,
  FQN        TEXT,
  name       TEXT
);

CREATE TABLE IF NOT EXISTS class (
  class_path TEXT,
  namespace  TEXT,
  FQN        TEXT,
  name       TEXT
);

CREATE TABLE IF NOT EXISTS extends (
  FQN       TEXT,
  super_FQN TEXT
);

CREATE TABLE IF NOT EXISTS implements (
  FQN           TEXT,
  interface_FQN TEXT
);