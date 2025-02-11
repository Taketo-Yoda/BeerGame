create table units (
  name varchar(30) not null primary key
 ,display_seq integer not null
 ,description varchar(256) not null
 ,version integer not null default 0
 ,created timestamp not null default CURRENT_TIMESTAMP
 ,created_by varchar(30) not null
 ,updated timestamp not null default CURRENT_TIMESTAMP
 ,updated_by varchar(30) not null
);
