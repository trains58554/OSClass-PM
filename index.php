<?php
/*
Plugin Name: Personal Messaging for OSClass
Plugin URI: 
Description: A Personal Messaging system for OSClass.
Version: 1.5.1
Author: JChapman
Author URI: http://forums.osclass.org/index.php?action=profile;u=1728
Short Name: osclass_pm

The plans of the diligent lead to profit as 
surely as haste leads to poverty. Proverbs 21:5
*/
require_once 'ModelPM.php';

// Install and uninstall functions.

    function osclass_pm_install() {
       ModelPM::newInstance()->import('osclass_pm/struct.sql');

       osc_set_preference('sendEmail', '1', 'plugin-osclass_pm', 'INTEGER');
       osc_set_preference('maxPMs', '100', 'plugin-osclass_pm', 'INTEGER');
       osc_set_preference('deletePM', '3', 'plugin-osclass_pm', 'INTEGER');
       osc_set_preference('pmBlocking', '1', 'plugin-osclass_pm', 'INTEGER');
       osc_set_preference('pmDrafts', '0', 'plugin-osclass_pm', 'INTEGER');
       osc_set_preference('pmSent', '1', 'plugin-osclass_pm', 'INTEGER');
       osc_set_preference('pmAdmin', 'Admin', 'plugin-osclass_pm', 'STRING');
       
       ModelPM::newInstance()->insertUsersPmSettings();
       ModelPM::newInstance()->insertEmailTemplates();
    }
    
    function osclass_pm_uninstall() {
       ModelPM::newInstance()->uninstall();
       ModelPM::newInstance()->removeEmailTemplates();
       
       osc_delete_preference('sendEmail', 'plugin-osclass_pm');
       osc_delete_preference('maxPMs', 'plugin-osclass_pm');
       osc_delete_preference('deletePM','plugin-osclass_pm');
       osc_delete_preference('pmBlocking', 'plugin-osclass_pm');
       osc_delete_preference('pmDrafts', 'plugin-osclass_pm');
       osc_delete_preference('pmSent', 'plugin-osclass_pm');
       osc_delete_preference('pmAdmin', 'plugin-osclass_pm');
    }
    
// End install and uninstall functions  

// HELPER

    function sendEmail() {
        return(osc_get_preference('sendEmail', 'plugin-osclass_pm')) ;
    }
    
    function maxPMs() {
       return(osc_get_preference('maxPMs','plugin-osclass_pm'));
    }
    
    function deletePM() {
       return(osc_get_preference('deletePM','plugin-osclass_pm'));
    }
    
    function pmBlocking() {
       return(osc_get_preference('pmBlocking','plugin-osclass_pm'));
    }
    
    function pmDrafts() {
       return(osc_get_preference('pmDrafts','plugin-osclass_pm'));
    }
    
    function pmSent() {
       return(osc_get_preference('pmSent','plugin-osclass_pm'));
    }
    
    function pmAdmin() {
       return(osc_get_preference('pmAdmin','plugin-osclass_pm'));
    }
    
    //user pm settings helpers    
    function pmEmailAlert($user_id) {
       $userSettings = ModelPM::newInstance()->getUserPmSettings($user_id);
       return @$userSettings['send_email'];
    }
    
    function pmFlashAlert() {
       $userSettings = ModelPM::newInstance()->getUserPmSettings(osc_logged_user_id());
       return $userSettings['flash_alert'];
    }
    
    function pmSaveSent() {
       $userSettings = ModelPM::newInstance()->getUserPmSettings(osc_logged_user_id());
       return $userSettings['save_sent'];
    }
    
    /**
     * Formats the time using the appropriate format.
     *
     * @param string $date
     */
    function osclass_pm_format_time($date) {
        return date(osc_time_format(), strtotime($date)) ;
    }
    
    /**
     * Get if user is on profile page
     *
     * @return boolean
     */
    function osclass_pm_is_pub_profile() {
      $location = Rewrite::newInstance()->get_location();
      $section = Rewrite::newInstance()->get_section();
      if($location == 'user' && $section == 'pub_profile'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if user is on inbox page
     *
     * @return boolean
     */
    function osclass_pm_is_inbox() {
      $location = Rewrite::newInstance()->get_location();
      $file     = Params::getParam('file');
      if($location == 'custom' && $file == 'osclass_pm/user-inbox.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if user is on outbox page
     *
     * @return boolean
     */
    function osclass_pm_is_outbox() {
      $location = Rewrite::newInstance()->get_location();
      $file     = Params::getParam('file');
      if($location == 'custom' && $file == 'osclass_pm/user-outbox.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if user is on drafts page
     *
     * @return boolean
     */
    function osclass_pm_is_drafts() {
      $location = Rewrite::newInstance()->get_location();
      $file     = Params::getParam('file');
      if($location == 'custom' && $file == 'osclass_pm/user-drafts.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if user is on send page
     *
     * @return boolean
     */
    function osclass_pm_is_send() {
      $location = Rewrite::newInstance()->get_location();
      $file     = Params::getParam('file');
      if($location == 'custom' && $file == 'osclass_pm/user-send.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if user is on messages page
     *
     * @return boolean
     */
    function osclass_pm_is_messages() {
      $location = Rewrite::newInstance()->get_location();
      $file     = rtrim(Params::getParam('file'),'?');
      if($location == 'custom' && $file == 'osclass_pm/user-messages.php'){
         return TRUE;
      }
      return FALSE;
    }
    
   /**
     * Get if user is on user pm settings page
     *
     * @return boolean
     */
    function osclass_pm_is_pmSettings() {
      $location = Rewrite::newInstance()->get_location();
      $file     = rtrim(Params::getParam('file'),'?');
      if($location == 'custom' && $file == 'osclass_pm/user-pm-settings.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if admin is on inbox page
     *
     * @return boolean
     */
    function osclass_is_inbox_page() {
      $location = Params::getParam('page');
      $file = Params::getParam('file');      
      if($location == 'plugins' && $file == 'osclass_pm/admin-inbox.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if admin is on outbox page
     *
     * @return boolean
     */
    function osclass_is_outbox_page() {
      $location = Params::getParam('page');
      $file = Params::getParam('file');      
      if($location == 'plugins' && $file == 'osclass_pm/admin-outbox.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if admin is on messages page
     *
     * @return boolean
     */
    function osclass_is_messages_page() {
      $location = Params::getParam('page');
      $file = Params::getParam('file');      
      if($location == 'plugins' && $file == 'osclass_pm/admin-messages.php'){
         return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Get if admin is on reply page
     *
     * @return boolean
     */
    function osclass_is_reply_page() {
      $location = Params::getParam('page');
      $file = Params::getParam('file');      
      if($location == 'plugins' && $file == 'osclass_pm/admin-send.php'){
         return TRUE;
      }
      return FALSE;
    }
    
// End HELPERS

// Before HTML 

   function osclass_pm_before_html() {
      $inboxFull = Params::getParam('f');
      if(osc_is_web_user_logged_in() && $inboxFull == 1) {
         osc_add_flash_error_message(__('Sorry the selected user\'s inbox is full! Please try again later.','osclass_pm'));
      }
      if(osc_is_web_user_logged_in() && pmFlashAlert() == 1 && !osclass_pm_is_inbox() && !osclass_pm_is_messages() ) {
         $newPMs = ModelPM::newInstance()->getRecipientMessages(osc_logged_user_id(), 1, 1, 'pm_id', 'DESC');
         $countPMs = count($newPMs);
      
         if($countPMs > 0 && $countPMs < 2) {
            osc_add_flash_ok_message(__('You have','osclass_pm') . ' ' . $countPMs . ' ' . __('new Personal Message!','osclass_pm'));
         } elseif($countPMs > 1) {
            osc_add_flash_ok_message(__('You have','osclass_pm') . ' ' . $countPMs . ' ' . __('new Personal Messages!','osclass_pm'));
         } 
      }
   }
   
// End Before HTML

// Everything between this section is user side related.  
  
    function osclass_pm_header() {
       // Check to see if the page loaded is one of our plugins pages that way 
       // we only load the javascript when we need it.
       if(osclass_pm_is_inbox() || osclass_pm_is_outbox() || osclass_pm_is_drafts() || osclass_pm_is_send() || osclass_pm_is_messages() || osclass_pm_is_pmSettings() ) {
       ?>
       <link rel="stylesheet" type="text/css" href="<?php echo osc_base_url() .'oc-content/plugins/osclass_pm/css/style.css'; ?>" />
       <link rel="stylesheet" type="text/css" href="<?php echo osc_base_url() .'oc-content/plugins/osclass_pm/css/pmTables.css'; ?>" />
       <script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.dataTables.min.js'; ?>"></script>
       <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {			   
				$('#datatables_pm').dataTable( {
					"aaSorting": [[ 1, "desc" ]],
					"bStateSave": true,
					"sPaginationType": "full_numbers",
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }]
				} );
				
				$('#datatables_pm_outbox').dataTable( {
					"aaSorting": [[ 1, "desc" ]],
					"bStateSave": true,
					"sPaginationType": "full_numbers",
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }]
				} );
			
			
			$('#checkAll').change(function() {
            $(".delChecks").attr("checked", this.checked);
         });
         
         $(".delChecks").change(function() {
            $("#checkAll").attr("checked", $(".delChecks:checked").length == $(".delChecks").length);

         });
			
			} );
		</script>
		<script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.ui.widget.js'; ?>"></script>
		<script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.ui.position.js'; ?>"></script>
		<?php /*<script type="text/javascript" charset="utf-8">
			
			$(function() {
		var availableTags = [
		 <?php $users = ModelPM::newInstance()->getUsers();  
		 $uCount = count($users);?>
       <?php foreach($users as $user) { ?>
         { label: "<?php echo $user['s_name']; ?>", value: "<?php echo $user['s_name']; ?>" },
       <?php } ?>
       { label: "<?php echo pmAdmin(); ?>", value: "<?php echo pmAdmin(); ?>" }
		];
		$( "#pmNames" ).autocomplete({
			source: availableTags,
			minLength: 2
		});
	});
	</script> */?>
	<?php /*
	<script type="text/javascript">  
    $(document).ready(function(){
    $("#newMessage-form").submit(function(){
        $.post(
            "<?php echo osc_ajax_plugin_url("osclass_pm/user-proc.php");?>",
            $("#newMessage-form").serialize(),
            function(data){
                if (data.success){
                    $("span#promo-message").css({"color":"green"} );
                    $("span#promo-message").css({"font-size":"20px"} );
                }
                else{
                    $("span#promo-message").css({"color":"red"});
                    $("span#promo-message").css({"font-size":"20px"} );
                }
                $("span#promo-message").html(data.message);
            },
            "json"
        );
    });
});
    </script>
    */ ?>
       <?php
       }
       if(osclass_pm_is_pub_profile() && osc_is_web_user_logged_in()) {
          $userId = Params::getParam('id');
          $user = User::newInstance()->findByPrimaryKey($userId);
          ?>
          <script type="text/javascript" >
            $(document).ready(function(){
               $('#user_data').append("<li><a href=\"<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-send.php&userId=' . $userId . '&mType=new'; ?>\"><?php echo __('Send PM to ','osclass_pm') . $user['s_name']; ?></a></li>");
            });
          </script>
          <?php
       } else {
          $userId = Params::getParam('id');
          $user = User::newInstance()->findByPrimaryKey($userId);
          ?>
          <script type="text/javascript" >
            $(document).ready(function(){
               $('#user_data').append("<li><a href=\"<?php echo osc_user_login_url() . '&http_referer=' . osc_base_url(true) . '?page=custom&file=osclass_pm/user-send.php&userId=' . $userId . '&mType=new'; ?>\"><?php echo __('Login to contact seller.','osclass_pm'); ?></a></li>");
            });
          </script>
          <?php
       }
       
       if(osc_is_ad_page() && osc_is_web_user_logged_in() && osc_item_user_id() != ''){
          $user = User::newInstance()->findByPrimaryKey(osc_item_user_id());
          ?>
          <script type="text/javascript" >
            $(document).ready(function(){
               $('p.contact_button').append("<strong class=\"share\"><a href=\"<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-send.php&userId=' . osc_item_user_id() . '&itemId=' . osc_item_id() . '&mType=new'; ?>\"><?php echo __('Send PM to ','osclass_pm') . $user['s_name']; ?></a></strong>");        
            });
          </script>
          <?php
       } elseif(osc_is_ad_page() && !osc_is_web_user_logged_in()) {
          $user = User::newInstance()->findByPrimaryKey(osc_item_user_id());
          ?>
          <script type="text/javascript" >
            $(document).ready(function(){
               $('div#description p.contact_button').append("<strong class=\"share\"><a href=\"<?php echo osc_user_login_url() . '&http_referer=' . osc_base_url(true) . '?page=custom&file=osclass_pm/user-send.php&userId=' . osc_item_user_id() . '&itemId=' . osc_item_id() . '&mType=new'; ?>\"><?php echo __('Login to contact seller.','osclass_pm'); ?></a></strong>");
            });
          </script>
          <?php
       }
    }
      
    function osclass_pm_user_menu() {      
       $newPMs = ModelPM::newInstance()->getRecipientMessages(osc_logged_user_id(), 1, 1, 'pm_id', 'DESC');
       $newPMdrafts = ModelPM::newInstance()->getDrafts(osc_logged_user_id(), 'pm_id', 'DESC');       
       $countPMs = count($newPMs);
       $countPMdrafts = count($newPMdrafts);
        
       echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-inbox.php') . '" >' . __('Inbox', 'osclass_pm') . ' (' . $countPMs . ')</a></li>';
       if(pmDrafts()){
         echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-drafts.php') . '" >' . __('Drafts', 'osclass_pm') . ' (' . $countPMdrafts . ')</a></li>';
       }
       if(pmSent()) {
         echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-outbox.php') . '" >' . __('Outbox', 'osclass_pm') . '</a></li>' ;
       }
       echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-pm-settings.php') . '" >' . __('PM Settings', 'osclass_pm') . '</a></li>' ;
    }
    
// End user side related.

// This is the email section.

   

// End email section.

// Everything below here is admin side related.

    function osclass_pm_admin_footer() {
       ?>
              <link rel="stylesheet" type="text/css" href="<?php echo osc_base_url() .'oc-content/plugins/osclass_pm/css/style.css'; ?>" />
       <link rel="stylesheet" type="text/css" href="<?php echo osc_base_url() .'oc-content/plugins/osclass_pm/css/pmTables.css'; ?>" />
       <script type="text/javascript" >
         $(document).ready(function(){
            /*$('#datatables_list').find('#datatables_quick_edit').addClass('dt');
            
            //$('#datatables_list tbody tr').each(function() {
			      //var thisTr = $('#datatables_list tbody tr').parent();
               //var thirdTDText = $('td:nth-child(3)').text();
               //$(thisTr).append(thirdTDText);
               //alert(thirdTDText);
               $('td:nth-child(3)').each(function () {
                  //$('#datatables_list tbody tr').append($(this).text() + ' ');
                  $('.dt').prepend("<a href=\"<?php echo osc_admin_base_url(true) . '?page=custom&file=osclass_pm/admin-send.php&userId=' . osc_item_user_id() . '&mType=new'; ?>\"><?php echo __('Send PM','osclass_pm'); ?></a> | " + $(this).text());
               });
		      //}); */
         });
       </script> 
        <script type='text/javascript' src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.dataTables.min.js'; ?>"></script>
       <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {			   
				$('#datatables_pm').dataTable( {
					"aaSorting": [[ 1, "desc" ]],
					"bStateSave": true,
					"sPaginationType": "full_numbers",
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }]
				} );
				
				$('#datatables_pm_outbox').dataTable( {
					"aaSorting": [[ 1, "desc" ]],
					"bStateSave": true,
					"sPaginationType": "full_numbers",
					"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }]
				} );
			
			
			$('#checkAll').change(function() {
            $(".delChecks").attr("checked", this.checked);
         });
         
         $(".delChecks").change(function() {
            $("#checkAll").attr("checked", $(".delChecks:checked").length == $(".delChecks").length);

         });
         
			
			} );
		</script>
       <?php
    }
    
    function osclass_pm_config() {
       osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php') ;
    }
    
    function osclass_pm_admin_menu() {
       $newPMs = ModelPM::newInstance()->getRecipientMessages(0, 1, 1, 'pm_id', 'DESC');
       $newPMdrafts = ModelPM::newInstance()->getDrafts(0, 'pm_id', 'DESC');       
       $countPMs = count($newPMs);
       $countPMdrafts = count($newPMdrafts);
       
       if( OSCLASS_VERSION < '2.4.0') {
           echo '<h3><a href="#">' . pmAdmin() . __('\'s PM Box','osclass_pm') .  ' (' . $countPMs . ' ' . __('New','osclass_pm') .')</a></h3><ul>';
   	    	 	 
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/admin-inbox.php') . '" > &raquo; '. __('Inbox', 'osclass_pm') . ' (' . $countPMs . ')</a></li>';
           if(pmDrafts()){
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin-drafts.php') . '" >' . __('Drafts', 'osclass_pm') . ' (' . $countPMdrafts . ')</a></li>';
           }
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/admin-outbox.php') . '" >&raquo; ' . __('Outbox', 'osclass_pm') . '</a></li>';
           echo '</ul>';
           echo '<h3><a href="#">' . __('OSClass PM Settings', 'osclass_pm') . '</a></h3><ul>';
   	    	 	 
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/admin.php') . '" > &raquo; '. __('Configure', 'osclass_pm') . '</a></li>' .
           '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'osclass_pm') . '</a></li>';
           echo '</ul>';
           
        } else {
           
           echo '<li id="admin_pm">';
           echo '<h3><a href="#" class="pm_admin">' . pmAdmin() . __('\'s PM Box','osclass_pm') .  ' (' . $countPMs . ' ' . __('New','osclass_pm') .')</a></h3><ul>';
   	    	 	 
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/admin-inbox.php') . '" > &raquo; '. __('Inbox', 'osclass_pm') . ' (' . $countPMs . ')</a></li>';
           if(pmDrafts()){
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin-drafts.php') . '" >' . __('Drafts', 'osclass_pm') . ' (' . $countPMdrafts . ')</a></li>';
           }
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/admin-outbox.php') . '" >&raquo; ' . __('Outbox', 'osclass_pm') . '</a></li>';
           echo '</ul>';
           echo '</li>';
           echo '<li id="pm_settings">';
           echo '<h3><a href="#" class="settings_pm">' . __('OSClass PM Settings', 'osclass_pm') . '</a></h3><ul>';
   	    	 	 
           echo '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/admin.php') . '" > &raquo; '. __('Configure', 'osclass_pm') . '</a></li>' .
           '<li class="" ><a href="' . osc_admin_render_plugin_url('osclass_pm/help.php') . '" >&raquo; ' . __('F.A.Q. / Help', 'osclass_pm') . '</a></li>';
           echo '</ul>';
           echo '</li>';
        }
    }
    
// End admin side related. 

    include('email-temps.php');
    
    switch(deletePM()) {
       case 1:
         $cron = 'hourly';
       break;
       case 2:
         $cron = 'daily';
       break;
       case 3: 
         $cron = 'weekly';
       break;
       default:
         $cron = 'weekly';
       break;
    }
    
    function osclass_pm_cron() {
       ModelPM::newInstance()->deleteMessages();
    }
    
    function osclass_pm_supertoolbar() {
       if( !osc_is_web_user_logged_in() ) {
            return false;
        }
        
        /*if( Rewrite::newInstance()->get_location() != 'item' ) {
            return false;
        }*/
        
        //if( osc_item_user_id() != osc_logged_user_id() ) {
          //  return false;
        //}
        
        $toolbar = SuperToolBar::newInstance();
               
        $newPMs = ModelPM::newInstance()->getRecipientMessages(osc_logged_user_id(), 1, 1, 'pm_id', 'DESC');
        $countPMs = count($newPMs);
        
        
        $pm_url = osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-inbox.php');

        $totalNew = '';
                
        if($countPMs > 0){
           $totalNew = '(' . $countPMs . ')';
        }
        $toolbar->addOption('<a href="' . $pm_url . '" />' . __('Inbox', 'osclass_pm') . ' ' . $totalNew . '</a>');                                                       
    }
    
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'osclass_pm_install') ;
    osc_add_hook(__FILE__ . "_configure", 'osclass_pm_config');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'osclass_pm_uninstall') ;
    
    osc_add_hook('header', 'osclass_pm_header');
    if(osclass_is_inbox_page() || osclass_is_outbox_page() || osclass_is_messages_page() || osclass_is_reply_page() ) {
      osc_add_hook('admin_footer','osclass_pm_admin_footer');
    }
    osc_add_hook('user_menu', 'osclass_pm_user_menu', 1);
    osc_add_hook('admin_menu','osclass_pm_admin_menu', 1);
    osc_add_hook('before_html','osclass_pm_before_html');
    osc_add_hook('cron_' . $cron,'osclass_pm_cron');
    
    // Add hook to supertoolbar
    osc_add_hook('supertoolbar_hook' , 'osclass_pm_supertoolbar');
    
    
?>