create table books (
  member_id integer not null
 ,turn integer not null
 ,status varchar(30) not null
 ,num_of_received integer
 ,num_of_inventory integer
 ,num_of_backordered integer
 ,num_of_order integer
 ,num_of_purchasing integer
 ,num_of_shipping integer
 ,version integer not null default 0
 ,created timestamp not null default CURRENT_TIMESTAMP
 ,created_by varchar(30) not null
 ,updated timestamp not null default CURRENT_TIMESTAMP
 ,updated_by varchar(30) not null
 ,primary key (member_id, turn)
 ,foreign key (member_id) references members(id)
 ,foreign key (status) references book_status(name)
);
