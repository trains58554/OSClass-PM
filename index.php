<?php
/*
Plugin Name: Personal Messaging for OSClass
Plugin URI: 
Description: A Personal Messaging system for OSClass.
Version: 1.0
Author: JChapman
Author URI: 
Short Name: osc_pm

The plans of the diligent lead to profit as 
surely as haste leads to poverty. Proverbs 21:5
*/
require_once 'ModelPM.php';

// Install and uninstall functions.

    function osc_pm_install() {
       ModelPM::newInstance()->import('osclass_pm/struct.sql');
      
       osc_set_preference('sendEmail', '1', 'plugin-osc_pm', 'INTEGER');
       osc_set_preference('maxPMs', '100', 'plugin-osc_pm', 'INTEGER');
       osc_set_preference('pmBlocking', '1', 'plugin-osc_pm', 'INTEGER');
       osc_set_preference('pmDrafts', '1', 'plugin-osc_pm', 'INTEGER');
       osc_set_preference('pmSent', '1', 'plugin-osc_pm', 'INTEGER');
       osc_set_preference('pmAdmin', 'Admin', 'plugin-osc_pm', 'STRING');
    }
    
    function osc_pm_uninstall() {
       ModelPM::newInstance()->uninstall();
       
       osc_delete_preference('sendEmail', 'plugin-osc_pm');
       osc_delete_preference('maxPMs', 'plugin-osc_pm');
       osc_delete_preference('pmBlocking', 'plugin-osc_pm');
       osc_delete_preference('pmDrafts', 'plugin-osc_pm');
       osc_delete_preference('pmSent', 'plugin-osc_pm');
       osc_delete_preference('pmAdmin', 'plugin-osc_pm');
    }
    
// End install and uninstall functions  

// HELPER

    function sendEmail() {
        return(osc_get_preference('sendEmail', 'plugin-osc_pm')) ;
    }
    
    function maxPMs() {
       return(osc_get_preference('maxPMs','plugin-osc_pm'));
    }
    
    function pmBlocking() {
       return(osc_get_preference('pmBlocking','plugin-osc_pm'));
    }
    
    function pmDrafts() {
       return(osc_get_preference('pmDrafts','plugin-osc_pm'));
    }
    
    function pmSent() {
       return(osc_get_preference('pmSent','plugin-osc_pm'));
    }
    
    function pmAdmin() {
       return(osc_get_preference('pmAdmin','plugin-osc_pm'));
    }
    
    /**
     * Formats the time using the appropiate format.
     *
     * @param string $date
     */
    function osc_format_time($date) {
        return date(osc_time_format(), strtotime($date)) ;
    }
// End HELPERS

// Everything between this section is user side related.  
  
    function osc_pm_header() {
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
       <?php
    }
      
    function osc_pm_user_menu() {
       $conn = getConnection();       
       $newPMs = ModelPM::newInstance()->getRecipientMessages(osc_logged_user_id(), 1, 1, 'pm_id', 'DESC');
       $newPMdrafts = ModelPM::newInstance()->getDrafts(osc_logged_user_id(), 'pm_id', 'DESC');       
       $countPMs = count($newPMs);
       $countPMdrafts = count($newPMdrafts);
        
       echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-inbox.php') . '" >' . __('Inbox', 'osc_pm') . ' (' . $countPMs . ')</a></li>';
       if(pmDrafts()){
         echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-drafts.php') . '" >' . __('Drafts', 'osc_pm') . ' (' . $countPMdrafts . ')</a></li>';
       }
       if(pmSent()) {
         echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-outbox.php') . '" >' . __('Outbox', 'osc_pm') . '</a></li>' ;
       }
       echo '<li class="" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-pm-settings.php') . '" >' . __('PM Settings', 'osc_pm') . '</a></li>' ;
    }
    
// End user side related.

// Everything below here is admin side related.

    function osc_pm_config() {
       osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php') ;
    }
    
    function osc_pm_admin_menu() {
       
    }
    
// End admin side related. 

    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'osc_pm_install') ;
    osc_add_hook(__FILE__ . "_configure", 'osc_pm_config');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'osc_pm_uninstall') ;
    
    osc_add_hook('header', 'osc_pm_header');
    osc_add_hook('user_menu', 'osc_pm_user_menu', 1);
    osc_add_hook('admin_menu','osc_pm_admin_menu', 1);
    
    
?>