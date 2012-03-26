<?php
/**
     * Send email to user when they get a new PM
     * 
     * @param integer $item
     * @param integer $offer_value 
     *
     * @dynamic tags
     *
     * '{RECIP_NAME}', '{SENDER_NAME}', '{WEB_URL}', '{WEB_TITLE}', '{PM_URL}', '{PM_SUBJECT}', '{PM_MESSAGE}'
     */
     
    function new_pm_email($pm_info) {
       
        $mPages = new Page() ;
        $aPage = $mPages->findByInternalName('email_PM_alert') ;
        $locale = osc_current_user_locale() ;
        $content = array();
        if(isset($aPage['locale'][$locale]['s_title'])) {
            $content = $aPage['locale'][$locale];
        } else {
            $content = current($aPage['locale']);
        }
        
        if($pm_info['sender_id'] == 0) {
           $sender_name = pmAdmin();
        } else {
           $pm_senderData = User::newInstance()->findByPrimaryKey($pm_info['sender_id']);
           $sender_name   = $pm_senderData['s_name'];
        }
        
        if($pm_info['recip_id'] == 0) {        
           $pm_url    = osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=osclass_pm/admin-send.php?userId=' . $pm_info['sender_id'] . '&mType=adminQuote&messId=' . $pm_info['pm_id'];
           $pm_name   = pmAdmin();
           $pm_recipData['s_email'] = osc_contact_email();
        } else {
           $pm_url    = osc_base_url(true) . '?page=custom&file=osclass_pm/user-send.php?userId=' . $pm_info['sender_id'] . '&mType=quote&messId=' . $pm_info['pm_id'];
           $pm_recipData   = User::newInstance()->findByPrimaryKey($pm_info['recip_id']);
           $pm_name   = $pm_recipData['s_name'];
        }
        $pm_url    = '<a href="' . $pm_url . '" >' . $pm_url . '</a>';

        $words   = array();
        $words[] = array('{RECIP_NAME}', '{SENDER_NAME}', '{WEB_URL}', '{WEB_TITLE}', '{PM_URL}', '{PM_SUBJECT}', '{PM_MESSAGE}', '[quote]','[/quote]', '[quoteAuthor]','[/quoteAuthor]');
        $words[] = array($pm_name, $sender_name, osc_base_url(), osc_page_title(), $pm_url, $pm_info['pm_subject'], nl2br($pm_info['pm_message']), '<div class="messQuote">','</div>', '<div class="quoteAuthor">','</div>') ;

        $title = osc_mailBeauty($content['s_title'], $words) ;
        $body  = osc_mailBeauty($content['s_text'], $words) ;

        $emailParams =  array('subject'  => $title
                             ,'to'       => $pm_recipData['s_email']
                             ,'to_name'  => $pm_name
                             ,'body'     => $body
                             ,'alt_body' => $body);

        osc_sendMail($emailParams);
    }
?>