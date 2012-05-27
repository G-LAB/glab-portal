<div class="btn-group floatr">
  <a class="btn dropdown-toggle" data-toggle="dropdown">
    <?=greeting()?>, <?=$this->profile->current()->name->first?>! <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
    <li><a href="<?=site_url('client_profile/me')?>">My Profile</a></li>
    <li><a href="<?=site_url('preferences')?>">Preferences</a></li>
    <li class="divider"></li>
    <li><a href="<?=site_url('login/destroy')?>">Logout</a></li>
  </ul>
</div>
<div class="clearfix"></div>