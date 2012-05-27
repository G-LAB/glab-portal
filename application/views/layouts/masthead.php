<!doctype html>
<!--[if IE 6]><![endif]-->
<html lang="en-us">
<head>
  <?=$template['partials']['headers']?>
  <?=$template['metadata']?>
</head>
<body id="masthead" class="<?=strtolower($this->router->fetch_class().' '.$this->router->fetch_method())?>">
  <div class="container">
    <header id="header">
      <?=$template['partials']['menu']?>
    </header>
    <div id="main">
      <section>
        <div id="heading" class="row">
          <div class="span10 offset1">
            <h1><?=htmlspecialchars($template['title'])?></h1>
          </div>
        </div>
        <div class="row">
          <div class="span10 offset1">
            <?php foreach (User_Notice::fetch_array() as $notice) : ?>
            <div class="alert alert-<?=$notice->type?>">
              <a class="close">×</a>
              <strong><?=$notice->title?></strong> <?=$notice->msg?>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?=$template['body']?>
      </section>

    </div>
    <footer id="footer">
      <?=$template['partials']['footer']?>
    </footer>
  </div>
  <?=$template['partials']['global']?>
</body>
</html>