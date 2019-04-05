<h1>Book List</h1>
<a href="/blogv3/">Back</a>
<br>
<br>

<?php 
    foreach ($data as $key => $value) {

        $book = [];
        
        foreach ($value::getInfo()["columns"] as $column => $property) {
            $book[$column] = $value->{sprintf("get%s", ucfirst($property))}();
        }

        ?>
            <li><a href="/blogv3/book/<?= $book['id'] ?>"><?= $book['name'] ?></a></li>
        <?php 
    } 
?>
<br>
<form method="post">
    <input type="text" name="name" placeholder="Name of book" required>
    <input type="text" name="owner" placeholder="Owner of book" required>
    <input type="submit" value="Create new book">
</form>