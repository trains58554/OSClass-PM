<?php 
   $userId = Params::getParam('userId');
   $itemId = Params::getParam('itemId');
   $mType  = Params::getParam('mType');
   $messId = Params::getParam('messId');
if(osc_is_web_user_logged_in()) {

if($userId != 0){
   $messCount = ModelPM::newInstance()->countRecipientMessages($userId);
} else {
   $messCount = 0;
}

if($messCount < maxPMs()){   
   
   $pm = ModelPM::newInstance()->getByPrimaryKey($messId, 0);
   
   if($userId == 0 && $userId !='') {
      $user['s_name'] = pmAdmin();
   } else {
      $user = User::newInstance()->findByPrimaryKey($userId);
   }
   if($itemId != '') {
      $item = Item::newInstance()->findByPrimaryKey($itemId);
   }
?>

<div class="content user_account">
    <h1>
        <strong><?php echo __('New message', 'osclass_pm'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
    <form id="newMessage-form" action="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/user-proc.php'; ?>" method="POST">
      <input type="hidden" name="page" value="custom" />
      <input type="hidden" name="file" value="osclass_pm/user-proc.php" />
      <input type="hidden" name="box" value="<?php echo $mType; ?>" />
      <input type="hidden" name="option" value="send" />
      <input name="senderId" type="hidden" value="<?php echo osc_logged_user_id(); ?>" />
      <div class="pm_main">
         <div class="pm_author">
            
         </div>
         <div class="pm_message">
            <div class="pm_tools">
               <table>
                  <tr>
                     <td><?php _e('To: ','osclass_pm'); ?></td>
                     <td>
                        <input tabindex="1" id="pmNames" readonly="readonly" type="text" <?php if(isset($user)){echo 'value="' . $user['s_name'] . '"';} ?> />
                        <input name="recipId" type="hidden" value="<?php echo $userId;?>" />
                        <?php /*<select id="combobox">
                           <option value="">Select one...</option>
                           <?php $users = ModelPM::newInstance()->getUsers(); ?>
                           <?php foreach($users as $user) { ?>
                              <option value="<?php $user['s_name']; ?>"><?php $user['s_name']; ?></option>
                           <?php } ?>
                        </select> */ ?>
                     </td>
                  </tr>
                  <tr><td>&nbsp;</td><td></td></tr>
                  <tr class="subject">
                     <td><?php _e('Subject: ','osclass_pm'); ?>&nbsp;</td>
                     <td><input tabindex="2" type="textbox" maxlength="60" size="60" name="subject" id="subject" value="<?php if(@$item != ''){echo 'Item: ' . @$item['s_title'];}elseif($mType == 'reply' || $mType == 'quote'){echo $pm['pm_subject'];}else{ _e('[No subject]','osclass_pm');} ?>" /></td>
                  </tr>
               </table>
            </div>
            <div class="pm_mess">
               <textarea tabindex="3" cols="80" rows="12" name="message" id="description"><?php if($mType == 'quote') {echo '[quote][quoteAuthor]' . __('Quote from:','osclass_pm') . ' ' . $user['s_name'] . ' ' . __('on: ','osclass_pm') . osc_format_date($pm['message_date']) . ', ' . osclass_pm_format_time($pm['message_date']) . "[/quoteAuthor]\n" . $pm['pm_message'] . "\n[/quote]";} ?></textarea>
               <br />
               <?php if(pmSent()) { ?>
               <p>
               <label for="outbox"><input <?php if(pmSaveSent() == 1){echo 'checked';} ?> tabindex="4" type="checkbox" class="input_check"  tabindex="5" value="1" id="outbox" name="outbox"><?php _e(' Save a copy in my outbox','osclass_pm'); ?></label>
               </p>
               <?php } ?>
               <p id="sendMessage">
					    <input tabindex="5" type="submit" class="button_submit" accesskey="s"  tabindex="6" value="<?php _e('Send message','osclass_pm'); ?>">
				   </p>
            </div>
            <?php if($mType == 'reply' || $mType == 'quote') {?>
            <?php 
               $words[] = array('[quote]','[/quote]', '[quoteAuthor]','[/quoteAuthor]');
               $words[] = array('<div class="messQuote">','</div>', '<div class="quoteAuthor">','</div>');
               $message  = osc_mailBeauty($pm['pm_message'], $words) ;
            ?>
            <div class="pm_mess">
               <h3><?php echo __('Subject:','osclass_pm') . ' ' . $pm['pm_subject']; ?></h3>
               <p id="fromPM"><?php echo __('From:','osclass_pm') . ' ' . $user['s_name'] . ' ' . __('on: ','osclass_pm') . osc_format_date($pm['message_date']) . ', ' . osclass_pm_format_time($pm['message_date']); ?></p>
               <p id="replyMess">
                  <?php echo nl2br($message); ?>
               </p>
            </div>
            <?php } ?>
         </div>
      </div>
    </form>
    </div>
</div>
<?php } else { ?>
      <script>location.href="<?php echo $_SERVER['HTTP_REFERER'] . '&f=1'; ?>"</script>
<?php } ?>
<?php } else { 
// HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php } ?>