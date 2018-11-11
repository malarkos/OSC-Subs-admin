<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::_('formbehavior.chosen', 'select');
 

?>
<form action="index.php?option=com_members&view=memberworkparties" method="post" id="adminForm" name="adminForm">
	
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_MEMBERS_ID', 'id'); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			
			<th width="30%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTY_DATE') ;?>
			</th>
			<th width="30%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTY_DAYS') ;?>
			</th>
			<th width="30%">
				<?php echo JText::_('COM_MEMBERS_WORKPARTY_COMMENT') ;?>
			</th>
			
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) :
					$link = JRoute::_('index.php?option=com_members&task=member.edit&id=' . $row->id);
				?>
 
					<tr>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
								
								<?php echo $row->WorkPartyDate; ?>
						</td>
						<td>
								
								<?php echo $row->WorkPartyDays; ?>
						</td>
                                                
						</td>                                               
						<td>
								<?php echo $row->Comments; ?>
						</td>
						
						
						
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	
	<?php echo JHtml::_('form.token'); ?>
</form>