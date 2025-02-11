create table rooms (
  id serial not null primary key
 ,name varchar(30)
 ,status varchar(30) not null
 ,difficulty varchar(30) not null
 ,num_of_turn integer not null
 ,current_turn integer not null default 1
 ,start_date timestamp
 ,end_date timestamp
 ,version integer not null default 0
 ,created timestamp not null default CURRENT_TIMESTAMP
 ,created_by varchar(30) not null
 ,updated timestamp not null default CURRENT_TIMESTAMP
 ,updated_by varchar(30) not null
 ,foreign key (status) references room_status(name)
 ,foreign key (difficulty) references difficulties(name)
);
