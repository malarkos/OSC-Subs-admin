<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_lockers
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
JHtml::_ ( 'formbehavior.chosen', 'select' );


$total=0;
?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<form action="index.php?option=com_subs&view=detailedsubs" method="post"
	id="adminForm" name="adminForm">
	
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				
						
			
				
				<th width="40%">
				<?php echo JText::_('COM_SUBS_MEMBERNAME') ;?>
				</th>
				
				<th width="20%">
				<?php echo JText::_('COM_SUBS_MEMBERTYPE') ;?>
			</th>
			<th width="20%">
				<?php echo JText::_('COM_FINANCES_AMOUNT') ;?>
			</th>
				<th width="20%">
				<?php echo JText::_('COM_SUBS_MEMBERPAIDSUBS') ;?>
			</th>
		

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php $totalamount=0;?>
			<?php if (!empty($this->items)) : ?>
				<?php
				
foreach ( $this->items as $i => $row ) :
					//$link = JRoute::_ ( 'index.php?option=com_subs&task=financeentry.edit&FinanceID=' . $row->FinanceID  );
					//$link = JRoute::_ ( 'index.php?option=com_finances&task=financeentry.edit&FinanceID=' . $row->id . '&memid=' . $row->MemberID );
					?>
 
					<tr>
				
				<td>
						
								<?php echo $row->membername; ?>
							
						</td>
				<td>
							
                          <?php echo $row->MemberType; ?>
                                                        
						</td>
						<Td> <?php echo $row->Amount; ?></Td>
				<td>
						
								<?php echo $row->CurrentSubsPaid; ?>
							
						</td>


				

			</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value="" /> <input type="hidden"
		name="boxchecked" value="0" /> <input type="hidden"
		name="filter_order" value="<?php echo $listOrder; ?>" /> <input
		type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
</div>