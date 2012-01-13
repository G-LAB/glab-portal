<div class="btn-group floatr">
	<a class="btn dropdown-toggle" data-toggle="dropdown">
		<?=greeting()?>, <?=$this->profile->current()->name->first?>! <b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
		<li><a href="#">Dashboard</a></li>
		<li><a href="#">My Profile</a></li>
		<li class="divider"></li>
		<li><a href="#">Logout</a></li>
	</ul>
</div>
<div class="clearfix"></div>