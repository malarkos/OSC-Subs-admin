<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_reference
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorlds View
 *
 * @since  0.0.1
 */
class SubsViewAddSubs extends JViewLegacy
{
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		$this->msg = "Add Subs";
		
		require_once JPATH_COMPONENT . '/helpers/subs.php';
		
		SubsHelper::addSubmenu("addsubs");
		
		
		$this->sidebar = JHtmlSidebar::render();
		
		
		$this->addToolBar();
		
		// Display the template
		parent::display($tpl);
	}
	
	protected function addToolBar()
	{
	    
	    
	    JToolBarHelper::title(JText::_('COM_SUBS_ADDSUBMANAGER'));
	    JToolBarHelper::custom('addsub.addsubscriptions', '', '', 'Add Subscriptions', true);
	    
	}
}