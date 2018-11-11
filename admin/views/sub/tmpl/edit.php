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
        <?php echo JLayoutHelper::render('joomla.edit.item_title', $this); ?>
        <fieldset>
            <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'summary')); ?>
            
                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'summary', JText::_('COM_MEMBERS_MEMBER_DETAILS', true)); ?>
			
                    <?php foreach ($this->form->getFieldset('member_summary') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php echo JHtml::_('bootstrap.endTab'); ?>
           
                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'dates', JText::_('COM_MEMBERS_MEMBER_DATES', true)); ?>
			
                    <?php foreach ($this->form->getFieldset('member_dates') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php echo JHtml::_('bootstrap.endTab'); ?>
                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'other', JText::_('COM_MEMBERS_MEMBER_OTHER', true)); ?>
			
                    <?php foreach ($this->form->getFieldset('member_other') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php echo JHtml::_('bootstrap.endTab'); ?>
            <?php echo JHtml::_('bootstrap.endTabSet'); ?>
        </fieldset>
   
    <input type="hidden" name="task" value="member.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>