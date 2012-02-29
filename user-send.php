<?php 

?>

<div class="content user_account">
    <h1>
        <strong><?php echo __('New message', 'osc_pm'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
    <form>
      <div class="pm_main">
         <div class="pm_author">
            
         </div>
         <div class="pm_message">
            <div class="pm_tools">
               <table>
                  <tr>
                     <td><?php _e('To: ','osc_pm'); ?></td>
                     <td><input type="textbox" name="sendTo" id="sendTo" /></td>
                  </tr>
                  <tr><td>&nbsp;</td><td></td></tr>
                  <tr class="subject">
                     <td><?php _e('Subject: ','osc_pm'); ?>&nbsp;</td>
                     <td><input type="textbox" maxlength="60" size="60" name="subject" id="subject" value="<?php _e('[No subject]','OSC_PM'); ?>" /></td>
                  </tr>
               </table>
            </div>
            <div class="pm_mess">
               <textarea cols="84" rows="12" name="message" id="message"></textarea>
               <br />
               <p>
               <label for="outbox"><input type="checkbox" class="input_check" checked="checked" tabindex="5" value="1" id="outbox" name="outbox"><?php _e(' Save a copy in my outbox','osc_pm'); ?></label>
               </p>
               <p id="sendMessage">
					    <input type="submit" class="button_submit" accesskey="s"  tabindex="6" value="<?php _e('Send message','osc_pm'); ?>">
				   </p>
            </div>
         </div>
      </div>
    </form>
    </div>
</div>