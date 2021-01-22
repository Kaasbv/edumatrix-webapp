<form method="post">
    <?php var_dump($_POST); ?>
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="Toepassen">
    <h3><?= $context->error ?? "" ?>
  </form>