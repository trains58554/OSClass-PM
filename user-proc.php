<?php
    //set include
    define('ABS_PATHS', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
    require_once ABS_PATHS . 'oc-load.php'; 
    
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
         osc_add_flash_ok_message(__('Messages deleted!','osclass_pm'));
         // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	<?php
         //header("Location: " . osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php');
      
      break;
      case 'adminInbox':
         $pmDelIds = Params::getParam('pms');
         if (!is_array($pmDelIds)) {
            ModelPM::newInstance()->updateMessagesRecipDelete($pmDelIds);
         } else {
            foreach($pmDelIds as $pmDelId){
               ModelPM::newInstance()->updateMessagesRecipDelete($pmDelId);
            }
         }
         osc_add_flash_ok_message(__('Messages deleted!','osclass_pm'), 'admin');
         // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-inbox.php'; ?>"</script>
    	<?php
         //header("Location: " . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-inbox.php');
      
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
         osc_add_flash_ok_message(__('Messages deleted!','osclass_pm'));
         // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-outbox.php'; ?>"</script>
    	<?php
         //header("Location: " . osc_base_url(true) . '?page=custom&file=osclass_pm/user-outbox.php');
      break;
      case 'adminOutbox':
         $pmDelIds = Params::getParam('pms');
         if (!is_array($pmDelIds)) {
            ModelPM::newInstance()->updateMessagesSenderDelete($pmDelIds);
         } else {
            foreach($pmDelIds as $pmDelId){
               ModelPM::newInstance()->updateMessagesSenderDelete($pmDelId);
            }
         }
         osc_add_flash_ok_message(__('Messages deleted!','osclass_pm'),'admin');
         // HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-outbox.php'; ?>"</script>
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
            
            
               $pm_info = array();
               $pm_info = array('pm_id' => ModelPM::newInstance()->getLastMessageId(), 'sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $subject, 'pm_message' => $message);
               if(sendEmail() && pmEmailAlert($recip_id)){
                  new_pm_email($pm_info);
               }
               
               if(sendEmail() && $recip_id == 0){ 
                  new_pm_email($pm_info);
               }
            
            
            osc_add_flash_ok_message(__('Your Message has been Sent!','osclass_pm'));
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
            
               $pm_info = array();
               $pm_info = array('pm_id' => ModelPM::newInstance()->getLastMessageId(), 'sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $subject, 'pm_message' => $message);
               if(sendEmail() && pmEmailAlert($recip_id)){
                  new_pm_email($pm_info);
               }
               
               if(sendEmail() && $recip_id == 0){ 
                  new_pm_email($pm_info);
               }
               
            osc_add_flash_ok_message(__('Your Message has been Sent!','osclass_pm'));
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	      <?php
         break;
         case 'new':
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
            
               $pm_info = array();
               $pm_info = array('pm_id' => ModelPM::newInstance()->getLastMessageId(), 'sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $subject, 'pm_message' => $message);
               if(sendEmail() && pmEmailAlert($recip_id)){
                  new_pm_email($pm_info);
               }
               
               if(sendEmail() && $recip_id == 0){ 
                  new_pm_email($pm_info);
               }
               
            osc_add_flash_ok_message(__('Your Message has been Sent!','osclass_pm'));
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php'; ?>"</script>
    	      <?php
         break;
         case 'adminReply':
            if($subject == '') {
               $subject = '[No subject]';
            }
            if (stripos($subject,'Re:') === false) {
               $subject = 'Re: ' . $subject;
            }
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
            
               $pm_info = array();
               $pm_info = array('pm_id' => ModelPM::newInstance()->getLastMessageId(), 'sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $subject, 'pm_message' => $message);
               if(sendEmail() && pmEmailAlert($recip_id)){
                  new_pm_email($pm_info);
               }
               
               if(sendEmail() && $recip_id == 0){ 
                  new_pm_email($pm_info);
               }
               
            osc_add_flash_ok_message(__('Your Message has been Sent!','osclass_pm'),'admin');
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-inbox.php'; ?>"</script>
    	      <?php
         break;
         case 'adminQuote':
            if($subject == '') {
               $subject = '[No subject]';
            }
            if (stripos($subject,'Re:') === false) {
               $subject = 'Re: ' . $subject;
            }
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
               
               $pm_info = array();
               $pm_info = array('pm_id' => ModelPM::newInstance()->getLastMessageId(), 'sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $subject, 'pm_message' => $message);
               if(sendEmail() && pmEmailAlert($recip_id)){
                  new_pm_email($pm_info);
               }
               
               if(sendEmail() && $recip_id == 0){ 
                  new_pm_email($pm_info);
               }
               
            osc_add_flash_ok_message(__('Your Message has been Sent!','osclass_pm'),'admin');
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-inbox.php'; ?>"</script>
    	      <?php
         break;
         case 'adminNew':
            ModelPM::newInstance()->insertMessage($sender_id, $recip_id, $subject, $message, $saveOutbox);
            
               $pm_info = array();
               $pm_info = array('pm_id' => ModelPM::newInstance()->getLastMessageId(), 'sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $subject, 'pm_message' => $message);
               if(sendEmail() && pmEmailAlert($recip_id)){
                  new_pm_email($pm_info);
               }
               
               if(sendEmail() && $recip_id == 0){ 
                  new_pm_email($pm_info);
               }
               
            osc_add_flash_ok_message(__('Your Message has been Sent!','osclass_pm'),'admin');
            // HACK TO DO A REDIRECT ?>
    	       <script>location.href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-inbox.php'; ?>"</script>
    	      <?php
         break;
      }
   break;  
   case 'userSettings':
      $emailAlert = Params::getParam('emailAlert');
      $flashAlert = Params::getParam('flashAlert');
      $saveSent   = Params::getParam('saveSent');
      $user_id    = Params::getParam('user_id');
      ModelPM::newInstance()->updatePmSettings($user_id, $emailAlert,$flashAlert,$saveSent);
      osc_add_flash_ok_message(__('Your Settings have been saved!','osclass_pm'));
      // HACK TO DO A REDIRECT ?>
    	 <script>location.href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-pm-settings.php'; ?>"</script>
    	<?php
   break;   
}

?>