CREATE TABLE users (
  user_id serial PRIMARY KEY,
  user_name varchar(40) NOT NULL UNIQUE,
  email varchar(40) NOT NULL,
  user_password char(40) NOT NULL,
  user_salt char(40) NOT NULL,
  iterations integer NOT NULL,
  access_level integer NOT NULL  
);

CREATE TABLE posts (
    post_id serial PRIMARY KEY,
    poster_id integer REFERENCES users (user_id),
    text varchar(4096),
    posted_date date NOT NULL
);

CREATE TABLE private_messages (
    post_id integer REFERENCES posts (post_id),
    receiver_id integer REFERENCES users (user_id),
    PRIMARY KEY (post_id, receiver_id)
);

CREATE TABLE replies (
    post_id integer REFERENCES posts (post_id),
    replies_to_id integer REFERENCES posts (post_id),
    PRIMARY KEY(post_id, replies_to_id)
);

CREATE TABLE threads (
    thread_id serial PRIMARY KEY,
    starter_id integer REFERENCES users (user_id)
);

CREATE TABLE thread_posts (
    thread_id integer REFERENCES threads (thread_id),
    post_id integer REFERENCES posts (post_id),
    PRIMARY KEY (thread_id, post_id)
);

CREATE TABLE read_threads (
    thread_id integer REFERENCES threads (thread_id),
    user_id integer REFERENCES users (user_id),
    PRIMARY KEY (thread_id, user_id)
);

CREATE TABLE topics (
    topic_id serial PRIMARY KEY,
    name varchar(40) NOT NULL,
);

CREATE TABLE topic_threads (
    topic_id integer REFERENCES topics (thread_id),
    thread_id integer REFERENCES threads (thread_id),
    PRIMARY KEY (topic_id, thread_id)
);