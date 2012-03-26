<?php 
   $userId = Params::getParam('userId');
   $itemId = Params::getParam('itemId');
   $mType  = Params::getParam('mType');
   $messId = Params::getParam('messId');
   
   $pm = ModelPM::newInstance()->getByPrimaryKey($messId);
   
   if($userId == 0 && $userId !='') {
      $user['s_name'] = pmAdmin();
   } else {
      $user = User::newInstance()->findByPrimaryKey($userId);
   }
   if($itemId != '') {
      $item = Item::newInstance()->findByPrimaryKey($itemId);
   }
?>

<form id="newMessage-form" action="<?php echo osc_admin_base_url(true); ?>" method="POST">
      <input type="hidden" name="page" value="plugins" />
      <input type="hidden" name="action" value="renderplugin" />
      <input type="hidden" name="file" value="osclass_pm/user-proc.php" />
      <input type="hidden" name="box" value="<?php echo $mType; ?>" />
      <input type="hidden" name="option" value="send" />
      <input name="senderId" type="hidden" value="0" />
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
                     <td><input tabindex="2" type="textbox" maxlength="60" size="60" name="subject" id="subject" value="<?php if(@$item != ''){echo 'Item: ' . @$item['s_title'];}elseif($mType == 'adminReply' || $mType == 'adminQuote'){echo $pm['pm_subject'];}else{ _e('[No subject]','osclass_pm');} ?>" /></td>
                  </tr>
               </table>
            </div>
            <div class="pm_mess">
               <textarea tabindex="3" cols="75" rows="12" name="message" id="message"><?php if($mType == 'adminQuote') {echo '[quote][quoteAuthor]' . __('Quote from:','osclass_pm') . ' ' . $user['s_name'] . ' ' . __('on: ','osclass_pm') . osc_format_date($pm['message_date']) . ', ' . osclass_pm_format_time($pm['message_date']) . "[/quoteAuthor]\n" . $pm['pm_message'] . "\n[/quote]";} ?></textarea>
               <br />
               <p>
               <label for="outbox"><input tabindex="4" type="checkbox" checked class="input_check"  tabindex="5" value="1" id="outbox" name="outbox"><?php _e(' Save a copy in my outbox','osclass_pm'); ?></label>
               </p>
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