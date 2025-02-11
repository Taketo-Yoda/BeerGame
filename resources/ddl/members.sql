create table members (
  id serial not null primary key
 ,room_id integer not null
 ,account varchar(30)
 ,owner_flg boolean not null
 ,unit varchar(30)
 ,status varchar(30) not null
 ,version integer not null default 0
 ,created timestamp not null default CURRENT_TIMESTAMP
 ,created_by varchar(30) not null
 ,updated timestamp not null default CURRENT_TIMESTAMP
 ,updated_by varchar(30) not null
 ,foreign key (room_id) references rooms(id)
 ,foreign key (unit) references units(name)
 ,foreign key (status) references member_status(name)
);
