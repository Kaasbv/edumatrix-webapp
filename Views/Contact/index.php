<form method="post" action="/contact/aanmaken">
  <input placeholder="naam" type="text" name="naam"><br>
  <input placeholder="bericht" type="text" name="bericht"><br>
  <input type="submit" value="Submit">
</form>

<p><?= $context->message ?></p>