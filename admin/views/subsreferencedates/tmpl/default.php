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
?>


<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
     <h1><?php echo $this->msg; ?></h1>
     This component allows you to manage the Subs administration.<p>
     The links on the left are for: <b>Update</b>
     <ul>
     	<li><b>Subscription rates:</b> to manage rates used for annual subscription notices.</li>
     	<li><b>Summer Lodge rates:</b> to manage the nightly charge rate for summer bookings.</li>
     	<li><b>Winter Lodge rates:</b> to manage the nightly charge rate for winters bookings.</li>
     	<li><b>Student Week dates:</b> to specify the dates for Students Week. This then blocks these dates for general bookings.</li>
     	<li><b>President's Weekend dates:</b> to specify the dates for President's Weekend. This then blocks these dates for general bookings.</li>
     	<li><b>Ski Season dates:</b> to specify dates for when Winter Lodge rates apply - i.e. the Ski Season</li>
     </ul>
</div>