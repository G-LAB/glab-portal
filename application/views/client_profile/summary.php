<!-- BEGIN Contact Info -->
<div class="vcard">
	<span class="fn hide"><?=$profile->name->full?></span>
	<div class="row">
		<div class="span2 offset6">
			<a class="thumbnail" id="profile_picture">
				<img src="<?=gravatar_url($profile->email,130,'mm')?>" alt="Profile Photo">
			</a>
		</div>
	</div>
	<div class="row">
		<section id="email" class="span3">
			<h2>
				Email
				<small>
					<a class="action-email-add" title="Add an Email Address"><i class="icon-plus"></i></a>
				</small>
			</h2>
			<ul class="nav nav-tabs nav-stacked">
				<?php foreach ($profile->email->fetch_array(5) as $email): ?>
				<li class="email"><a><?=$email?></a></li>
				<?php endforeach; ?>
			</ul>
		</section>
		<section id="telephone" class="span3">
			<h2>
				Telephone
				<small>
					<a class="action-tel-add" title="Add a Telephone Number"><i class="icon-plus"></i></a>
				</small>
			</h2>
			<ul class="nav nav-tabs nav-stacked">
				<?php foreach ($profile->tel->fetch_array(5) as $tel): ?>
				<li class="tel">
					<span class="hide type"><?=$tel->type?></span>
					<a><?=tel_format($tel)?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</section>
		<section id="address" class="span6">
			<h2>
				Address
				<small>
					<a class="action-address-add" title="Add an Address"><i class="icon-plus"></i></a>
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
					<div class="tab-pane" id="address_<?=$key?>">
						<div class="span4">
							<a class="thumbnail">
								<img src="http://maps.googleapis.com/maps/api/staticmap?size=500x230&amp;markers=size:normal|<?=urlencode(preg_replace("/\n/", ' ', $address))?>&amp;center=<?=urlencode(preg_replace("/\n/", ' ', $address))?>&amp;zoom=18&amp;sensor=false" alt="Street View">
							</a>
							<div class="row address">
								<div class="span3">
									<address class="adr">
										<span class="hide type"><?=$address->type?></span>
										<span class="street-address"><?=$address->street_address_1?></span><br>
										<?php if (empty($address->street_address_2) !== true): ?> <span class="street-address"><?=$address->street_address_2?></span><br><?php endif; ?>
										<span class="locality"><?=$address->locality?></span>, <span class="region"><?=$address->region?></span>, <span class="postal-code"><?=$address->postal_code?></span> <span class="country-name"><?=$address->country_id?></span>
									</address>
								</div>
								<div class="span1 justc">
									<a href="#" data-placement="bottom" title="View Map"><i class="icon-map-marker"></i></a>
									<a href="#" data-placement="bottom" title="Directions"><i class="icon-road"></i></a>
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
	<section id="managers" class="span12">
		<h2>
			Account Managers
			<small>
				<a class="action-manager-add" title="Add an Account Manager"><i class="icon-plus"></i></a>
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