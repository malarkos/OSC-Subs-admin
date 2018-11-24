<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_lockers
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorld Model
 *
 * @since  0.0.1
 */
class SubsModelFinanceEntry extends JModelAdmin
{
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'FinanceEntry', $prefix = 'SubsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	
	public function getItem($pk = null) {
	    $item = parent::getItem($pk);
	    
	    $jinput = JFactory::getApplication ()->input;
	    $memid = $jinput->get ( 'memid', 0 );
	    
	    //JFactory::getApplication()->enqueueMessage('in GetITem MemID = '.$memid.":");
	    // Your code
	    // Example
	    //$item->newValue = $newValueFromOtherTable;
	    
	    return $item;
	}
	
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_subs.financeentry',
			'financeentry',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);
 
		if (empty($form))
		{
			return false;
		}
 
		return $form;
	}
 
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_subs.edit.financeentry.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
		//JFactory::getApplication()->enqueueMessage('in LoadFormData MemID = '.$memid.":");
		
		if ($memid > 0) {
    		require_once JPATH_COMPONENT . '/helpers/subs.php';
    		$subsyear = SubsHelper::returnSubsYear();
    		//JFactory::getApplication()->enqueueMessage('in LoadFormData Subs year = '.$subsyear.":");
    		
    		$data->MemberID = $memid;
    		$data->CreditDebit = "C";
    		$data->FinanceYear = (int)$subsyear;  // TODO work out why default not working.
    		$data->FinanceType = "s";
    		$data->MemberType = "m";
    		$data->Description = $subsyear . " Subscriptions payment.";
		}
		$session = JFactory::getSession();
		$session->set( 'memid', $memid );
		
		return $data;
	}
	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
	    
	    //$jinput = JFactory::getApplication ()->input;
	    //$memid = $jinput->get ( 'memid', 0 );
	    
	    //JFactory::getApplication()->enqueueMessage('in preprocessform MemID = '.$memid.":");
	    
	    //$form->setField('MemberID', $memid, 'true'); // preset memberID
	    //$form->setValue('MemberID', null , $memid);
	    
	    parent::preprocessForm($form, $data, $group);
	}
	
	protected function prepareTable($table)
	{
		$dt = new DateTime();
		$dt->format('Y-m-d H:i:s');
		$table->lastmodified = $dt;  // Set last modified time
		$table->AmountNoGST = $table->Amount * 10 /11; // set no GST amount
		$table->GST = $table->Amount / 11; // set GST
		// values need to be negative if a Debit
		if ($table->CreditDebit === "D") {
			$table->Amount = $table->Amount * -1;
			$table->AmountNoGST = $table->AmountNoGST * -1;
			$table->GST = $table->GST * -1;
		}
		
		//$table->FinanceID = $table->id; // TODO check what happens for a new entry?
		
		// save Member id to session variable
		$session = JFactory::getSession();
		$session->set( 'memid', $table->MemberID );
	}
	
	protected function postSaveHook($model, $validData) {
		$item = $model->getItem();
		$itemid = $item->get('FinanceID');
		
		//TODO update FinanceID after save
	}
	

	
}