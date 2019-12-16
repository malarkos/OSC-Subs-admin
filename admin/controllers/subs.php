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
	        
	    }
	    else {
	        
    	    
    	    if ( strlen($recipient) > 0 )
    	    {
        	    $mailer->addRecipient($recipient);
        	    
        	    // Create message body
        	    $body = "Dear ".$memfirstname.'<p><p>';
        	    
        	    $body .= "Please find attached your 2020 Ormond Ski Club Subscription notice.<p><p>Subs are due 29th Feb 2020";
        	    
        	    $mailer->setSubject(JText::_('COM_SUBS_EMAIL_SUBJECT'));
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
        	    }
        	    
        	    
    	    }
	    }
	    
	    // Set the return path
	    $returnurl = 'index.php?option=com_subs&view=subs';
	    
	    $this->setRedirect($returnurl);
	    return $return;
	}
}