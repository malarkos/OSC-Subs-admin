<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_subs
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Subscontroller Controller
 *
 * @since  0.0.1
 */
class SubsControllerSubs extends JControllerAdmin
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
	public function getModel($name = 'Subs', $prefix = 'SubsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
	public function SendMemberSubviaEmail()
	{
	    $app    = JFactory::getApplication();  // get instance of app
	    $jinput = $app->input;
	    //JFactory::getApplication()->enqueueMessage('$jinput  = '.$jinput.":");
	    $memid = $jinput->get('memid','','text'); 
	    
	    JFactory::getApplication()->enqueueMessage('Send member subs with member id'.$memid);
	    $returnurl = 'index.php?option=com_subs&view=subs';
	    
	    $this->setRedirect($returnurl);
	    return $return;
	}
}