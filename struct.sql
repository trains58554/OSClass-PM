CREATE TABLE /*TABLE_PREFIX*/t_pm_messages(
pm_id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
sender_id int( 10 ) ,
recip_id int( 10 ) ,
pm_subject VARCHAR ( 128 ),
pm_message TEXT,
message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
senderDelete int(1)DEFAULT "0",
recipDelete int(1)DEFAULT "0",
recipNew int (1)DEFAULT "1",
PRIMARY KEY ( pm_id )
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_pm_settings(
id int(11) unsigned NOT NULL AUTO_INCREMENT,
fk_i_user_id int(11),
send_email enum('1','0'),
flash_alert enum('1','0'),
save_sent enum('1','0'),
PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_pm_drafts(
pm_id int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
sender_id int( 10 ) ,
recip_id int( 10 ) ,
pm_subject VARCHAR ( 128 ),
pm_message TEXT,
message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
senderDelete int(1)DEFAULT "0",
recipDelete int(1)DEFAULT "0",
recipNew int (1)DEFAULT "1",
PRIMARY KEY ( pm_id )
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';