<?php 
if(osc_is_web_user_logged_in()){
$userSettings = ModelPM::newInstance()->getUserPmSettings(osc_logged_user_id());
?>
<div class="content user_account">
    <h1>
        <strong><?php _e('PM Settings', 'osclass_pm'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
    <form action="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/user-proc.php'; ?>" method="POST">
      <input type="hidden" name="page" value="custom" />
      <input type="hidden" name="file" value="osclass_pm/user-proc.php" />
      <input type="hidden" name="option" value="userSettings" />
      <input type="hidden" name="user_id" value="<?php echo osc_logged_user_id(); ?>" />
      <table class="pmSettings">
         <tr>
            <td><?php _e('Notify by email every time you get a new personal message','osclass_pm'); ?>?</td>
            <td>
               <select name="emailAlert">
                  <option value="1" <?php if($userSettings['send_email'] == 1) { echo 'selected';}?>><?php _e('Always','osclass_pm'); ?></option>
                  <option value="0" <?php if($userSettings['send_email'] == 0) { echo 'selected';}?>><?php _e('Never','osclass_pm'); ?></option>
               </select>
            </td>
         </tr>
         <tr>
            <td><?php _e('Show a flash message when you have new personal messages','osclass_pm'); ?>?</td>
            <td>
               <select name="flashAlert">
                  <option value="1" <?php if($userSettings['flash_alert'] == 1) { echo 'selected';}?>><?php _e('Always','osclass_pm'); ?></option>
                  <option value="0" <?php if($userSettings['flash_alert'] == 0) { echo 'selected';}?>><?php _e('Never','osclass_pm'); ?></option>
               </select>
            </td>
         </tr>
         <?php if( pmSent() ) { ?>
         <tr>
            <td><?php _e('Save a copy of each personal message in your outbox by default','osclass_pm'); ?>?</td>
            <td>
               <select name="saveSent">
                  <option value="1" <?php if($userSettings['save_sent'] == 1) { echo 'selected';}?>><?php _e('Always','osclass_pm'); ?></option>
                  <option value="0" <?php if($userSettings['save_sent'] == 0) { echo 'selected';}?>><?php _e('Never','osclass_pm'); ?></option>
               </select>
            </td>
         </tr>
         <?php } ?>
         <tr>
            <td></td>
            <td class="pmSettingsSave"><input tabindex="5" type="submit" class="button_submit" accesskey="s"  tabindex="6" value="<?php _e('Save Settings','osclass_pm'); ?>"></td>
         </tr>
      </table>
      </form>
    </div>
</div>
<?php } else { 
Session::newInstance()->_setReferer(osc_user_login_url() . '&http_referer=' . osc_base_url(true) . '?page=custom&file=osclass_pm/user-pm-settings.php');
// HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php } ?>