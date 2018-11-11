<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_members
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access
defined('_JEXEC') or die('Restricted access');
 
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
$fieldsets = $this->form->getFieldsets();
?>
<form action="<?php echo JRoute::_('index.php?option=com_members&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal" enctype="multipart/form-data">
        <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_MEMBERS_WORKPARTY_DETAILS'); ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="memberworkparty.edit" />
    <?php echo JHtml::_('form.token'); ?>
    
</form>