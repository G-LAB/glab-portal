<div class="row">
  <div class="span6">
    Copyright &copy; 2009-<?=date('Y')?> G LAB. &nbsp;All rights reserved.
  </div>
  <div class="span6 justr">
    <?=(ENVIRONMENT == 'development') ? shell_exec('cd '.APPPATH.' && git name-rev --name-only HEAD').'/' : 'Revision'?>
    <?=shell_exec('cd '.APPPATH.' && git rev-parse --short HEAD')?>
  </div>
</div>