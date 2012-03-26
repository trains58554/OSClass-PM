<?php

    $sendEmail            = '';
    $dao_preference = new Preference();
    if(Params::getParam('sendEmail') != '') {
        $sendEmail = Params::getParam('sendEmail');
    } else {
        $sendEmail = (sendEmail() != '') ? sendEmail() : '' ;
    }
    $maxPm            = '';
    $dao_preference = new Preference();
    if(Params::getParam('maxPm') != '') {
        $maxPm = Params::getParam('maxPm');
    } else {
        $maxPm = (maxPMs() != '') ? maxPMs() : '' ;
    }
    $deletePM            = '';
    $dao_preference = new Preference();
    if(Params::getParam('deletePM') != '') {
        $deletePM = Params::getParam('deletePM');
    } else {
        $deletePM = (deletePM() != '') ? deletePM() : '' ;
    }
    $pmBlocking            = '';
    $dao_preference = new Preference();
    if(Params::getParam('pmBlocking') != '') {
        $locking = Params::getParam('pmBlocking');
    } else {
        $locking = (pmBlocking() != '') ? pmBlocking() : '' ;
    }
    $pmDrafts            = '';
    $dao_preference = new Preference();
    if(Params::getParam('pmDrafts') != '') {
        $pmDrafts = Params::getParam('pmDrafts');
    } else {
        $pmDrafts = (pmDrafts() != '') ? pmDrafts() : '' ;
    }
    $pmSent            = '';
    $dao_preference = new Preference();
    if(Params::getParam('pmSent') != '') {
        $pmSent = Params::getParam('pmSent');
    } else {
        $pmSent = (pmSent() != '') ? pmSent() : '' ;
    }
    $pmAdmin            = '';
    $dao_preference = new Preference();
    if(Params::getParam('pmAdmin') != '') {
        $pmAdmin = Params::getParam('pmAdmin');
    } else {
        $pmAdmin = (pmAdmin() != '') ? pmAdmin() : '' ;
    }
    
    if( Params::getParam('option') == 'stepone' ) {
        $dao_preference->update(array("s_value" => $sendEmail), array("s_section" => "plugin-osclass_pm", "s_name" => "sendEmail")) ;
        $dao_preference->update(array("s_value" => $maxPm), array("s_section" => "plugin-osclass_pm", "s_name" => "maxPMs")) ;
        $dao_preference->update(array("s_value" => $deletePM), array("s_section" => "plugin-osclass_pm", "s_name" => "deletePM")) ;
        $dao_preference->update(array("s_value" => $pmBlocking), array("s_section" => "plugin-osclass_pm", "s_name" => "pmBlocking")) ;
        $dao_preference->update(array("s_value" => $pmDrafts), array("s_section" => "plugin-osclass_pm", "s_name" => "pmDrafts")) ;
        $dao_preference->update(array("s_value" => $pmSent), array("s_section" => "plugin-osclass_pm", "s_name" => "pmSent")) ;
        $dao_preference->update(array("s_value" => $pmAdmin), array("s_section" => "plugin-osclass_pm", "s_name" => "pmAdmin")) ;
        echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Settings Saved', 'osclass_pm') . '.</p></div>';
    }
    unset($dao_preference) ;
    $pluginInfo = osc_plugin_get_info('osclass_pm/index.php');
    //print_r(osc_plugin_get_info('osclass_pm/index.php'));    
?>

<form action="<?php osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="osclass_pm/admin.php" />
    <input type="hidden" name="option" value="stepone" />
    <div>
    <fieldset>
        <h2><?php _e('OSClass PM Settings', 'osclass_pm'); ?></h2> 
        <fieldset>
        <legend><?php echo _e('Settings','osclass_pm'); ?></legend>
        <label for="pmAdmin" style="font-weight: bold;"><?php _e('Admin\'s user name: (default: Admin)', 'osclass_pm'); ?></label>:<br />
        <input type="text" id="pmAdmin" name="pmAdmin" value="<?php echo $pmAdmin; ?>" />
        <br />
        <br />
        <label for="sendEmail" style="font-weight: bold;"><?php _e('Enable sending of email notification of new PM', 'osclass_pm'); ?></label>:<br />
        <select name="sendEmail" id="sendEmail"> 
        	<option <?php if($sendEmail == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes','osclass_pm'); ?></option>
        	<option <?php if($sendEmail == 0){echo 'selected="selected"';}?>value='0'><?php _e('No','osclass_pm'); ?></option>
        </select>
        <br />
        <br />
        <? /* This is for future version once I get the drafts working.
        <label for="pmDrafts" style="font-weight: bold;"><?php _e('Enable the Drafts box', 'osclass_pm'); ?></label>:<br />
        <select name="pmDrafts" id="pmDrafts"> 
        	<option <?php if($pmDrafts == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes','osclass_pm'); ?></option>
        	<option <?php if($pmDrafts == 0){echo 'selected="selected"';}?>value='0'><?php _e('No','osclass_pm'); ?></option>
        </select>
        <br />
        <br /> */ ?>
        <label for="pmSent" style="font-weight: bold;"><?php _e('Enable the Outbox', 'osclass_pm'); ?></label>:<br />
        <select name="pmSent" id="pmSent"> 
        	<option <?php if($pmSent == 1){echo 'selected="selected"';}?>value='1'><?php _e('Yes','osclass_pm'); ?></option>
        	<option <?php if($pmSent == 0){echo 'selected="selected"';}?>value='0'><?php _e('No','osclass_pm'); ?></option>
        </select>
        <br />
        <br />
        <fieldset class="advancedPM">
         <legend><?php _e('Advanced PM Settings','osclass_pm'); ?></legend>
         <label for="maxPm" style="font-weight: bold;"><?php _e('Max number of PM\'s a user can have in there inbox', 'osclass_pm'); ?></label>:<br />
        <input type="text" id="maxPm" name="maxPm" value="<?php echo $maxPm; ?>" />
        <br />
        <br />
        <label for="deletePM" style="font-weight: bold;"><?php _e('Permanently delete deleted Personal Messages', 'osclass_pm'); ?></label>:<br />
        <select name="deletePM" id="deletePM"> 
        	<option <?php if($deletePM == 1){echo 'selected="selected"';}?>value='1'><?php _e('Hourly','osclass_pm');?></option>
        	<option <?php if($deletePM == 2){echo 'selected="selected"';}?>value='2'><?php _e('Daily','osclass_pm');?></option>
        	<option <?php if($deletePM == 3){echo 'selected="selected"';}?>value='3'><?php _e('Weekly','osclass_pm');?></option>
        </select>
        <br />
        <br />
        </fieldset>
        <br />
        <input type="submit" value="<?php _e('Save', 'osclass_pm'); ?>" />        
        </fieldset>
        <?php echo '<br />' . __('Version ', 'osclass_pm') .  $pluginInfo['version'] . ' | ' .  __('Author','osclass_pm') . ' <a class="external" target="_blank" href="' . $pluginInfo['author_uri'] . '">' . $pluginInfo['author'] . '</a>'; ?>        
     </fieldset>
    </div>
</form>
