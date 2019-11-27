create table if not exists status
(
  id int auto_increment,
  name varchar(50) not null,
  constraint status_id_uindex
  unique (id)
)
;

alter table status
  add primary key (id)
;

create table if not exists users
(
  username varchar(50) not null,
  id bigint auto_increment,
  email varchar(100) not null,
  status_id int default '1' not null,
  constraint user_id_uindex
  unique (id),
  constraint user_status__fk
  foreign key (status_id) references status (id)
)
;

create index user_status_id_index
  on users (status_id)
;

alter table users
  add primary key (id)
;

INSERT INTO my_activities.status (id, name) VALUES (1, 'Waiting for account validation');
INSERT INTO my_activities.status (id, name) VALUES (2, 'Active account');
INSERT INTO my_activities.status (id, name) VALUES (3, 'Waiting for account deletion');


INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('bobdeniro', 1, 'bobdeniro@hollywood.com', 1);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('eliseB', 2, 'eliseb@ihm.com', 1);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('arthurH', 3, 'arthurH@michelin.com', 1);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('wandaL', 4, 'wandal@lalaland.com', 2);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('paulsimon', 5, 'paulsimon@guitare.org', 2);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('jessicaA', 6, 'jessicaa@hollywood.com', 2);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('steveM', 7, 'stevem@cars.com', 2);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('evaM', 8, 'evam@movieland.com', 2);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('alpacino', 9, 'alpacino@moviecountry.com', 2);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('eddym', 10, 'eddym@beverly.com', 3);
INSERT INTO my_activities.users (username, id, email, status_id) VALUES ('francoises', 11, 'francoises@quaidesbrumes.org', 3);