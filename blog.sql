
/*博客表*/
CREATE TABLE tp_blog(
id smallint unsigned NOT NULL auto_increment PRIMARY KEY,
addtime int(11) UNSIGNED NOT NULL DEFAULT '0',
title varchar(30) NOT NULL DEFAULT '',
sort varchar(100) NOT NULL DEFAULT '',
content text NOT NULL DEFAULT ''
)ENGINE Myisam CHARSET utf8;

/*评论表*/
CREATE TABLE tp_message(
id INT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
message VARCHAR(150) NOT NULL DEFAULT '',
addtime INT(10) UNSIGNED NOT NULL DEFAULT '0',
parent INT UNSIGNED NOT NULL DEFAULT '0',
email VARCHAR(30) NOT NULL DEFAULT '',
`name` CHAR(20) NOT NULL DEFAULT '' ,
isdelete tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
'blogid' smallint UNSIGNED NOT 	NULL DEFAULT	'0'

)ENGINE Myisam CHARSET utf8