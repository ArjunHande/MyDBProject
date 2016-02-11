DROP procedure IF EXISTS `block_membership`; 
DELIMITER //
CREATE PROCEDURE block_membership(IN `user` INT, IN `block1` INT)
BEGIN
   DECLARE count1 INT ;
   DECLARE count2 INT ;
   DECLARE count3 INT ;
   SET count1 = (SELECT COUNT(*) FROM block_members R WHERE R.block_id = block1 and status = 'member');
   SET count2 = (SELECT COUNT(*) FROM Block_Approval A WHERE A.applying_user_id = user 	  
   AND A.block_id = block1 AND A.status = 'approved');
  
   IF (count1 >= 3) THEN
      IF (count2 >= 3) THEN
	update block_members set status = 'member' where user_id = user; 
      END IF;
   ELSE
       IF(count2 = count1) THEN
           update block_members set status = 'member' where user_id = user;
       END IF;
   END IF;
 
 END //
 DELIMITER ;
