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
            JText::_('COM_SUBS_MEMBERPAIDSUBS'),
            'index.php?option=com_subs&view=finances',
            $vName == 'finances'
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
    public function addFinanceEntry($memid,$substartdate,$creditdebit,$amountnogst,$gst,$amount,$description,$comment,$financetype,$subsyear,$membertype,$memberrefid)
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
            'OldMemberID',
            'MemberType',
            'MemberRefID'
        ); 
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
            $memid,
            $db->quote($membertype),
            $memberrefid);
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
    
    public function setCurrentSubsPaid($memid,$setto,$infotable) 
    {
        // Get handle to Application
        $app = JFactory::getApplication ();
        
        $updatetable = "members"; // default
        $memberref = "MemberID";
        
        if ($infotable == "m") {
            $updatetable = "members";
            $memberref = "MemberID";
        }
        else if ($infotable == "f") {
            $updatetable = "familymembers";
            $memberref = "FamilyMemberID";
        }
        else if ($infotable == "l") {
            $updatetable = "lockers";
            $memberref = "id";
        }
        
        $db = JFactory::getDbo ();
        $sql    = $db->getQuery(true);
        $sql->update($db->qn($updatetable));
        $sql->set($db->qn('CurrentSubsPaid') . ' = ' . $db->q($setto));
        $sql->where($db->qn($memberref) . ' = ' . $db->q($memid));
        $db->setQuery($sql);
        $app->enqueueMessage('Set subs paid query = '.$sql);
        try
        {
            $db->execute();
        }
        catch (Exception $e)
        {
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }
        
        return;
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
    
    public function setSubsAdded($year,$flag) {
        
        // Get handle to Application
        $app = JFactory::getApplication ();
        
        $db = JFactory::getDbo ();
        $sql    = $db->getQuery(true)
        ->update($db->qn('oscsubsreferencedates'))
        ->set($db->qn('SubsAllocated') . ' = ' . $db->q($flag))
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
    
    public function deleteFinanceEntry($financeid,$value) {
        
        // Get handle to Application
        $app = JFactory::getApplication ();
        
        $db = JFactory::getDbo ();
        $sql    = $db->getQuery(true)
        ->update($db->qn('finances'))
        ->set($db->qn('MemberID') . ' = ' . $db->q($value))
        ->where($db->qn('FinanceID') . ' = ' . $db->q($financeid));
        $db->setQuery($sql);
        $db->execute();
        
        try
        {
            $app->enqueueMessage('In deleteFinanceEntry ');
            $db->execute();
        }
        catch (Exception $e)
        {
            
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }
        return;
    }
    
    public function updateSubsSummary($subsyear,$ngraduatesubs,$nstudentsubs,$nlifehonlifesubs,$nspousesubs,$nchildsubs,$nbuddysubs,$nlockersubs,$nsummersubs)
    {
        
        // check if there's already a row
        $app = JFactory::getApplication ();
        
        $db = JFactory::getDbo ();
        $query = $db->getQuery ( true );
        $query->select ( 'id');
        $query->from ( 'subssummary' );
        $query->where ( 'year =  '. $subsyear  );  // Data only in the first row
        $db->setQuery ( $query );
        $db->execute();
        $num_rows = $db->getNumRows();
        //$app->enqueueMessage('Query = '.$query);
        $subsadded = $db->loadResult();
        //$app->enqueueMessage('Added = '.$subsadded.":");
        
        if ($num_rows == 0) {
            // Need to insert a role
            $columns =  array(
                'year',
                'Graduatecount',
                'Childcount',
                'Spousecount',
                'lockercount',
                'buddycount',
                'summercount',
                'lifehonlifecount',
                'studentcount'
            );
            $values = array(
                $subsyear,
                $ngraduatesubs,
                $nchildsubs,
                $nspousesubs,
                $nlockersubs,
                $nbuddysubs,
                $nsummersubs,
                $nlifehonlifesubs,
                $nstudentsubs);
            // Set query
            $query = $db->getQuery(true);
            $query->insert('subssummary');
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
        }
        else {
           // Need to update the row
            $query = $db->getQuery ( true );
            $fields = array(
                'Graduatecount = '.$ngraduatesubs,
                'Childcount = '.$nchildsubs,
                'Spousecount = '.$nspousesubs,
                'lockercount = '.$nlockersubs,
                'buddycount = '.$nbuddysubs,
                'summercount = '.$nsummersubs,
                'lifehonlifecount = '.$nlifehonlifesubs,
                'studentcount = '.$nstudentsubs
                
            );
            $conditions = array('year = '. $subsyear );
            $query->update('subssummary');
            $query->set($fields);
            $query->where($conditions);
            
            $db->setQuery ( $query );
            try
            {
                $app->enqueueMessage('In try ');
                $db->execute();
            }
            catch (Exception $e)
            {
                
                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            }
            
        }
        // if no, insert
        // if yes, update values
        return;
    }
    
}