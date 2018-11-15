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
	    
	    // TODO: function to get all Subs
	    
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
	                   $description = $memtype . ' subscription';
	                   $amount = -1.0 * 180; // TODO get graduate subs
	                   $amountnogst = (10*$amount)/11;
	                   $gst = $amount/11;
	                   
	                
	                   
	                   $query = $db->getQuery(true)
	                   ->insert('finances')
	                   ->columns(array(
	                       $db->quoteName('MemberID'),
                           $db->quoteName('TransactionDate'),
	                       $db->quoteName('CreditDebit'),
	                       $db->quoteName('AmountNoGST'),
	                       $db->quoteName('GST'),
	                       $db->quoteName('Amount'),
	                       $db->quoteName('Description'),
	                       $db->quoteName('Comment'),
	                       $db->quoteName('FinanceType'),
	                       $db->quoteName('FinanceYear')
	                       ))->values(array(
	                       $db->quote($memid),
	                       $db->quote($substartdate),
	                       $db->quote($creditdebit),
	                       $db->quote($amountnogst),
	                       $db->quote($gst),
	                       $db->quote($amount),
	                       $db->quote($description),
	                       $db->quote($comment),
	                       $db->quote($financetype),
	                       $db->quote($subsyear)
	                       ));
	                   // Update Subs paid flag to No
	                       $app->enqueueMessage('Query = '.$query);
	                      try
	                           {
	                              // $db->setQuery($query)->execute();
	                       }
	                       catch (\Exception $e)
	                       {
	                           // Your database if FUBAR.
	                           return;
	                       }
	                   
	            }
	        }
	    }
	    
	    
	    //  Update flag to say subs have been run
	    return;
	}
}