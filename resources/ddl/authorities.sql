create table authorities (
    auth_name varchar(30) not null primary key
   ,description varchar(256) not null
   ,version int default 0 not null
   ,created timestamp default CURRENT_TIMESTAMP not null
   ,created_by varchar(30) not null
   ,updated timestamp default CURRENT_TIMESTAMP not null
   ,updated_by varchar(30) not null
);