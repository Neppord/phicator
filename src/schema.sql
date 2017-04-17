CREATE TABLE IF NOT EXISTS namespace (
  namespace_path TEXT,
  namespace      TEXT
);

CREATE TABLE IF NOT EXISTS usages (
  usage_path TEXT,
  namespace  TEXT,
  FQN        TEXT,
  name       TEXT
);

CREATE TABLE IF NOT EXISTS classes (
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