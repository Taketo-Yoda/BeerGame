create table users (
    account varchar(30) not null primary key
   ,password varchar(64) not null
   ,nickname varchar(60) not null
   ,participate_cnt int not null default 0
   ,auth_name varchar(30) not null
   ,last_login timestamp
   ,version int not null default 0
   ,created timestamp default CURRENT_TIMESTAMP not null
   ,created_by varchar(30) not null
   ,updated timestamp default CURRENT_TIMESTAMP not null
   ,updated_by varchar(30) not null
   ,foreign key(auth_name) references authorities(auth_name)
);