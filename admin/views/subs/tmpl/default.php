<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
JHtml::_ ( 'formbehavior.chosen', 'select' );

$listOrder = $this->escape ( $this->filter_order );
$listDirn = $this->escape ( $this->filter_order_Dir );
?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<form action="index.php?option=com_subs&view=subs" method="post"
	id="adminForm" name="adminForm">

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="2%">
				<?php echo JHtml::_('grid.sort', 'COM_SUBS_ID', 'id', $listDirn, $listOrder); ?>
				</th>
				<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				<th width="2%">
				<?php echo JText::_('COM_SUBS_TITLE') ;?>
				</th>
				<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_SUBS_FIRSTNAME', 'MemberFirstname', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_SUBS_SURSTNAME', 'MemberSurname', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_SUBS_MEMBERTYPE', 'MemberType', $listDirn, $listOrder); ?>
				</th>
				
				
				<th width="5%">
				<?php echo JText::_('COM_SUBS_MEMBER_DOB_LABEL') ;?>
				</th>
				<th width="5%">
				<?php echo JText::_('COM_SUBS_MEMBER_AGE') ;?>
				</th>
				<th width="5%">
				<?php echo JText::_('COM_SUBS_LOA') ;?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_SUBS_MEMBER_SUMMER_LABEL') ;?>
				</th>
				<th width="15%">
					<?php echo JText::_('COM_SUBS_SUBS_BILLED') ;?>
				</th>
				
				</th>
				<th width="5%">
				<?php echo JText::_('COM_SUBS_SEND_EMAIL') ;?>
				</th>
				<th width="5%">
				<?php echo JText::_('COM_SUBS_EMAIL_SENT') ;?>
				</th>
				
				<th width="5%">
				<?php echo JText::_('COM_SUBS_SUBS') ;?>
				</th>
				<th width="5%">
				<?php echo JText::_('COM_UPDATE_SUBS') ;?>
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
				<?php
				
foreach ( $this->items as $i => $row ) :
					$link = JRoute::_ ( 'index.php?option=com_members&task=member.edit&id=' . $row->id );
					$subslink = JRoute::_ ( 'index.php?option=com_members&view=membersubsnotice&memid=' . $row->MemberID . '&tmpl=component' );
					$updatesubslink = JRoute::_ ( 'index.php?option=com_subs&view=sub&memid=' . $row->MemberID );
					$emailmembersubslink = JRoute::_ ( 'index.php?option=com_subs&task=subs.SendMemberSubviaEmail&memid=' . $row->MemberID .'&memberemail='.$row->MemberEmail.'&memberfirstname='.$row->MemberFirstname.'&membersurname='.$row->MemberSurname);
					// $subslink = JRoute::_('index.php?option=com_members&view=membersubsnotice&memid=' . $row->MemberID.'&tmpl=component&print=1&page=');
					?>
 
					<tr>
				<td align="center">
							<?php echo $row->MemberID; ?>
						</td>
				<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
				<td>
								
								<?php echo $row->MemberTitle; ?>
						</td>
				<td>
								
								<?php echo $row->MemberFirstname; ?>
						</td>
				<td><a href="<?php echo $link; ?>"
					title="<?php echo JText::_('COM_SUBS_EDIT_MEMBER'); ?>">
								<?php echo $row->MemberSurname; ?>
							</a></td>
				<td>
								<?php echo $row->MemberType; ?>
						</td>
				
				
						<td>
								<?php echo $row->MemberBirthDate; ?>
						</td>
						<td>
								<?php 
								    $dateString=$row->MemberBirthDate;;
								    $years = round((time()-strtotime($dateString))/(3600*24*365.25));
								    if ($years > 100) $years = '-'; // if no date of birth, defaults to 2020
								    if ($years > 69) {
								        echo "<b>".$years."</b>";
								    }
								    else {
								        echo $years;
								    }
								?>
						</td>
						<td>
								<?php echo $row->MemberLeaveofAbsence; ?>
						</td>
						<td>
								<?php echo $row->SummerUsageOnly; ?>
						</td>
						<td>
							<table class="table table-striped table-hover">
							
							<?php foreach ($this->subsbilled as $i => $financerow) :?>
									<?php if ($financerow->MemberID == $row->MemberID ) {
									    echo "<tr><td>";
									    echo $financerow->Description;
									    echo "</td><td>";
									    echo $financerow->Amount;
									    echo "</td></tr>";
									}
									    
									 ?>
							<?php endforeach; ?>
							
							</table>
						</td>
						<td>
							<a href="<?php echo $emailmembersubslink; ?>">Email subs</a>
						</td>
						<td>
							Subs emailed on
						</td>
				<td>
					<a href="<?php echo $subslink; ?>"> Subs Notice </a></td>
				</td>
				<td>
					<a href="<?php echo $updatesubslink; ?>"> Update Subs </a></td>
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