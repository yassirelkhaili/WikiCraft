<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../../public/dist/sandbox.js"></script>
    <title>Books Crud</title>
</head>
<body>
    <header>
    <h1>This is a crud example using SimpleORM + SimpleKit</h1>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary my-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Add Book
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Book</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/books/create" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Book name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="textHelp" name="name"> 
    <div id="textHelp" class="form-text">Write the book name here.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label|">Book email (huh)</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="email">
    <div id="emailHelp" class="form-text">Write the books email here.</div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    </header>
    <main>
    <table class="table table-bordered">
  <thead>
    <tr class="table-success">
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>    
    <?php foreach ($books as $key => $book): ?>
        <tr>
      <th scope="row"><?= $book["id"] ?></th>
      <td><?= $book["name"] ?></td>
      <td><?= $book["email"] ?></td>
      <td>
        <button type="button" class="btn btn-warning">Edit</button>
        <a href=<?= "/books/destroy/" . "{$book['id']}"?>>
        <button type="button" class="btn btn-danger">Delete</button>
        </a>
      </td>
    </tr>
        <?php endforeach; ?>
  </tbody>
</table>
<?php if (isset($_SESSION["success"])) : ?>
            <div class="alert alert-success" role="alert">
  <?= $_SESSION["success"] ?>
</div>
<?php endif; ?>      
<?php if (isset($_SESSION["error"])) : ?>
            <div class="alert alert-denger" role="alert">
  <?= $_SESSION["error"] ?>
</div>
<?php endif; ?>     
        </main>
    <footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    </footer>
</body>
</html>