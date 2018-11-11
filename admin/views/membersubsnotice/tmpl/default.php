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

$member = $this->items [0];
$totalowing = 0.00;
?>


<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td align="center">
			<h2>
				Ormond Ski Club 2017 Subscription Notice<img
					src="http://www.ormondskiclub.com.au/images/osclogo58.png"
					alt="Ormond Ski Club Logo" height="58" width="111">
			</h2>
		</td>
	</tr>
	<tr>
		<td align="center"><h3>
				<font color="blue">TAX INVOICE</font>
			</h3></td>
	</tr>
	<tr>
		<table width="100%" border="0">
			<tr>
				<td width="50%"><Font size="+2"><b><?php echo $member->MemberFirstname; echo " "; echo $member->MemberSurname;  ?></b></Font>
					<p>
						<font size="+1"><?php echo $member->MemberHomeAddress;echo " "; echo $member->MemberHomeAddress2;?></br>
					
					<?php echo $member->MemberHomeSuburb;?></br>
					<?php echo $member->MemberHomeState; echo " "; echo $member->MemberHomePostcode;?></font></td>
				<td width="50%" align="right"><i><b>Ormond Ski Club</b></br> 1/175 Fitzroy St</br> FITZROY, Vic, 3065</br> email:
						general@ormondskiclub.com.au</br> web: www.ormondskiclub.com.au</br>
						ABN: 75004765753
						<p>Date issued: 30 November 2016</i></td>
			</tr>
		</table>
	</tr>
	<tr>
		<td>
			Dear <?php echo $this->items[0]->MemberFirstname;?>,<p>
			
			<p>
				This is your 2017 Subscription Notice for Ormond Ski Club with
				subscriptions due by <B>28th Feb 2017</B>. Please check the
				subscriptions below are correct and advise any errors or required
				changes. Early payment of subscriptions helps the Club pay for Work
				Parties and other maintenance costs and Subs need to be paid prior
				to being able to book for the 2017 Ski season.
		
		</td>
	</tr>
	<tr>
		<table width="100%" border="2">
			<td width="70%">
				<h3>2017 Membership Subscriptions</h3>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="60%">Description</th>
							<th width="20%">Amount</th>
							<th width="20%">Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Balance as of 30 Nov 2016</td>
							<td align="right">$<?php echo $this->currentbalance; ?>
						<?php $totalowing += $this->currentbalance;?></td>
							<td>$<?php $totalowed = sprintf("%05.2f",$totalowing); echo $totalowed;  ?></td>
						</tr>
						<tr>
							<td>
							<?php echo $member->MemberType;?> Membership
						</td>
							<td align="right">$<?php echo $this->membersubs; ?> <?php $totalowing -= $this->membersubs;?>
						</td>
							<td>$<?php $totalowed = sprintf("%05.2f",$totalowing); echo $totalowed;  ?></td>
						</tr>
					
						<?php if (!empty($this->familysubs)) : ?>
							<?php foreach ($this->familysubs as $i => $row) :?>
							<tr>
							<td>
									<?php echo $row->FamilyMembershipType;?> membership for <?php echo $row->FamilyMemberFirstname; echo " "; echo $row->FamilyMemberSurname;?>   </td>
							<td align="right">$<?php echo $row->Subsval;?>
									<?php $totalowing -= $row->Subsval;?>
								</td>
							<td>$<?php $totalowed = sprintf("%05.2f",$totalowing); echo $totalowed;  ?></td>
						</tr>
								<?php endforeach; ?>
						<?php endif; ?>
						
					
								<?php if (!empty($this->lockersubs)) : ?>
									<?php foreach ($this->lockersubs as $i => $row) :?>
						<tr>
							<td>
									 Subscription for Locker <?php echo $row->LockerNumber; ?>   </td>
							<td align="right">$<?php echo $row->LockerRate;?>
									<?php $totalowing -= $row->LockerRate;?>
								</td>
							<td>$<?php $totalowed = sprintf("%05.2f",$totalowing); echo $totalowed;  ?></td>
						</tr>
								<?php endforeach; ?>
						<?php endif; ?>
						
						<tr>
							<td>Balance due by <b>28th Feb 2017</b></td>
							<td>&nbsp;</td>
							<td align="right"><b>$<?php if ($totalowing < 0) $totalowing *= -1;  $totalowing = sprintf("%05.2f",$totalowing); echo $totalowing;?></b>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td width="30%" align="right" valign="top" border="1">
				<h3>How to pay:</h3> <b><i>Internet transfer</i></b></br> <b>BSB:</b>
				013279 <b></br> Account No:</b> 285414142</br> <i>Please put your
					name </br> in the description field!
			</i>
				<p>
				
				<p>
					<b><i>By Cheque</i></b></br>Payable to: <i>Ormond Ski Club</i></br>Send to: Membership Officer</br>
					7 Heatherlea Drive, </br>Wheelers Hill </br>Vic, 3150
			
			</td>
		</table>
	</tr>

	<tr>
		<h4>Member details</h4>
	</tr>
	<tr>
		<h4>Family member details</h4>
	</tr>

</table>
<?php 
// print_r($this->familysubs)
//print_r ( $this->currentbalance)?>
