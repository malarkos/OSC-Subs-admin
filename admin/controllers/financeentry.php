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
 * Locker Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class SubsControllerFinanceEntry extends JControllerForm
{
		// Override save and cancel functions to route to the correct controller
		// 22/4/17 - Don't need this function as now have search working correctly.
	public function save($key = null, $urlVar = null) {
		
		/*$memid=0;
		if (isset($_POST['jform'])) {
			// Get the original POST data
			$jinput = JFactory::getApplication()->input;
		
			$original = $jinput->post->get('jform', array(), 'array');
		
			// Trim each of the fields
			foreach($original as $key=>$value) {
				$postData[$key] = trim($value);
			}
			$memid = $postData['MemberID'];
			JFactory::getApplication()->enqueueMessage('MemID = '.$memid);
		}*/
		
	    //$jinput = JFactory::getApplication ()->input;
	    //$memid = $jinput->get ( 'memid', 0 );
	    
	    $session = JFactory::getSession();
	    $memid = $session->get( 'memid');
	    $refererURL = $session->get( 'refererURL');
	    JFactory::getApplication()->enqueueMessage('In save MemID = '.$memid.'and refererURL = '.$refererURL.':');
	    
		$return = parent::save($key, $urlVar);
		
		if ($memid > 0) {
		    $returnurl = 'index.php?option=com_members&view=membersubspayment&memid='.$memid;
		}
		else
		    if  (isset($refererURL))
		    {
		        $returnurl= $session->get( 'refererURL');
		    }
		      else
		      {
		            $returnurl = 'index.php?option=com_subs&view=finances';
		      }
		
		
		$this->setRedirect($returnurl);
		return $return;
	}
	
	
	public function cancel($key = null, $urlVar = null) {
		
	    $session = JFactory::getSession();
	    $memid = $session->get( 'memid');
	    $refererURL = $session->get( 'refererURL');
	    JFactory::getApplication()->enqueueMessage('In Cancel MemID = '.$memid.'and refererURL = '.$refererURL.':');
		
		$return = parent::cancel($key, $urlVar);
		
		if ($memid > 0) {
		    $returnurl = 'index.php?option=com_members&view=membersubspayment&memid='.$memid;
		}
		else
		    if  (isset($refererURL))
		    {
		        $returnurl= $session->get( 'refererURL');
		    }
		else
		{
		    $returnurl = 'index.php?option=com_subs&view=finances';
		}
		
		$this->setRedirect($returnurl);
		return $return;
	}
	
	
}