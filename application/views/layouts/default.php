<!doctype html>
<!--[if IE 6]><![endif]-->
<html lang="en-us">
<head>
  <?=$template['partials']['headers']?>
  <?=$template['metadata']?>
</head>
<body id="default" class="<?=strtolower($this->router->fetch_class().' '.$this->router->fetch_method())?>">
  <div class="container">
    <header id="header">
      <?=$template['partials']['menu']?>
    </header>
    <div id="main">
      <section>
        <header class="row">
          <div class="span9">
            <h1>
              <?=htmlspecialchars(controller_name())?>
              <small>
              <?php
                if ($template['title'] !== ' ')
                {
                  echo htmlspecialchars($template['title']);
                }
                elseif (strtolower(method_name()) !== 'index')
                {
                  echo htmlspecialchars(method_name());
                }
              ?>
              </small>
            </h1>
          </div>
          <div id="user" class="span3">
            <?=$template['partials']['user']?>
          </div>
        </header>
        <div class="row">
          <div id="alerts" class="span12">
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