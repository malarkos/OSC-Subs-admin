<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_reference
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class SubsHelper extends JHelperContent
{
    public static function addSubmenu($vName)
    {
        JHtmlSidebar::addEntry(
            JText::_('COM_SUBS_SUBSSUMMARY'),
            'index.php?option=com_subs&view=subssummary',
            $vName == 'subssummary'
        );
        
        JHtmlSidebar::addEntry(
            JText::_('COM_SUBS_RESETSUBS'),
            'index.php?option=com_subs&view=resetsubs',
            $vName == 'resetsubs'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_SUBS_ADDSUBS'),
            'index.php?option=com_subs&view=addsubs',
            $vName == 'addsubs'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_SUBS_MEMBERSUBS'),
            'index.php?option=com_subs&view=subs',
            $vName == 'subs'
            );
        JHtmlSidebar::addEntry(
            JText::_('COM_SUBS_SUBSREFERENCEDATES'),
            'index.php?option=com_subs&view=subsreferencedates',
            $vName == 'subsreferencedates'
            );
    }
    
    public function returnSubsYear()
    {
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'subsyear' );
        $query->from ( 'oscreference' );
        $query->where ( 'id = 1 '  );  // Data only in the first row
        $db->setQuery ( $query );
        $subsyear = $db->loadResult();
        
        return ($subsyear);
    }
    
    public function returnSubsStartDate($year)
    {
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'subsstartdate' );
        $query->from ( 'oscsubsreferencedates' );
        $query->where ( 'subsyear =  '. $year  );  // Data only in the first row
        $db->setQuery ( $query );
        $subsyear = $db->loadResult();
        
        return ($subsyear);
    }
}