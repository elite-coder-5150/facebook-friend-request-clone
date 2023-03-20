create database friend_request_system;
use friend_request_system;

create table users
(
    user_id  int          not null auto_increment,
    username varchar(255) not null,
    primary key (user_id)
);

create table relation
(
    `from`         bigint(20)                               not null,
    `to`           bigint(20)                               not null,
    `status`       enum ('pending', 'accepted', 'rejected') not null default 'pending',
    `acceptedDate` datetime                                          default null on update current_timestamp
)
