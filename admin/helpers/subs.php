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
        
        $columns =  array(
            'MemberID',
            'TransactionDate',
            'CreditDebit',
            'AmountNoGST',
            'GST',
            'Amount',
            'Description',
            'Comment',
            'FinanceType',
            'FinanceYear',
            'OldMemberID'); 
        $values = array(
            $memid,
            $db->quote($substartdate),
            $db->quote($creditdebit),
            $amountnogst,
            $gst,
            $amount,
            $db->quote($description),
            $db->quote($comment),
            $db->quote($financetype),
            $subsyear,
            $memid);
        // Set query
        $query = $db->getQuery(true);
        $query->insert('finances');
        $query->columns($db->quoteName($columns));
        $query->values(implode(',', $values));
        $db->setQuery($query);
        
        $app->enqueueMessage('Query = '.$query);
        try
        {
            $app->enqueueMessage('In try ');
            $db->execute();
        }
        catch (Exception $e)
        {
            
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
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
    
    public function setSubsAdded($year) {
        
        // Get handle to Application
        $app = JFactory::getApplication ();
        
        $db = JFactory::getDbo ();
        $sql    = $db->getQuery(true)
        ->update($db->qn('oscsubsreferencedates'))
        ->set($db->qn('SubsAllocated') . ' = ' . $db->q('y'))
        ->where($db->qn('subsyear') . ' = ' . $db->q($year));
        $db->setQuery($sql);
        $db->execute();
        
        try
        {
            $app->enqueueMessage('In try ');
            $db->execute();
        }
        catch (Exception $e)
        {
            
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }
        return;
    }
}