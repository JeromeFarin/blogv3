<?php 
    foreach ($data as $key => $value) {

        $book = [];
        
        foreach ($value::getInfo()["columns"] as $column => $property) {
            $book[$column] = $value->{sprintf("get%s", ucfirst($property))}();
        }
    } 
?>

<h1><?= $book['name'] ?></h1>
<a href="/blogv3/book">Back</a>

<p><?= $book['owner'] ?></p>

<form method="post">
    <input type="hidden" name="id" value="<?= $book['id'] ?>"><br>
    <input type="text" name="name" value="<?= $book['name'] ?>"><br>
    <input type="text" name="owner" value="<?= $book['owner'] ?>"><br>
    <input type="submit" value="Edit book"><br>
    <input type="submit" name="delete" onclick="return confirm('Are you sure to delete this book ?');" value="Delete book">
</form>
