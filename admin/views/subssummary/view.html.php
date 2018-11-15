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
class SubsViewSubsSummary extends JViewLegacy
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
	    $app = JFactory::getApplication();
	    //$context = "members.list.admin.subs";
	    // Get data from the model
	    $this->items		= $this->get('Items');
	    $this->subsyear    = $this->get('SubsYear');
	    $this->pagination	= $this->get('Pagination');
	    $this->state			= $this->get('State');
	    
		$this->msg = "OSC Subs Administration";
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
		    JError::raiseError(500, implode('<br />', $errors));
		    
		    return false;
		}
		
		require_once JPATH_COMPONENT . '/helpers/subs.php';
		
		SubsHelper::addSubmenu("subssummary");
		
		
		$this->sidebar = JHtmlSidebar::render();
		
		// Set the toolbar
		$this->addToolBar();
		
		// Display the template
		parent::display($tpl);
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
	    
	    /*if ($this->pagination->total)
	    {
	        $title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
	    }*/
	    
	    JToolBarHelper::title(JText::_('COM_SUBS_MANAGER'));
	    //JToolBarHelper::addNew('sub.add');
	    //JToolBarHelper::editList('sub.edit');
	    JToolBarHelper::custom( 'SubsSummary.AddSubs', '', '', 'Add Subs', false, false );
	    
	}
}