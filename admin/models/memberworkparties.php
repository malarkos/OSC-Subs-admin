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
class MembersModelMemberWorkParties extends JModelList
{
    
        
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
		
		// get values
		$jinput = JFactory::getApplication()->input;
		
		$memid = $jinput->get('memid',0);
 
		if ($memid != 0) { // check we have a valid value
			// Create the base select statement.
			$query->select('*');
			$query->from('workparty');
			$query->where('MemberID = ' . $memid);
		}
		else 
			$query = null;
		
                // Filter: like / search
		
		return $query;
	}
}