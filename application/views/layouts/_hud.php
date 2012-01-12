<a class="btn dropdown-toggle" data-toggle="dropdown" data-target="#menu_hud">
	<?=greeting()?>, <?=$this->profile->current()->name->first?>! <b class="caret"></b>
</a>
<ul id="menu_hud" class="dropdown-menu">
	<li><a href="#">Dashboard</a></li>
	<li><a href="#">My Profile</a></li>
	<li class="divider"></li>
	<li><a href="#">Logout</a></li>
</ul>