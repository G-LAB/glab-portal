<!-- BEGIN Contact Info -->
<div class="vcard">
	<span class="fn hide"><?=$profile->name->full?></span>
	<div class="row">
		<div class="span2 offset6">
			<a class="thumbnail" id="profile_picture">
				<img src="<?=gravatar_url($profile->email,160,'mm')?>" alt="Profile Photo">
			</a>
		</div>
	</div>
	<div class="row">
		<section id="email" class="span3">
			<h2>
				Email
				<small>
					<i data-action="email-add" title="Add an Email Address" class="icon-plus"></i>
				</small>
			</h2>
			<ul class="nav nav-tabs nav-stacked">
				<?php foreach ($profile->email->fetch_array(5) as $email): ?>
				<li class="email">
					<a>
						<?=$email?>
						<div class="actions pull-right">
							<i data-action="email-send" class="icon-envelope" title="Send Message"></i>
							<i data-action="email-remove" class="icon-remove" title="Remove Email Address"></i>
						</div>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</section>
		<section id="telephone" class="span3">
			<h2>
				Telephone
				<small>
					<i data-action="tel-add" title="Add a Telephone Number" class="icon-plus"></i>
				</small>
			</h2>
			<ul class="nav nav-tabs nav-stacked">
				<?php foreach ($profile->tel->fetch_array(5) as $tel): ?>
				<li class="tel">
					<span class="hide type"><?=$tel->type?></span>
					<a>
						<?=tel_format($tel)?>
						<div class="actions pull-right">
							<i data-action="tel-call" class="icon-share" title="Click to Call"></i>
							<i data-action="tel-remove" class="icon-remove" title="Remove Telephone Number"></i>
						</div>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</section>
		<section id="address" class="span6">
			<h2>
				Address
				<small>
					<i data-action="address-add" title="Add an Address" class="icon-plus"></i>
				</small>
			</h2>
			<div class="tabbable tabs-left">
				<?php $addresses = $profile->address->fetch_array() ?>
				<ul class="nav nav-tabs">
					<?php foreach ($addresses as $key=>$address): ?>
					<li><a href="#address_<?=$key?>" data-toggle="tab"><i class="icon-home"></i> <?=strtolower($address->locality)?></a></li>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active help-block">
						<i class="icon-arrow-left"></i>
						<em>Select a city to see the address.</em>
					</div>
					<?php foreach ($addresses as $key=>$address): ?>
					<div class="tab-pane" id="address_<?=$key?>" data-address="<?=htmlspecialchars($address->string())?>">
						<div class="span4">
							<a data-action="modal-map" data-address="#address_<?=$key?>" class="thumbnail">
								<img src="http://maps.googleapis.com/maps/api/staticmap?size=500x230&amp;markers=size:normal|<?=htmlspecialchars($address->string())?>&amp;zoom=16&amp;sensor=false" alt="Map">
							</a>
							<div class="row address">
								<div class="span3 adr">
									<span class="hide type"><?=$address->type?></span>
									<address>
										<span class="street-address"><?=$address->street_address_1?></span><br>
										<?php if (empty($address->street_address_2) !== true): ?> <span class="street-address"><?=$address->street_address_2?></span><br><?php endif; ?>
										<span class="locality"><?=$address->locality?></span>, <span class="region"><?=$address->region?></span>, <span class="postal-code"><?=$address->postal_code?></span> <span class="country-name"><?=$address->country_id?></span>
									</address>
								</div>
								<div class="span1 justc">
									<i data-action="modal-map" data-address="#address_<?=$key?>" data-placement="bottom" title="View Map" class="icon-map-marker"></i>
									<i data-action="modal-directions" data-address="#address_<?=$key?>" data-placement="bottom" title="Directions" class="icon-road"></i>
									<i data-action="address-remove" data-placement="bottom" title="Remove Address" class="icon-remove"></i>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- END Contact Info -->
<!-- BEGIN Managers -->
<div class="row">
	<section id="manager" class="span12">
		<h2>
			Account Managers
			<small>
				<i data-action="manager-add" title="Add an Account Manager" class="icon-plus"></i>
			</small>
		</h2>
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Job Title</th>
					<th>Permissions</th>
					<th class="justr">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($profile->manager->fetch_array(4) as $manager) : ?>
				<tr>
					<td>
						<?=profile_link($manager->profile->pid)?>
					</td>
					<td>
						<?=$manager->title?>
					</td>
					<td>
						Full Access
					</td>
					<td class="justr">
						<a href="<?=profile_url($manager->profile->pid)?>" class="btn btn-mini"><i class="icon-user"></i> View Profile</a>
						<button class="btn btn-mini btn-danger" data-action="revoke"><i class="icon-remove icon-white"></i> Revoke Access</button>
					</td>
				</tr>
				<?php endforeach; ?>
				<tr class="message-empty">
					<td colspan="4">This profile has no managers. <a class="action-manager-add">Add one?</a></td>
				</tr>
			</tbody>
		</table>
	</section>
</div>
<!-- END Managers -->