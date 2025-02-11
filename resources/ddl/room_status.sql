create table room_status (
  name varchar(30) not null primary key
 ,display_flg boolean not null
 ,entry_flg boolean not null
 ,watching_flg boolean not null
 ,description varchar(256) not null
 ,version integer not null default 0
 ,created timestamp not null default CURRENT_TIMESTAMP
 ,created_by varchar(30) not null
 ,updated timestamp not null default CURRENT_TIMESTAMP
 ,updated_by varchar(30) not null
);
