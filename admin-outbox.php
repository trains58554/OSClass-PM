<?php 
   $recipPMs = ModelPM::newInstance()->getSenderMessages(0, 1, 'pm_id', 'DESC');
   $recipCount = count($recipPMs);
?>
<h2><?php _e('Outbox', 'osclass_pm'); ?></h2>
<fieldset>
            <form action="<?php echo osc_admin_base_url(true); ?>" method="POST">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="file" value="osclass_pm/user-proc.php" />
            <input type="hidden" name="box" value="adminOutbox" />
            <input type="hidden" name="option" value="delMessages" />
            <div class="dataTables_wrapper">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_pm_outbox">
                 	<thead>
                   <tr>
                     <th width="4%"><input name="checkAll" id="checkAll" type="checkbox" /></th>
                   	<th width="25%"><?php _e('Date','osclass_pm'); ?></th>
                   	<th width="54%"><?php _e('Subject','osclass_pm'); ?></th>
                   	<th><?php _e('Sent To','osclass_pm'); ?></th>
                   </tr>
                  </thead>
                  <tbody>
                  <?php if($recipCount == 0) { ?>
                  <tr class="odd">
                     <td></td>
                     <td></td>
                     <td><?php _e('You have no messages', 'osclass_pm'); ?></td>
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
                        <td><?php echo osc_format_date($recipPM['message_date']) . ', ' . osclass_pm_format_time($recipPM['message_date']); ?></td>
                        <td><a class="mesLink" href="<?php echo osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin-messages.php&message=' . $recipPM['pm_id'] . '&box=outbox'); ?>"><?php echo $recipPM['pm_subject']; ?></a></td>
                        <td><?php echo $user['s_name']; ?></td>
                      </tr>
                  <?php } ?>
                  <?php } ?> 
                  </tbody>
                  <tfoot>
                     <tr>
                        <td colspan="2"><button class="pmDeleteButton" onclick="if (!confirm('<?php _e('Are you sure you want to delete all selected personal messages?','osclass_pm'); ?>')) return false;" type="submit"><?php _e('Remove Selected','osclass_pm'); ?></button></td>
                     </tr>
                  </tfoot>
                </table>
                
            </div>
            </form>
</fieldset>          