CREATE TABLE users (
  user_id serial PRIMARY KEY,
  user_name varchar(40) NOT NULL UNIQUE,
  email varchar(40) NOT NULL,
  user_password char(40) NOT NULL,
  user_salt char(40) NOT NULL,
  iterations integer NOT NULL,
  access_level integer NOT NULL  
);