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
        $subsstartdate = $db->loadResult();
        
        return ($subsstartdate);
    }
    
    public function returnSubrate($year,$memtype)
    {
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( $memtype);
        $query->from ( 'oscmemberrates' );
        $query->where ( 'Year =  '. $year  );  // Data only in the first row
        $db->setQuery ( $query );
        $subsstartdate = $db->loadResult();
        
        return ($subsstartdate);
    }
    public function addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear)
    {
        // Get handle to Application
        $app = JFactory::getApplication ();
        
        // Connect to database
        $db = JFactory::getDbo ();
        // Set query
        $query = $db->getQuery(true)
        ->insert('finances')
        ->columns(array(
            $db->quoteName('MemberID'),
            $db->quoteName('TransactionDate'),
            $db->quoteName('CreditDebit'),
            $db->quoteName('AmountNoGST'),
            $db->quoteName('GST'),
            $db->quoteName('Amount'),
            $db->quoteName('Description'),
            $db->quoteName('Comment'),
            $db->quoteName('FinanceType'),
            $db->quoteName('FinanceYear')
        ))->values(array(
            $db->quote($memid),
            $db->quote($substartdate),
            $db->quote($creditdebit),
            $db->quote($amountnogst),
            $db->quote($gst),
            $db->quote($amount),
            $db->quote($description),
            $db->quote($comment),
            $db->quote($financetype),
            $db->quote($subsyear)
        ));
        
        $app->enqueueMessage('Query = '.$query);
        try
        {
            // $db->setQuery($query)->execute();
        }
        catch (\Exception $e)
        {
            // Your database if FUBAR.
            
        }
        return;
    }
    
    public function setCurrentSubsPaid($memid,$setto) 
    {
        $db = JFactory::getDbo ();
        $sql    = $db->getQuery(true)
        ->update($db->qn('members'))
        ->set($db->qn('CurrentSubsPaid') . ' = ' . $db->q($setto))
        ->where($db->qn('MemberID') . ' = ' . $db->q($memid));
        $db->setQuery($sql);
        $db->execute();
    }
    
    public function checkIfSubsAdded($year)
    {
        // Get handle to Application
        $app = JFactory::getApplication ();
        
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'SubsAllocated');
        $query->from ( 'oscsubsreferencedates' );
        $query->where ( 'subsyear =  '. $year  );  // Data only in the first row
        $db->setQuery ( $query );
        $db->execute();
        $num_rows = $db->getNumRows();
        //$app->enqueueMessage('Query = '.$query);
        $subsadded = $db->loadResult();
        //$app->enqueueMessage('Added = '.$subsadded.":");
       
        if ($num_rows == 0) {
            $subsadded = 'y'; // Default value to stop being overwritten if system fails
        }
        else {
            $subsadded = $db->loadResult();
        }
        return ($subsadded);
    }
}