<h1>Skopiuj podany kod i wykonaj go w konsoli na stronie: <a href="http://www.polishdrinkgame.com/">polishDrinkGame</a></h1>
<pre class="p-3 content">
    <code>
gameId = <?php echo $_GET['gameId'] ?>;
<?php readfile("code.js"); ?>
    </code>
</pre>
<form action="" method="get" class="row">
    <input type="hidden" name="username" value="<?php echo $_GET['username'] ?>">
    <input type="hidden" name="gameId" value="<?php echo $_GET['gameId'] ?>">
    <div class="col text-center">
        <button type="submit" class="btn btn-primary">Kod dodany</button>
    </div>
</form>