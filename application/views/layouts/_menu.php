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

  if ($this->acl->is_allowed('portal_communication') === true)
  {
    $menu['Communication'] = new Menu_Entry ('communication');
  }
  if ($this->acl->is_allowed('portal_documents') === true)
  {
    $menu['Documents'] = new Menu_Entry ('documents');
  }
  if ($this->acl->is_allowed('portal_documents') === true)
  {
    $menu['Documents'] = new Menu_Entry ('documents');
  }
  if ($this->acl->is_allowed('portal_accounting') === true)
  {
    $menu['Accounting'] = new Menu_Entry ('accounting');
  }
  if ($this->acl->is_allowed('portal_product_domains') === true)
  {
    $menu['Products']['Domain Names'] = new Menu_Entry ('products/domain_names');
  }
  if ($this->acl->is_allowed('portal_product_hosting') === true)
  {
    $menu['Products']['Web Hosting'] = new Menu_Entry ('products/web_hosting');
  }
  if ($this->acl->is_allowed('portal_sales') === true)
  {
    $menu['Sales'] = new Menu_Entry ('sales_tools');
  }
?>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a href="<?=site_url()?>" class="brand"><span>G LAB</span></a>
      <div class="nav-collapse">
        <?php if ($this->acl->is_auth() === true) : ?>
        <ul class="nav">
          <?php foreach ($menu as $label => &$primary) : ?>
          <?php if (is_array($primary) === true && count($primary) === 0) : continue; ?>
          <?php elseif (is_array($primary) === true) : ?>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown"><?=htmlspecialchars($label)?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
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
        <form class="navbar-search pull-right" action="">
          <input type="text" class="search-query span2" placeholder="Search">
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>