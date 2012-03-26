<?php
    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    /**
     * Model database for osclass PM tables
     * 
     * @package OSClass
     * @subpackage Model
     * @1.0
     */
    class ModelPM extends DAO
    {
        /**
         * It references to self object: ModelPM.
         * It is used as a singleton
         * 
         * @access private
         * @1.0
         * @var ModelPM
         */
        private static $instance ;

        /**
         * It creates a new ModelPM object class ir if it has been created
         * before, it return the previous object
         * 
         * @access public
         * @1.0
         * @return ModelPM
         */
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        /**
         * Construct
         */
        function __construct()
        {
            parent::__construct();
        }
        
        /**
         * Return table name pm_messages
         * @return string
         */
        public function getTable_pmMessages()
        {
            return DB_TABLE_PREFIX.'t_pm_messages';
        }
        
        /**
         * Return table name pm_drafts
         * @return string
         */
        public function getTable_pmDrafts()
        {
            return DB_TABLE_PREFIX.'t_pm_drafts';
        }
        
        /**
         * Return table name pm_settings
         * @return string
         */
        public function getTable_pmSettings()
        {
            return DB_TABLE_PREFIX.'t_pm_settings';
        }
        
        /**
         * Return table name t_users
         * @return string
         */
        public function getTable_users()
        {
            return DB_TABLE_PREFIX.'t_user';
        }
              
        /**
         * Import sql file
         * @param type $file 
         */
        public function import($file)
        {
            $path = osc_plugin_resource($file) ;
            $sql = file_get_contents($path);

            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error importSQL::ModelPM<br>".$file ) ;
            }
        }
                
        /**
         * Remove data and tables related to the plugin.
         */
        public function uninstall()
        {
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_pmMessages()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_pmDrafts()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_pmSettings()) ) ;  
        }
        
        /**
         * Get users
         *
         * @return array 
         */
        public function getUsers()
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_users());
            $this->dao->where('b_enabled', 1);
            $this->dao->where('b_active', 1);

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Get Sender Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function getSenderMessages($sendId, $del=NULL, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('sender_id', $sendId);
            if($del == 1) {
               $this->dao->where('senderDelete', 0);
            }
            
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Get by primary key
         *
         * @param int $pm_id
         * @return array 
         */
        public function getByPrimaryKey($pm_id, $del=NULL, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('pm_id', $pm_id);
            if($del == 1) {
               $this->dao->where('senderDelete', 0);
               $this->dao->where('recipDelete', 0);
            }
            
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get Recipient Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function getRecipientMessages($recipId, $del=NULL, $new=NULL, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('recip_id', $recipId);
            if($del == 1) {
               $this->dao->where('recipDelete', 0);
            }
            
            if($new == 1) {
               $this->dao->where('recipNew', 1);
            }
            
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Get Recipient Message
         *
         * @param int $itemId
         * @return array 
         */
        public function getRecipientMessage($recipId, $del=NULL, $new=NULL, $pm_id)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('recip_id', $recipId);
            if($del == 1) {
               $this->dao->where('recipDelete', 0);
            }
            
            if($new == 1) {
               $this->dao->where('recipNew', 1);
            }
            
            $this->dao->where('pm_id', $pm_id);

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * count Recipient Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function countRecipientMessages($recipId, $del=NULL)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('recip_id', $recipId);
            if($del == 1) {
               $this->dao->where('recipDelete', 0);
            }
            

            $result = $this->dao->get();
            $aux = $result->result();
            $aux = count($aux);
            return $aux;
        }
        
        /**
         * Get Recipient Message
         *
         * @param int $itemId
         * @return array 
         */
        public function getSenderMessage($senderId, $del=NULL, $pm_id)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('sender_id', $senderId);
            if($del == 1) {
               $this->dao->where('senderDelete', 0);
            }
            
            $this->dao->where('pm_id', $pm_id);

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get Draft Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function getDrafts($sendId, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmDrafts());
            $this->dao->where('sender_id', $sendId);
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Update recip delete by id
         * 
         * @param int $pm_id 
         */
        public function updateMessagesRecipDelete($pm_id)
        {
            $this->_update( $this->getTable_pmMessages(), array('recipDelete' => 1), array('pm_id' => $pm_id)) ;
        }
        
        /**
         * Update sender delete by id
         * 
         * @param int $pm_id 
         */
        public function updateMessagesSenderDelete($pm_id)
        {
            $this->_update( $this->getTable_pmMessages(), array('senderDelete' => 1), array('pm_id' => $pm_id)) ;
        }
        
        /**
         * Update message as read
         * 
         * @param int $pm_id 
         */
        public function updateMessageAsRead($pm_id)
        {
            $this->_update( $this->getTable_pmMessages(), array('recipNew' => 0), array('pm_id' => $pm_id)) ;
        }
        
        /**
         * Get user pm settings
         *
         * @param int $user_id
         */
        public function getUserPmSettings($user_id)
        {
           $this->dao->select();
           $this->dao->from( $this->getTable_pmSettings());
           $this->dao->where('fk_i_user_id', $user_id);

           $result = $this->dao->get();
           return $result->row();
        }
        
        /**
         * update user pm settings
         *
         * @param int $user_id, $emailAlert, $flashAlert, $saveSent
         */
        public function updatePmSettings($user_id, $emailAlert, $flashAlert, $saveSent)
        {
            $this->_update( $this->getTable_pmSettings(), array('send_email' => $emailAlert, 'flash_alert' => $flashAlert, 'save_sent' => $saveSent), array('fk_i_user_id' => $user_id)) ;
        }
        
        /**
         * Insert a Message
         *
         * @param int $sender_id, $recip_id, $senderDelete
         * @param string $pm_subject, pm_message
         */
        public function insertMessage( $sender_id, $recip_id, $pm_subject, $pm_message, $senderDelete = 1)
        {
            $this->dao->insert($this->getTable_pmMessages(), array('sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $pm_subject, 'pm_message' => $pm_message, 'senderDelete' => $senderDelete)) ;
        }
        
        
        /**
         * Insert all users into pmsettings
         *
         * 
         */
        public function insertUsersPmSettings()
        {
            $userIds = $this->getUsers();
            foreach($userIds as $user_id) {
               $this->dao->insert($this->getTable_pmSettings(), array('fk_i_user_id' => $user_id['pk_i_id'], 'send_email' => 1, 'flash_alert' => '0', 'save_sent' => '0')) ;
            }
        }
        
        /** 
         * Adds email templstes.
         *
         *
         */
        public function insertEmailTemplates() {
            //used for email template
            $this->dao->insert(DB_TABLE_PREFIX.'t_pages', array('s_internal_name' => 'email_PM_alert', 'b_indelible' => 1, 'dt_pub_date' => date('Ydm')));
            
            $this->dao->select();
            $this->dao->from( DB_TABLE_PREFIX.'t_pages' );
            $this->dao->where('s_internal_name', 'email_PM_alert');

            $result = $this->dao->get();
            $pageInfo = $result->row();
            
            foreach(osc_listLanguageCodes() as $locales) {
               $this->dao->insert(DB_TABLE_PREFIX.'t_pages_description', array('fk_i_pages_id' => $pageInfo['pk_i_id'], 'fk_c_locale_code' => $locales, 's_title' => '{WEB_TITLE} - You just received a PM from {SENDER_NAME}.', 's_text' => "<p>Hi {RECIP_NAME}!</p>\r\n<p> </p>\r\n<p>{SENDER_NAME} has just sent you a PM.</p>\r\n<p>The message they sent you was:</p>\r\n<p>{PM_SUBJECT}</p>\r\n<p>{PM_MESSAGE}</P>\r\n<p>Reply to the message here: {PM_URL}</p>\r\n<p>This is an automatic email, Please do not respond to this email.</p>\r\n<p> </p>\r\n<p>Thanks</p>\r\n<p>{WEB_TITLE}</p>"));
            }
        }
        
        /**
         * Remove Email Templates
         *
         *
         */
        public function removeEmailTemplates() {
            $this->dao->select();
            $this->dao->from( DB_TABLE_PREFIX.'t_pages' );
            $this->dao->where('s_internal_name', 'email_PM_alert');

            $result = $this->dao->get();
            $pageInfo = $result->row();
            
            $this->dao->delete( DB_TABLE_PREFIX.'t_pages_description', array('fk_i_pages_id' => $pageInfo['pk_i_id']));
            $this->dao->delete( DB_TABLE_PREFIX.'t_pages', array('pk_i_id' => $pageInfo['pk_i_id']));
        }
        
        /**
         * Cron remove sender and recip messages if both are deleted.
         *
         *
         */
        public function deleteMessages() 
        {
            $this->dao->delete( $this->getTable_pmMessages(), array('senderDelete' => 1, 'recipDelete' => 1));
        }
               
        /**
         * Return last id inserted into cars vehicle type table
         * 
         * @return int 
         */
        public function getLastMessageId()
        {
            $this->dao->select('pm_id');
            $this->dao->from($this->getTable_pmMessages()) ;
            $this->dao->orderBy('pm_id', 'DESC') ;
            $this->dao->limit(1) ;
            
            $result = $this->dao->get() ;
            $aux = $result->row();
            return $aux['pm_id']; 
        }
        
        // update
        function _update($table, $values, $where)
        {
            $this->dao->from($table) ;
            $this->dao->set($values) ;
            $this->dao->where($where) ;
            return $this->dao->update() ;
        }
    }
?>
