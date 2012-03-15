<?php
   $pm_id = Params::getParam('message');  
   switch(Params::getParam('box')) {
      case 'inbox': 
         $pm = ModelPM::newInstance()->getRecipientMessage(0, 1, 0, $pm_id );
         if($pm['recipNew'] == 1) {
            ModelPM::newInstance()->updateMessageAsRead($pm['pm_id']);
         }
      break;
      case 'outbox':
         $pm = ModelPM::newInstance()->getSenderMessage(0, 1, $pm_id );
      break;
   }
   $words[] = array('[quote]','[/quote]', '[quoteAuthor]','[/quoteAuthor]');
   $words[] = array('<div class="messQuote">','</div>', '<div class="quoteAuthor">','</div>');
   $message  = osc_mailBeauty($pm['pm_message'], $words) ;
?>
    <h2>
    <strong><?php echo __('Message: ', 'osclass_pm') . osc_highlight($pm['pm_subject'], 50); ?></strong>
    </h2>
      <?php if(Params::getParam('box') == 'inbox') { ?>
         <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-inbox.php'; ?>">Back to inbox</a>
      <?php } elseif(Params::getParam('box') == 'outbox') { ?>
         <a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-outbox.php'; ?>">Back to outbox</a>
      <?php } ?> 
      <br />
      <br />
      <div class="pm_main">
         <div class="pm_author">
            <?php if($pm['sender_id'] != 0){
                     $user = User::newInstance()->findByPrimaryKey($pm['sender_id']); 
                  } else { $user['s_name'] = pmAdmin();} ?>
            <span class="sender"><?php _e('Sender:','osclass_pm'); ?></span>
            <br />
            <span class="sender_name"><?php echo $user['s_name']; ?></span>
         </div>
         <div class="pm_message">
            <div class="pm_tools">
               <div class="pm_sub">
                  <span class="subject_pm"><?php echo $pm['pm_subject']; ?></span>
                  <br />
                  <?php if($pm['recip_id'] != 0){
                           $user = User::newInstance()->findByPrimaryKey($pm['recip_id']); 
                        } else { $user['s_name'] = pmAdmin();} ?>
                  <?php echo __('Sent to: ','osclass_pm') . $user['s_name'] . ' ' . __('on: ','osclass_pm') . osc_format_date($pm['message_date']) . ', ' . osclass_pm_format_time($pm['message_date']); ?>
               </div> 
               <ul class="reset pm_tool">
                  <li class="reply"><a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-send.php&mType=adminReply&messId=' . $pm_id . '&userId=' . $pm['sender_id']; ?>" ><?php _e('Reply','osclass_pm'); ?></a></li>
                  <li class="quote"><a href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-send.php&mType=adminQuote&messId=' . $pm_id . '&userId=' . $pm['sender_id']; ?>" ><?php _e('Quote','osclass_pm'); ?></a></li>
                  <li class="del"><a onclick="if (!confirm('<?php _e('Are you sure you want to delete this personal messages?','osclass_pm'); ?>')) return false;" href="<?php echo osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/user-proc.php&pms=' . $pm['pm_id'] . '&option=delMessages&box=adminInbox'; ?>" ><?php _e('Delete','osclass_pm'); ?></a></li>
               </ul>              
            </div>
            <div class="pm_mess">
               <?php echo nl2br($message); ?>
            </div>
         </div>
      </div>