create table mng_session (
    id varchar(128) not null,
    ip_address varchar(45) not null,
    timestamp int unsigned not null default 0,
    data mediumblob not null,
    key ci_sessions_timestamp (timestamp)
) engine=InnoDB default charset=utf8 comment='CodeIgniter를 위한 db session용 테이블';