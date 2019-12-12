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
class SubsModelSubs extends JModelList
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
        $query->from('members');
        $query->where('MemberType in (\'Graduate\',\'Student\',\'Life\',\'Hon Life\')');
        //$query->where('MemberLeaveofAbsence = \'No\'');
                
                // Filter: like / search
		/*$search = $this->getState('filter.search');
 
		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('MemberSurname LIKE ' . $like.' OR MemberType LIKE '.$like.' OR MemberFirstname LIKE '.$like);
		}
 
 		$orderCol	= $this->state->get('list.ordering', 'id');
		$orderDirn 	= $this->state->get('list.direction', 'asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));*/
		return $query;
	}
	
	//override default list
	protected function populateState($ordering = null, $direction = null)
	{
	    // Initialise variables.
	    $app = JFactory::getApplication();
	    
	    // List state information
	    $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'));
	    
	    $limit = 2000;  // set list limit
	    
	}
	
	/*public function getSubsBilled()
	{
	    // Function to return current subs year
	    require_once JPATH_COMPONENT . '/helpers/subs.php';
	    
	    $subsbilled = SubsHelper::returnSubsBilled();
	    
	    return $subsbilled;
	}*/
}