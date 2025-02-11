create table room_chat (
  room_id integer not null
 ,posted_datetime timestamp not null default CURRENT_TIMESTAMP
 ,account varchar(30)
 ,message varchar(256) not null
 ,version integer not null default 0
 ,created timestamp not null default CURRENT_TIMESTAMP
 ,created_by varchar(30) not null
 ,updated timestamp not null default CURRENT_TIMESTAMP
 ,updated_by varchar(30) not null
 ,unique (room_id, posted_datetime, account)
 ,foreign key (room_id) references rooms(id)
 ,foreign key (account) references users(account)
);
