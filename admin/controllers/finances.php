<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_locker
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Finances Controller
 *
 * @since  0.0.1
 */
class SubsControllerFinances extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Finances', $prefix = 'SubsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
	public function csvReport() {
		
	}
	
	/*
	 * Function to "delete" entry by setting OldMember ID to MemberID and MemberID to 0.
	 */
	
	public function delete() {
	    $db = JFactory::getDbo ();
	    $cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	    //$row =& $this->getTable();
	    if (count( $cids )) {
	        foreach($cids as $cid) {
	            
	            $msg = "Removing this cid:".$cid;
	            
	            $application = JFactory::getApplication();
	            $application->enqueueMessage($msg);
	            
	            $query = $db->getQuery ( true );
	            $query->select ( 'MemberID' );
	            $query->from ( 'finances' );
	            $query->where ( 'FinanceID = ' . $cid );
	            
	            $db->setQuery ( $query );
	            
	            
	            try
	            {
	                $db->execute ();
	                $memberid = $db->loadResult ();
	            }
	            catch (Exception $e)
	            {
	                // Render the error message from the Exception object
	                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
	                return false;
	            }
	            // cid = rowid
	            // Load memberid
	            // set old memberid = member id
	            // set memberid = 0
	            $query = $db->getQuery ( true );
	            $fields = array('MemberID =  0',
	                
	                'OldMemberID = '. $memberid
	            );
	            $conditions = array('FinanceID = ' . $cid);
	            $query->update('finances');
	            $query->set($fields);
	            $query->where($conditions);
	            
	            $db->setQuery ( $query );
	            try
	            {
	                $db->execute ();
	                
	            }
	            catch (Exception $e)
	            {
	                // Render the error message from the Exception object
	                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
	                return false;
	            }
	            
	            
	            
	        }
	    }
	    $returnurl = 'index.php?option=com_subs&view=finances';
	    $this->setRedirect($returnurl);
	    return $return;
	}
}