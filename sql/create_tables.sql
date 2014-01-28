CREATE TABLE users (
  user_id serial PRIMARY KEY,
  user_name varchar(40) NOT NULL UNIQUE,
  email varchar(40) NOT NULL,
  user_password char(64) NOT NULL,
  user_salt char(64) NOT NULL,
  iterations integer NOT NULL,
  access_level integer NOT NULL  
);

CREATE TABLE posts (
    post_id serial PRIMARY KEY,
    poster_id integer REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    text varchar(4096),
    posted_date timestamp NOT NULL,
    is_deleted boolean NOT NULL,
    replies_to integer REFERENCES posts (post_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE private_messages (
    post_id integer REFERENCES posts (post_id),
    receiver_id integer REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (post_id, receiver_id)
);

CREATE TABLE topics (
    topic_id serial PRIMARY KEY,
    name varchar(40) NOT NULL
);


CREATE TABLE threads (
    thread_id serial PRIMARY KEY,
    thread_name varchar(128) NOT NULL,
    starter_id integer REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    topic_id integer REFERENCES topics (topic_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE thread_posts (
    thread_id integer REFERENCES threads (thread_id) ON DELETE CASCADE ON UPDATE CASCADE,
    post_id integer REFERENCES posts (post_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (thread_id, post_id)
);

CREATE TABLE read_threads (
    thread_id integer REFERENCES threads (thread_id) ON DELETE CASCADE ON UPDATE CASCADE,
    user_id integer REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    post_id integer REFERENCES posts (post_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (thread_id, user_id)
);

