<!DOCTYPE html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $context->windowTitle ?? "EduMatrix" ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/main.css">  
    <link rel="stylesheet" href="/dashboard.css">
    <link rel="stylesheet" href="/rooster.css">
  </head>
  <body>
    <nav><?= $this -> renderSubView("header") ?></nav>
    <aside><?= $this -> renderSubView("sidemenu") ?></aside>
    <main>
      <div class="contentcontainer">
        <div id="content"><?= $content ?></div>
        <footer><?= $this -> renderSubView("footer") ?></footer>
      </div>
    </main>
  </body>
</html>