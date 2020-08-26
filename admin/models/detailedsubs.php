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
 * LockersList Model
 *
 * @since  0.0.1
 */
class SubsModelDetailedSubs extends JModelList
{
        	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	/*public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id','f.id',
				'MemberID','f.MemberID',
				'MemberFirstname','m.MemberFirstname',
				'MemberSurname','m.MemberSurname'
			);
		}
 
		parent::__construct($config);
	}*/
       
	
	//override default list
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
	
		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
	
		$limit = 2000;  // set list limit
	
		$this->setState('list.limit', $limit);
		
		// set filters
			
		parent::populateState('');
	}
        
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
	    
	    require_once JPATH_COMPONENT . '/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// get input
		/*$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );*/
 
		// Create the base select statement.
		$query->select('f.*,concat(m.MemberFirstname,\' \',m.MemberSurname) as membername');               
                $query->from('finances AS f');  // use new osclockers table
                $query->where('f.FinanceType = '.$db->q('s'));
                $query->where('f.CreditDebit = '.$db->q('C'));
                $query->where('f.FinanceYear = '.$db->q($subsyear));
                $query->where('f.MemberID > 0');
                $query->leftJoin('members AS m ON f.MemberID = m.MemberID'); // Use new member table
                
                		// Filter: like / search
	
		return $query;
	}
	
	/*
	 * Function to return detailed subs entries - first gets a list of the members through the filters, then cycles through each entry by date and adds the total field
	 */
	public function getDetailedSubs()
	{
	    
	    /*
	     *  Get all current members and cycle through them
	     *  get any family members
	     *  get any lockers
	     *  return value
	     *  each from has - what the sub is, the amount and whether it is paid
	     *  
	     */
	    
	    // Get subsyear from helper file
	    require_once JPATH_COMPONENT . '/helpers/subs.php';
	    $subsyear = SubsHelper::returnSubsYear();
	    
	    $db    = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    $app = JFactory::getApplication ();
	    
	    $detailedsubs = array();
	    $memberids = array();
	    //$query->select ( 'CONCAT(MemberFirstname," ",MemberSurname) as membername,MemberType,CurrentSubsPaid' );
	    $query->select('MemberID');
	    $query->from ( 'members' );
	    $query->where ( 'MemberType in (\'Graduate\',\'Student\',\'Life\',\'Hon Life\') ' );
	    $query->where ('MemberLeaveofAbsence = \'No\'');
	    
	    $db->setQuery ( $query );
	    $db->execute ();
	    $num_rows = $db->getNumRows ();
	    $memberids = $db->loadObjectList ();
	  
	    $n=0;
	    for($i = 0; $i < $num_rows; $i ++) {
	        $memid = $memberids [$i]->MemberID;
	        //$app->enqueueMessage('Memid = '. $memid . ':');
	        $query = $db->getQuery(true);
	        $query->select ( 'CONCAT(MemberFirstname," ",MemberSurname) as membername,MemberType,CurrentSubsPaid' );
	        $query->from ( 'members' );
	        $query->where ( 'MemberID = ' . $memid );
	        $db->setQuery($query);
	        //$app->enqueueMessage('Query = '. $query . ':');
	        $row = $db->loadRow();
	        $detailedsubs[$n]->membername = $row['0'];
	        $detailedsubs[$n]->MemberType = $row['1'];
	        $detailedsubs[$n]->CurrentSubsPaid = $row['2'];
	        $subsrate = "0.00";
	        if ($row[1] == "Graduate" || $row[1] == "Student") 
	        {
	            $subsrate = SubsHelper::returnSubrate($subsyear,$row['1']);
	        }
	       
	        $detailedsubs[$n]->Amount =  $subsrate; 
	        
	        $n++;
	        // Add family members
	        $familysubs = array();
	        $query = $db->getQuery ( true );
	        
	        $query->select ( 'CONCAT(FamilyMemberFirstname," ",FamilyMemberSurname) as familymembername,FamilyMembershipType,CurrentSubsPaid' );
	        $query->from ( 'familymembers' );
	        $query->where ( 'MemberID = ' . $memid . ' AND FamilyMembershipType in (\'Spouse\',\'Child\') ' );
	        
	        $db->setQuery ( $query );
	        $db->execute ();
	        $num_rowsfam = $db->getNumRows ();
	        $familysubs = $db->loadObjectList ();
	        for ($j=0;$j < $num_rowsfam;$j++)
	        {
	            $familysubsrate = SubsHelper::returnSubrate($subsyear,$familysubs[$j]->FamilyMembershipType);
	            $app->enqueueMessage('Family Member = '. $familysubs[$j]->familymembername. ':');
	            $detailedsubs[$n]->membername = $familysubs[$j]->familymembername;
	            $detailedsubs[$n]->MemberType = $familysubs[$j]->FamilyMembershipType;
	            $detailedsubs[$n]->CurrentSubsPaid = $familysubs[$j]->CurrentSubsPaid;
	            $detailedsubs[$n]->Amount =  $familysubsrate; 
	        }
	        
	        // Add Lockers
	        
	    }
	    
	    return $detailedsubs;
	    
	}
	
	/*
	 * Function to return finance entries - first gets a list of the members through the filters, then cycles through each entry by date and adds the total field
	 */
	public function getFinanceEntries()
	{
		// get input
		$jinput = JFactory::getApplication ()->input;
		$memid = $jinput->get ( 'memid', 0 );
		
		// get information
		// get all distinct memberids in finances
		// cycle through all finance entries by memberid
		// add a "total" field to the array
		// return array
		
	}
} 