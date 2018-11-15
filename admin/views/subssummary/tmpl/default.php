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
JHtml::_ ( 'formbehavior.chosen', 'select' );
?>


<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
     <h1><?php echo $this->msg; ?></h1>
     This component allows you to manage the Subs administration.<p>
     
     Current selected Subs year to update:  <?php echo $this->subsyear;?>
     <form action="index.php?option=com_subs&view=subssummary" method="post"
	id="adminForm" name="adminForm">

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="5%">
					<?php echo JText::_('COM_SUBS_SUBSSUMMARYID'); ?>
				</th>
				<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th width="10%">
				<?php echo JText::_('COM_SUBS_SUBSSUMMARY_YEAR') ;?>
				</th>
				<th width="10%">
				<?php echo JText::_('COM_SUBS_SUBSSUMMARY_SUBSSTARTDATE') ;?>
				</th>
				<th width="10%">
				<?php echo JText::_('COM_SUBS_SUBSSUMMARY_SUBSENDDATE') ;?>
				</th>
				<th width="10%">
				<?php echo JText::_('COM_SUBS_SUBSSUMMARY_SUBSPAYBYDATE') ;?>
				</th>
				<th width="10%">
				<?php echo JText::_('COM_SUBS_SUBSSUMMARY_SUBSPAIDRESET') ;?>
				</th>
				<th width="10%">
				<?php echo JText::_('COM_SUBS_SUBSSUMMARY_SUBSALLOCATED') ;?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (!empty($this->items)) : ?>
				<?php foreach ( $this->items as $i => $row ): 
				    $link = JRoute::_ ( 'index.php?option=com_subs&task=subsummary.edit&id=' . $row->id );
				
				?>
				<tr>
				<td align="center">
							<?php echo $row->id; ?>
				</td>
				<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
				</td>
				<td>
							<?php echo $row->subsyear; ?>
				</td>
				<td>
							<?php echo $row->subsstartdate; ?>
				</td>
				<td>
							<?php echo $row->subsenddate; ?>
				</td>
				<td>
							<?php echo $row->subpaybydate; ?>
				</td>
				<td>
							<?php echo $row->SubsPaidReset; ?>
				</td>
				<td>
							<?php echo $row->SubsAllocated; ?>
				</td>
				
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value="" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<?php echo JHtml::_('form.token'); ?>
</form>			
</div>