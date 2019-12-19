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
	    $mememail = $jinput->get('memberemail','','text');
	    $memfirstname = $jinput->get('memberfirstname','','text');
	    $memsurname = $jinput->get('membersurname','','text');
	    // Check we've got the right member
	    //JFactory::getApplication()->enqueueMessage('Send member subs with member id'.$memid.'and email'.$mememail.' for '.$memfirstname.' '.$memsurname);
	    
	    // Email member
	    // Set up mail
	    // Get mailer object
	    $mailer = JFactory::getMailer();
	    $mailer->isHTML();
	    
	    // Set Sender
	    $config = JFactory::getConfig();
	    $sender = array(
	        $config->get( 'mailfrom' ),
	        $config->get( 'fromname' )
	    );
	    
	    $mailer->setSender($sender);
	    
	    // Set recipient
	    $recipient = $mememail; //'geoffm@labyrinth.net.au';
	    
	    // Ensure email is valid
	    if (!filter_var($recipient,FILTER_VALIDATE_EMAIL)) {
	        // Do nothing if email is not valid
	    }
	    else {
	        
    	    
    	    if ( strlen($recipient) > 0 )
    	    {
        	    $mailer->addRecipient($recipient);
        	    $mailer->addBcc('geoffm@labyrinth.net.au');
        	    
        	    // Create message body
        	    $body = "Dear ".$memfirstname.'<p><p>';
        	    
        	    $body .= "Please find attached your 2020 Ormond Ski Club Subscription notice. Note: Subs are due <b>29th Feb 2020</b><p><p>";
        	    
        	    $body .= "If you have any questions about your membership, please contact the Membership officer at general@ormondskiclub.com.au.<p><p>";
        	    
        	    $body .= "<p>Rohan Hodges<p>Ormond Ski Club Membership Officer";
        	    
        	    $mailer->setSubject('Ormond Ski Club Subscription Notice for '.$memfirstname.' '.$memsurname);
        	    $mailer->setBody($body);
        	    
        	    
        	    $subsfile = JPATH_COMPONENT . '/subsfiles/'.$memid.'.pdf';
        	    JFactory::getApplication()->enqueueMessage("subs file".$subsfile);
        	    
        	    if ( !file_exists($subsfile) || !(is_file($subsfile) || is_link($subsfile)))
        	    {
        	        JFactory::getApplication()->enqueueMessage( "The file does not exist, or it's not a file; no email sent");
        	        
        	        return false;
        	    }
        	    
        	    if ( !is_readable($subsfile))
        	    {
        	        JFactory::getApplication()->enqueueMessage("The file is not readable; no email sent");
        	        
        	        return false;
        	    }
        	    
        	    // Add attachment
        	    $mailer->addAttachment($subsfile);
        	    // Send the message
        	    $send = $mailer->Send();
        	    if ( $send !== true ) {
        	        JFactory::getApplication()->enqueueMessage('Error sending email: ');
        	        
        	    } else {
        	        JFactory::getApplication()->enqueueMessage('Mail sent');
        	        
        	        // Function to add entry to show subs sent
        	        $db    = JFactory::getDbo();
        	        $query = $db->getQuery(true);
        	        
        	        $yesval = "Yes";
        	        $datesubsent = now();
        	        $fields = array('dateSubsSent= '. $db->quote($datesubsent),
        	            'SubsSent = '.$yesval
        	        );
        	        $conditions = array('MemberID = '. $memid );
        	        $query->update('members');
        	        $query->set($fields);
        	        $query->where($conditions);
        	        
        	        $db->setQuery ( $query );
        	        $db->execute ();
        	    }
        	    
        	    
    	    }
	    }
	    
	    // Set the return path
	    $returnurl = 'index.php?option=com_subs&view=subs';
	    
	    $this->setRedirect($returnurl);
	    return $return;
	}
}