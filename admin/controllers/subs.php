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
	    // Check we've got the right member
	    JFactory::getApplication()->enqueueMessage('Send member subs with member id'.$memid.'and email'.$mememail);
	    
	    // Email member
	    // Set up mail
	    // Get mailer object
	    $mailer = JFactory::getMailer();
	    
	    // Set Sender
	    $config = JFactory::getConfig();
	    $sender = array(
	        $config->get( 'mailfrom' ),
	        $config->get( 'fromname' )
	    );
	    
	    $mailer->setSender($sender);
	    
	    // Set recipient
	    $recipient = $mememail; //'geoffm@labyrinth.net.au';
	    if ( strlen($recipient) > 0 )
	    {
    	    $mailer->addRecipient($recipient);
    	    
    	    // Create message body
    	    $body = "this is the mail message";
    	    
    	    $mailer->setSubject(JText::_('COM_SUBS_EMAIL_SUBJECT'));
    	    $mailer->setBody($body);
    	    
    	    // Send the message
    	    $send = $mailer->Send();
    	    if ( $send !== true ) {
    	        echo 'Error sending email: ';
    	    } else {
    	        echo 'Mail sent';
    	    }
	    }
	    
	    // Set the return path
	    $returnurl = 'index.php?option=com_subs&view=subs';
	    
	    $this->setRedirect($returnurl);
	    return $return;
	}
}