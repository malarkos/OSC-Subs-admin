<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_members
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorlds Controller
 *
 * @since  0.0.1
 */
class SubsControllerSubsSummary extends JControllerAdmin
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
	public function getModel($name = 'SubsSummary', $prefix = 'SubsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
	
	public function AddSubs ()
	{
	    $app = JFactory::getApplication ();
	    $app->enqueueMessage('In Add Subs');
	    
	    $model = JModelLegacy::getInstance('SubsSummary', 'SubsModel');
	    
	    $model->AddAllSubs();
	    
	    // Set return URL
	    
	    $returnurl = 'index.php?option=com_subs&view=subssummary';
	    
	    $this->setRedirect($returnurl);
	    
	    return;
	}
	
	public function RemoveSubs() {
	    
	    
	    $app = JFactory::getApplication ();
	    $app->enqueueMessage('In Remove Subs');
	    
	    $model = JModelLegacy::getInstance('SubsSummary', 'SubsModel');
	    
	    $model->RemoveAllSubs();
	    
	    $returnurl = 'index.php?option=com_subs&view=subssummary';
	    
	    $this->setRedirect($returnurl);
	    
	    return;
	}
}