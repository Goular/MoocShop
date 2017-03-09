-- 创建user表
CREATE table imooc_test(
  id int unsigned not null AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(32) not null DEFAULT '',
  password CHAR(32) not null DEFAULT ''
) ENGINE=INNODB charset=utf8;