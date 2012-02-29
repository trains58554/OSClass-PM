<?php if(osc_is_web_user_logged_in() ) {  
   $recipPMs = ModelPM::newInstance()->getSenderMessages(osc_logged_user_id(), 1, 'pm_id', 'DESC');
   $recipCount = count($recipPMs);
?>
<div class="content user_account">
    <h1>
        <strong><?php _e('Outbox', 'osc_pm'); ?></strong>
    </h1>
    <div id="sidebar">
        <?php echo osc_private_user_menu(); ?>
    </div>
    <div id="main">
            <h2><?php _e('Outbox', 'osc_pm'); ?></h2>
            <form action="<?php echo osc_base_url(true); ?>" method="POST">
            <input type="hidden" name="page" value="custom" />
            <input type="hidden" name="file" value="osclass_pm/user-proc.php" />
            <input type="hidden" name="box" value="outbox" />
            <input type="hidden" name="option" value="delMessages" />
            <div class="dataTables_wrapper">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_pm_outbox">
                 	<thead>
                   <tr>
                     <th width="4%"><input name="checkAll" id="checkAll" type="checkbox" /></th>
                   	<th width="25%"><?php _e('Date','osc_pm'); ?></th>
                   	<th width="54%"><?php _e('Subject','osc_pm'); ?></th>
                   	<th><?php _e('Sent To','osc_pm'); ?></th>
                   </tr>
                  </thead>
                  <tbody>
                  <?php if($recipCount == 0) { ?>
                  <tr class="odd">
                     <td></td>
                     <td><?php _e('You have no messages', 'osc_pm'); ?></td>
                     <td></td>
                  </tr>
                  <?php } else { ?>
                  <?php 
                  $odd = 1;
                  foreach($recipPMs as $recipPM){ 
                  	 if($odd==1) {
                  		$odd_even = "odd";
                  		$odd = 0;
                      } else {
                      	$odd_even = "even";
                      	$odd = 1;
                      }
                         			 
                      ?>
                      <tr class="<?php echo $odd_even;?>">
                      <?php $user = User::newInstance()->findByPrimaryKey($recipPM['recip_id']); ?>
                        <td class="pmCheckboxes"><input class="delChecks" type="checkbox" id="delete<?php echo $recipPM['pm_id']; ?>" name="pms[]" value="<?php echo $recipPM['pm_id']; ?>" /></td>
                        <td><?php echo osc_format_date($recipPM['message_date']) . ', ' . osc_format_time($recipPM['message_date']); ?></td>
                        <td><a class="mesLink" href="<?php echo osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-messages.php?message=' . $recipPM['pm_id'] . '&box=outbox'); ?>"><?php echo $recipPM['pm_subject']; ?></a></td>
                        <td><?php echo $user['s_name']; ?></td>
                      </tr>
                  <?php } ?>
                  <?php } ?> 
                  </tbody>
                  <tfoot>
                     <tr>
                        <td colspan="2"><button class="pmDeleteButton" onclick="if (!confirm('<?php _e('Are you sure you want to delete all selected personal messages?','osc_pm'); ?>')) return false;" type="submit"><?php _e('Remove Selected','osc_pm'); ?></button></td>
                     </tr>
                  </tfoot>
                </table>
                
            </div>
            </form>
    </div>
</div>
<?php } else { 
// HACK TO DO A REDIRECT ?>
    	<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php } ?>