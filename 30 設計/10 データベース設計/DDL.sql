-- Project Name : connectyee_ver2.0
-- Date/Time    : 2015/10/21 17:48:42
-- Author       : Y.Yamada
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2
drop table if exists outing_informations cascade;

create table outing_informations (
  id INT not null auto_increment
  , attendances_id INT not null
  , out_from_office TIME
  , return_to_office TIME
  , memo TEXT
  , constraint outing_informations_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index outing_informations_IX1
  on outing_informations(id,attendances_id);

create table attendances (
  id INT not null auto_increment
  , target_user INT not null
  , target_date DATE default NULL
  , attendance_kubun INT default NULL
  , memo TEXT default NULL
  , registration_user INT not null
  , registration_date DATETIME default NULL
  , time_in TIME default NULL
  , time_out TIME default NULL
  , constraint attendances_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index attendances_IX1
  on attendances(id,target_user,target_date);

drop table if exists calendars cascade;

create table calendars (
  calendar_date DATE not null
  , date_kubun INT default NULL
  , date_name TINYTEXT default NULL
  , constraint calendars_PKC primary key (calendar_date)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index calendars_IX1
  on calendars(calendar_date);

drop table if exists receiving_users cascade;

create table receiving_users (
  id INT not null auto_increment
  , web_mail_id INT not null
  , user_id INT not null
  , unread_kubun INT default NULL
  , delete_kubun INT default NULL
  , constraint receiving_users_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index receiving_users_IX1
  on receiving_users(web_mail_id,user_id,delete_kubun);

drop table if exists web_mails cascade;

create table web_mails (
  id INT not null auto_increment
  , user_id INT not null
  , subject TINYTEXT default NULL
  , body LONGTEXT default NULL
  , sending_time DATETIME default NULL
  , delete_kubun INT default NULL
  , constraint web_mails_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index web_mails_IX1
  on web_mails(id,user_id,sending_time,delete_kubun);

drop table if exists schedules cascade;

create table schedules (
  id INT not null auto_increment
  , user_id INT not null
  , subject TINYTEXT default NULL
  , target_date DATE default NULL
  , start_time TIME default NULL
  , end_time TIME default NULL
  , publishing_kubun INT default NULL
  , constraint schedules_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index schedules_IX1
  on schedules(id,user_id,target_date);

drop table if exists comments cascade;

create table comments (
  id INT not null auto_increment
  , user_id INT not null
  , post_id INT not null
  , title TINYTEXT default NULL
  , body LONGTEXT default NULL
  , post_date DATETIME default NULL
  , constraint comments_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index comments_IX1
  on comments(id,user_id,post_id,post_date);

drop table if exists posts cascade;

create table posts (
  id INT not null auto_increment
  , user_id INT not null
  , title TINYTEXT default NULL
  , body LONGTEXT default NULL
  , post_date DATETIME default NULL
  , constraint posts_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index posts_IX1
  on posts(id,user_id,post_date);

drop table if exists users cascade;

create table users (
  id INT not null auto_increment
  , account TINYTEXT default NULL
  , password TINYTEXT default NULL
  , full_name TINYTEXT default NULL
  , full_name_kana TINYTEXT default NULL
  , mail_address TINYTEXT default NULL
  , authority INT default NULL
  , delete_kubun INT default NULL
  , constraint users_PKC primary key (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

create index users_IX1
  on users(id,account,password);

