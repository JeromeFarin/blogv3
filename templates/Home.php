<h1>Home Page</h1>

<p>It's home page</p>

<p>You find book list just <a href="/blogv3/book">HERE</a></p>

<?php
    if (!isset($_SESSION['id'])) {
        ?>
            <form action="/blogv3/login" method="post">
                <input type="text" name="user" placeholder="Username" required>
                <input type="password" name="pass" placeholder="Password" required>
                <input type="submit" value="Connection">
            </form>
        <?php
    } else {
        (new SecurityController())->check();
    }
?>