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
         * Get all car makes 
         *
         * @return array 
         */
        public function getCarMakes()
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_CarMake() ) ;
            $this->dao->orderBy('s_name', 'ASC') ;
            
            $results = $this->dao->get();
            return $results->result();
        }
        
        /**
         * Get Make attributes given a make id
         *
         * @param int $id 
         * @return array
         */
        public function getCarMakeById( $id )
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_CarMake());
            $this->dao->where('pk_i_id', $id );
            
            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get all car models given a make id
         *
         * @param int $makeId
         * @return array
         */
        public function getCarModels( $makeId )
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_CarModel() ) ;
            $this->dao->where('fk_i_make_id', $makeId) ;
            $this->dao->orderBy('s_name', 'ASC') ;
            
            $results = $this->dao->get();
            return $results->result();
        }
        
        /**
         * Get Model attributes given a model id
         *
         * @param int $id 
         * @return array
         */
        public function getCarModelById( $id )
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_CarModel());
            $this->dao->where('pk_i_id', $id );
            
            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get all vehicle types, if locale is set, results are filtered by given locale
         *
         * @param string $locale
         * @return array
         */
        public function getVehiclesType( $locale = null )
        {
            $this->dao->select() ;
            $this->dao->from( $this->getTable_CarVehicleType() ) ;
            if(!is_null($locale) ){
                $this->dao->where('fk_c_locale_code', $locale) ;
            }
            
            $results = $this->dao->get();
            return $results->result();
        }
        
        /**
         * Get Vehicle type attributes given a Vehicle type id
         *
         * @param int $id 
         * @return array
         */
        public function getVehicleTypeById( $id )
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_CarVehicleType());
            $this->dao->where('pk_i_id', $id );
            
            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Return last id inserted into cars vehicle type table
         * 
         * @return int 
         */
        public function getLastVehicleTypeId()
        {
            $this->dao->select('pk_i_id');
            $this->dao->from($this->getTable_CarVehicleType()) ;
            $this->dao->orderBy('pk_i_id', 'DESC') ;
            $this->dao->limit(1) ;
            
            $result = $this->dao->get() ;
            $aux = $result->row();
            return $aux['pk_i_id']; 
        }
        
        /**
         * Insert Car attributes 
         * 
         * @param array $arrayInsert 
         */
        public function insertCarAttr( $arrayInsert, $itemId )
        {
            $aSet = $this->toArrayInsert($arrayInsert);
            $aSet['fk_i_item_id'] = $itemId;
            
            $this->dao->insert( $this->getTable_CarAttr(), $aSet) ;
        }
        
        /**
         * Insert a Make
         *
         * @param string $name 
         */
        public function insertMake( $name )
        {
            $this->dao->insert($this->getTable_CarMake(), array('s_name' => $name)) ;
        }
        
        /**
         * Insert a Model given Make id 
         *
         * @param int $makeId
         * @param string $name 
         */
        public function insertModel( $makeId, $name )
        {
            $aSet = array(
                'fk_i_make_id'  => $makeId,
                's_name'        => $name
            );
            $this->dao->insert($this->getTable_CarModel(), $aSet );
        }
        
        /**
         * Insert a Vehicle type
         *
         * @param int $typeId
         * @param string $locale
         * @param string $name 
         */
        public function insertVehicleType($typeId, $locale, $name)
        {
            $aSet = array(
                'pk_i_id'           => $typeId,
                'fk_c_locale_code'  => $locale,
                's_name'            => $name
            );
            $this->dao->insert($this->getTable_CarVehicleType(), $aSet) ;
        }
        
        /**
         * Update Car attributes given a item id
         * 
         * @param type $arrayUpdate 
         */
        public function updateCarAttr( $arrayUpdate, $itemId )
        {
            $aUpdate = $this->toArrayInsert($arrayUpdate) ;
            $this->_update( $this->getTable_CarAttr(), $aUpdate, array('fk_i_item_id' => $itemId));
        }
        
        /**
         * Update Make attributes
         *
         * @param int $makeId
         * @param string $name 
         */
        public function updateMake( $makeId, $name )
        {
            $this->_update( $this->getTable_CarMake(), array('s_name' => $name), array('pk_i_id' => $makeId)) ;
        }
        
        /**
         * Update Model attributes
         *
         * @param int $modelId
         * @param string $makeId
         * @param string $name 
         */
        public function updateModel( $modelId, $makeId, $name )
        {
            $this->_update($this->getTable_CarModel(), array('s_name' => $name), array('pk_i_id' => $modelId, 'fk_i_make_id' => $makeId));
        }
        
        /**
         * Update Vehicle type attributes
         *
         * @param int $typeId
         * @param string $locale
         * @param string $name 
         */
        public function updateVehicleType($typeId, $locale, $name)
        {
            $aWhere = array(
                'pk_i_id'           => $typeId, 
                'fk_c_locale_code'  => $locale
            );
            $aSet = array(
                's_name'            => $name
            );
            
            $this->_update($this->getTable_CarVehicleType(), $aSet, $aWhere);
        }
        
        /**
         * Delete Car attributes given a item id
         * 
         * @param int $itemId 
         */
        public function deleteCarAttr( $itemId )
        {
            $this->dao->delete( $this->getTable_CarAttr(), array('fk_i_item_id' => $itemId));
        }
        
        /**
         * Delete a Make given a id
         * 
         * @param int $makeId 
         */
        public function deleteMake( $makeId )
        {
            $this->dao->delete( $this->getTable_CarModel(), array('fk_i_make_id' => $makeId)) ;
            $this->dao->delete( $this->getTable_CarMake() , array('pk_i_id' => $makeId)) ;
        }
        
        /**
         * Delete a Model given a id
         * 
         * @param int $modelId 
         */
        public function deleteModel( $modelId )
        {
            $this->dao->delete( $this->getTable_CarModel(), array('pk_i_id' => $modelId) ) ;
        }
        
        /**
         * Delete a Vehicle type given a id
         *
         * @param int $typeId 
         */
        public function deleteVehicleType( $typeId )
        {
            $this->dao->delete($this->getTable_CarVehicleType(), array('pk_i_id' => $typeId));
        }
        
        /**
         * Delete vehicle type given a locale.
         * 
         * @param type $locale 
         */
        public function deleteLocale( $locale )
        {
            $this->dao->query( "DELETE FROM ".$this->getTable_CarVehicleType()." WHERE fk_c_locale_code = '" . $locale . "'") ;
        }
        
        /**
         * Return an array, associates field name in database with the value
         * @param type $arrayInsert
         * @return type 
         */
        private function toArrayInsert( $arrayInsert )
        {
            $array = array(
                'i_year'            => $arrayInsert['year'],
                'i_doors'           => $arrayInsert['doors'],
                'i_seats'           => $arrayInsert['seats'],
                'i_mileage'         => $arrayInsert['mileage'],
                'i_engine_size'     => $arrayInsert['engine_size'],
                'i_num_airbags'     => $arrayInsert['num_airbags'],
                'e_transmission'    => $arrayInsert['transmission'],
                'e_fuel'            => $arrayInsert['fuel'],
                'e_seller'          => $arrayInsert['seller'],
                'b_warranty'        => $arrayInsert['warranty'],
                'b_new'             => $arrayInsert['new'],
                'i_power'           => $arrayInsert['power'],
                'e_power_unit'      => $arrayInsert['power_unit'],
                'i_gears'           => $arrayInsert['gears'],
                'fk_i_make_id'      => $arrayInsert['make'],
                'fk_i_model_id'     => $arrayInsert['model'],
                'fk_vehicle_type_id'=> $arrayInsert['type']
            );
            return $array;
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