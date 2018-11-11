<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorld Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class SubsControllerAddSub extends JControllerAdmin
{
    public function addsubscriptions()
    {
        // Message to show we're in the right area.
        $msg = "In Add Subs";
        $application = JFactory::getApplication();
        $application->enqueueMessage($msg);
        
        // Set return URL
        $returnurl = 'index.php?option=com_subs&view=addsubs';
        $this->setRedirect($returnurl);
        return $returnurl;
        
        
    }
}