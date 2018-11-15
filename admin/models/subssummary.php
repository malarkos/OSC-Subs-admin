<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorldList Model
 *
 * @since  0.0.1
 */
class SubsModelSubsSummary extends JModelList
{
    /**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	
        
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
 
		// Create the base select statement.
		$query->select('*');
        $query->from('oscsubsreferencedates');
        
		return $query;
	}
	
	public function getSubsYear()
	{
	    // Function to return current subs year
	    require_once JPATH_COMPONENT . '/helpers/subs.php';
	    
	    $subsyear = SubsHelper::returnSubsYear();
	    
	    return $subsyear;
	}
	
	public function AddAllSubs()
	{
	    
	    
	    // Get subs year
	    require_once JPATH_COMPONENT . '/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    $substartdate = SubsHelper::returnSubsStartDate($subsyear);
	    
	    // check if already added
	    $subsadded = SubsHelper::checkIfSubsAdded($subsyear);
	    
	    if ($subsadded == 'n') 
	    {
    	    // Function to add all subs
    	    $app = JFactory::getApplication ();
    	    $app->enqueueMessage('In Add All Subs');
    	    
    	    // get database object
    	    $db = JFactory::getDbo ();
    	    $query = $db->getQuery ( true );
    	    
    	    // global variables
    	    $ngraduatesubs = 0;
    	    $nstudentsubs = 0;
    	    $nspousesubs = 0;
    	    $nchildsubs = 0;
    	    $nbuddysubs = 0;
    	    $nlockersubs = 0;
    	    $ntotalsubs = 0;
    	    $financetype = 's';
    	    
    	    // If Subs already added, create error and return
    	    
    	    // Add subs
    	    // Cycle through each Member
    	       
    	    $query->select ( '*' );
    	    $query->from ( 'members' );
    	    $db->setQuery ( $query );
    	    $db->execute ();
    	    
    	    $num_rows = $db->getNumRows ();
    	    $members = $db->loadObjectList ();
    	    for($i = 0; $i <25;  $i++) { //$num_rows;
    	        $memfirstname = $members [$i]->MemberFirstname;
    	        $memid = $members [$i]->MemberID;
    	        $memsurname = $members [$i]->MemberSurname;
    	        $memtype = $members [$i]->MemberType;
    	        $memloa = $members [$i]->MemberLeaveofAbsence;
    	        
    	        
    	        // add Member sub
    	        // Add Family member sub & set subs paid flag to no in Family members
    	        // Add Locker sub
    	        // Set subs paid flag to No unless new balance is positive - i.e. subs paid out of existing funds
    	        if ($memloa == "No") { // Only look at current members
    	            if ($memtype == "Graduate" || $memtype == "Student" || $memtype == "Life" || $memtype == "Hon Life") {
    	                   $app->enqueueMessage('Member:  '.$memid. ' '.$memfirstname . ' ' . $memsurname . ' '.$memtype. ' '.$memloa);
    	                   
    	                   // Update Grad sub count
    	                   $ngraduatesubs++;
    	                   $ntotalsubs++;
    	                   
    	                   // Add sub to Finance 
    	                   $today=time();
    	                   $transactiondate = date("Y-m-d",$today);
    	                   $creditdebit = "D";
    	                   $comment="";
    	                   $description = $memtype . ' Member subscription.';
    	                   if ($memtype == "Graduate" || $memtype == "Student" ) {
    	                       $amount = -1.0 * SubsHelper::returnSubrate($subsyear,$memtype); // Get sub rate for the year
    	                       SubsHelper::setCurrentSubsPaid($memid,"No");  // Reset current subs paid flag
    	                   }
    	                   else if ($memtype == "Life" || $memtype == "Hon Life")
    	                   {
    	                       $amount = 0;  // Life and Hon Life subs = 0
    	                       SubsHelper::setCurrentSubsPaid($memid,"Yes");  // Life and Hon Life members are paid by default
    	                   }
    	                   $amountnogst = (10*$amount)/11;
    	                   $gst = $amount/11;
    	                   
    	                   // Add finance entry
    	                   SubsHelper::addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear);
    	                  
    	                   
    	            }
    	        }
    	    }
	    
	    }
	    else 
	    {
	        JFactory::getApplication()->enqueueMessage('Error: Subs already added!', 'error');
	    }
	    //  Update flag to say subs have been run
	    return; 
	}
}