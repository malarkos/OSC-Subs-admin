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
		$this->msg = "OSC Subs Administration";
		
		require_once JPATH_COMPONENT . '/helpers/subs.php';
		
		SubsHelper::addSubmenu("subssummary");
		
		
		$this->sidebar = JHtmlSidebar::render();
		
		// Display the template
		parent::display($tpl);
	}
	
	
}