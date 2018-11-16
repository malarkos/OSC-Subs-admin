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
    	    // TODO - add Summer usage only check
    	    $ngraduatesubs = 0;
    	    $nstudentsubs = 0;
    	    $nlifehonlifesubs=0;
    	    $nspousesubs = 0;
    	    $nchildsubs = 0;
    	    $nbuddysubs = 0;
    	    $nlockersubs = 0;
    	    $nsummersubs = 0;
    	    $ntotalsubs = 0;
    	    $financetype = 's';
    	    
    	    // If Subs already added, create error and return
    	    
    	    // Add subs
    	    // Cycle through each Member
    	       
    	    $query->select ( '*' );
    	    $query->from ( 'members' );
    	    $db->setQuery ( $query );
    	    $db->execute ();
    	    
    	    $memnum_rows = $db->getNumRows ();
    	    $members = $db->loadObjectList ();
    	    for($i = 0; $i < $memnum_rows;  $i++) { //$num_rows;
    	        $memfirstname = $members [$i]->MemberFirstname;
    	        $memid = $members [$i]->MemberID;
    	        $memsurname = $members [$i]->MemberSurname;
    	        $memtype = $members [$i]->MemberType;
    	        $memloa = $members [$i]->MemberLeaveofAbsence;
    	        
    	        
    	        
    	        if ($memloa == "No") { // Only look at current members
    	            if ($memtype == "Graduate" || $memtype == "Student" || $memtype == "Life" || $memtype == "Hon Life") {
    	                   $app->enqueueMessage('Member:  '.$memid. ' '.$memfirstname . ' ' . $memsurname . ' '.$memtype. ' '.$memloa);
    	                   
    	                   // Add sub to Finance 
    	                   //$today=time();
    	                   //$transactiondate = date("Y-m-d",$today);
    	                   $creditdebit = "D";
    	                   $comment= $subsyear . ' Subscriptions.';
    	                   $description = $memtype . ' Member subscription.';
    	                   if ($memtype == "Graduate"  ) {
    	                       $ngraduatesubs++;
    	                       $amount = -1.0 * SubsHelper::returnSubrate($subsyear,$memtype); // Get sub rate for the year
    	                       SubsHelper::setCurrentSubsPaid($memid,"No","m");  // Reset current subs paid flag
    	                   }
    	                   else if ( $memtype == "Student" ) {
    	                       $nstudentsubs++;
    	                       $amount = -1.0 * SubsHelper::returnSubrate($subsyear,$memtype); // Get sub rate for the year
    	                       SubsHelper::setCurrentSubsPaid($memid,"No","m");  // Reset current subs paid flag
    	                   }
    	                   else if ($memtype == "Life" || $memtype == "Hon Life")
    	                   {
    	                       $nlifehonlifesubs++;
    	                       $amount = 0;  // Life and Hon Life subs = 0
    	                       SubsHelper::setCurrentSubsPaid($memid,"Yes","m");  // Life and Hon Life members are paid by default
    	                   }
    	                   $amountnogst = (10*$amount)/11;
    	                   $gst = $amount/11;
    	                   $membertype = "m";
    	                   // Add finance entry
    	                   SubsHelper::addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$memid);
    	                  
    	                   // Add Family member sub & set subs paid flag to no in Family members
    	                   $query = $db->getQuery ( true );
    	                   $query->select ( '*' );
    	                   $query->from ( 'familymembers' );
    	                   $query->where('MemberID = '.$memid);
    	                   $db->setQuery ( $query );
    	                   $db->execute ();
    	                   
    	                   $num_rows = $db->getNumRows ();
    	                   $familymembers = $db->loadObjectList ();
    	                   for($n=0;$n<$num_rows;$n++){
    	                       $fammemid = $familymembers[$n]->FamilyMemberID;
    	                       $firstname = $familymembers[$n]->FamilyMemberFirstname;
    	                       $surname = $familymembers[$n]->FamilyMemberSurname;
    	                       $fammemtype = $familymembers[$n]->FamilyMembershipType;
    	                       $comment= $subsyear . ' Subscriptions.';
    	                       $description = $fammemtype . ' Member subscription.';
    	                       $app->enqueueMessage("In family members with ". $firstname.$surname);
    	                       if ($fammemtype == "Spouse"){
    	                           $nspousesubs++;
    	                           $amount = -1.0 *  SubsHelper::returnSubrate($subsyear,$fammemtype); // Get sub rate for the year
    	                           $amountnogst = (10*$amount)/11;
    	                           $gst = $amount/11;
    	                           $membertype = "s";
    	                           SubsHelper::addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$fammemid);
    	                           
    	                       } else 
    	                       if ($fammemtype == "Child"){
    	                               $nchildsubs++;
    	                               $amount = -1.0 *  SubsHelper::returnSubrate($subsyear,$fammemtype); // Get sub rate for the year
    	                               $amountnogst = (10*$amount)/11;
    	                               $gst = $amount/11;
    	                               $membertype = "c";
    	                               SubsHelper::addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$fammemid);
    	                               
    	                       } else
    	                       if ($fammemtype == "Buddy"){
    	                           $nbuddysubs++;
    	                           
    	                           $amount = -1.0 *  SubsHelper::returnSubrate($subsyear,"Spouse"); // Buddy same as spouse  TODO create separate buddy rate
    	                           $amountnogst = (10*$amount)/11;
    	                           $gst = $amount/11;
    	                           $membertype = "b";
    	                           SubsHelper::addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$fammemid);
    	                           
    	                       }
    	                   }
    	                       
    	                   // Add Locker sub
    	                   $query = $db->getQuery ( true );
    	                   $query->select ( '*' );
    	                   $query->from ( 'lockers' );
    	                   $query->where('MemberID = '.$memid);
    	                   $db->setQuery ( $query );
    	                   $db->execute ();
    	                   
    	                   $num_rows = $db->getNumRows ();
    	                   $lockers = $db->loadObjectList ();
    	                   $comment= $subsyear . ' Subscriptions.';
    	                   
    	                   for($n=0;$n<$num_rows;$n++){
    	                      
    	                       $lockernum = $lockers[$n]->LockerNumber;
    	                       $app->enqueueMessage("In lockers for lockernum ".$lockernum);
    	                       $description = 'Locker '. $lockernum. ' subscription.';
    	                       $nlockersubs++;
    	                       $amount = -1.0 *  SubsHelper::returnSubrate($subsyear,"Locker"); // Get sub rate for the year
    	                       $amountnogst = (10*$amount)/11;
    	                       $gst = $amount/11;
    	                       $membertype = "l";
    	                       SubsHelper::addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$fammemid);
    	                       
    	                   }
    	                   // Set subs paid flag to No unless new balance is positive - i.e. subs paid out of existing funds
    	                   
    	                   
    	            }
    	        }
    	    }
	        // Set flag to say subs have been added
    	    SubsHelper::setSubsAdded($subsyear,"y");
    	    // update Subsummary
    	    SubsHelper::updateSubsSummary($subsyear,$ngraduatesubs,$nstudentsubs,$nlifehonlifesubs,$nspousesubs,$nchildsubs,$nbuddysubs,$nlockersubs,$nsummersubs);
    	    
	    }
	    else 
	    {
	        JFactory::getApplication()->enqueueMessage('Error: Subs already added!', 'error');
	    }
	    //  Update flag to say subs have been run
	    return; 
	}
	
	public function RemoveAllSubs()
	{
	    // Function to add all subs
	    $app = JFactory::getApplication ();
	    $app->enqueueMessage('In Remove All Subs');
	    require_once JPATH_COMPONENT . '/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    // Set flag to say subs have been removed
	    SubsHelper::setSubsAdded($subsyear,"n");
	    
	    // Need to cycle through all Finance entries and set MemberID to zero for all current year subs
	    
	    // get db
	    $db = JFactory::getDbo ();
	    $query = $db->getQuery ( true );
	    $query->select ( '*' );
	    $query->from ( 'finances' );
	    $query->where('FinanceType = '. $db->q("s"));
	    $query->where('FinanceYear = '. $db->q($subsyear));
	    $query->where('CreditDebit = '.$db->q("D"));
	    $db->setQuery ( $query );
	    $app->enqueueMessage('Query = '.$query);
	    $db->execute ();
	    
	    $num_rows = $db->getNumRows ();
	    $app->enqueueMessage('Numrows = '.$num_rows);
	    $finances = $db->loadObjectList ();
	    for($i = 0; $i < $num_rows;  $i++) 
	    { //Cycle through each line
	        $financeid = $finances[$i]->FinanceID;
	        $app->enqueueMessage('FinanceID = '.$financeid);
	        SubsHelper::deleteFinanceEntry($financeid,0);
	    }
	    // update Subsummary
	    $ngraduatesubs = 0;
	    $nstudentsubs = 0;
	    $nlifehonlifesubs=0;
	    $nspousesubs = 0;
	    $nchildsubs = 0;
	    $nbuddysubs = 0;
	    $nlockersubs = 0;
	    $nsummersubs = 0;
	    $ntotalsubs = 0;
	    SubsHelper::updateSubsSummary($subsyear,$ngraduatesubs,$nstudentsubs,$nlifehonlifesubs,$nspousesubs,$nchildsubs,$nbuddysubs,$nlockersubs,$nsummersubs);
	    
	}
}