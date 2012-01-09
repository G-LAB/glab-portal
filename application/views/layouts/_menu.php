<?php
	/**
	 * Menu Entry
	 * @author Ryan Brodkin
	 **/
	class Menu_Entry
	{
		private $data;

		function __construct($path)
		{
			$this->data['path'] = $path;
		}

		function __get($key)
		{
			return element($key,$this->data);
		}

		function __set($key,$value)
		{
		}
	}

	$menu = array();
	$menu['Dashboard'] = new Menu_Entry ('dashboard',false);

	if ($this->acl->is_permitted('module_communication') === true) 
	{
		$menu['Communication'] = new Menu_Entry ('communication');
	}
	if ($this->acl->is_permitted('module_documents') === true) 
	{
		$menu['Documents'] = new Menu_Entry ('documents');
	}
	if ($this->acl->is_permitted('module_documents') === true) 
	{
		$menu['Documents'] = new Menu_Entry ('documents');
	}
	if ($this->acl->is_permitted('module_accounting') === true) 
	{
		$menu['Accounting'] = new Menu_Entry ('accounting');
	}
	if ($this->acl->is_permitted('module_product_domains') === true) 
	{
		$menu['Products']['Domain Names'] = new Menu_Entry ('products/domain_names');
	}
	if ($this->acl->is_permitted('module_product_hosting') === true) 
	{
		$menu['Products']['Web Hosting'] = new Menu_Entry ('products/web_hosting');
	}
	if ($this->acl->is_permitted('module_sales') === true) 
	{
		$menu['Sales'] = new Menu_Entry ('sales_tools');
	}
?>
<div class="topbar" data-dropdown="dropdown">
	<div class="topbar-inner">
		<div class="container">
			<h3><a href="<?=site_url()?>">G LAB</a></h3>
			<?php if ($this->acl->is_auth() === true) : ?>
				<ul>
				<?php foreach ($menu as $label => &$primary) : ?>
						<?php if (is_array($primary) === true && count($primary) === 0) : continue; ?>
						<?php elseif (is_array($primary) === true) : ?>
						<li class="menu">
							<a class="menu"><?=htmlspecialchars($label)?></a>
							<ul class="menu-dropdown">
								<?php foreach ($primary as $label => &$secondary): ?>
								<li><a href="<?=site_url($secondary->path)?>"><?=htmlspecialchars($label)?></a></li>
								<?php endforeach; ?>
							</ul>
						</li>
						<?php else : ?>
						<li><a href="<?=site_url($primary->path)?>"><?=htmlspecialchars($label)?></a></li>
						<?php endif; ?>
				<?php endforeach; ?>
				</ul>
				<ul class="nav secondary-nav">
					<li>
						<form action="">
							<input type="text" placeholder="Search for anything...">
						</form>
					</li>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</div>