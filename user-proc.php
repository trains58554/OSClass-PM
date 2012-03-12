<?php
    //set include
    define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
    require_once ABS_PATH . 'oc-load.php'; 
    
switch(Params::getParam('option')){
   case 'delMessages':
   switch(Params::getParam('box')) {
      case 'inbox':
         $pmDelIds = Params::getParam('pms');
         if (!is_array($pmDelIds)) {
            ModelPM::newInstance()->updateMessagesRecipDelete($pmDelIds);
         } else {
            foreach($pmDelIds as $pmDelId){
               ModelPM::newInstance()->updateMessagesRecipDelete($pmDelId);
            }
         }
         osc_add_flash_ok_message(__('Messages deleted!',''));
         // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	<?php
         //header("Location: " . osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php');
      
      break;
      case 'outbox':
         $pmDelIds = Params::getParam('pms');
         if (!is_array($pmDelIds)) {
            ModelPM::newInstance()->updateMessagesSenderDelete($pmDelIds);
         } else {
            foreach($pmDelIds as $pmDelId){
               ModelPM::newInstance()->updateMessagesSenderDelete($pmDelId);
            }
         }
         osc_add_flash_ok_message(__('Messages deleted!',''));
         // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-outbox.php'; ?>"</script>
    	<?php
         //header("Location: " . osc_base_url(true) . '?page=custom&file=osclass_pm/user-outbox.php');
      break;
   }
   break;
   case 'send':
      $sender_id  = Params::getParam('senderId');
      $recip_id   = Params::getParam('recipId');
      $subject    = Params::getParam('subject');
      $message    = Params::getParam('message');
      $saveOutbox = (Params::getParam('outbox')!='')? 0 : 1;
      switch(Params::getParam('box')) {
         case 'reply':
            if($subject == '') {
               $subject = '[No subject]';
            }
            if (stripos($subject,'Re:') === false) {
               $subject = 'Re: ' . $subject;
            }
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
            osc_add_flash_ok_message(__('Your Message has been Sent!',''));
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	      <?php
         break;
         case 'quote':
            if($subject == '') {
               $subject = '[No subject]';
            }
            if (stripos($subject,'Re:') === false) {
               $subject = 'Re: ' . $subject;
            }
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
            osc_add_flash_ok_message(__('Your Message has been Sent!',''));
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	      <?php
         break;
         case 'new':
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
            osc_add_flash_ok_message(__('Your Message has been Sent!',''));
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	      <?php
         break;
      }
   break;     
}
?>