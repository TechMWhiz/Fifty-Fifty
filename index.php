<?php
 session_start();
  include('database/database.php');
  include('partials\header.php');
  include('partials\sidebar.php');

  // Your PHP BACK CODE HERE
  $sql = "SELECT * FROM movies";
  $movies = $conn->query($sql);

?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Employee Information Management System</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">General</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title">Default Table</h5>
                </div>
                <div>
                  <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#add">Add Employee</button>
                </div>
              </div>

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Ratings</th>
                    <th scope="col">Year_released	</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>   
                  <?php if ($movies->num_rows > 0): ?>
                    <?php while($row = $movies->fetch_assoc()): ?>
                      <tr>
                        <th scope="row"><?php echo $row['id'];?> </th>
                        <td><?php echo $row['title'];?></td>
                        <td><?php echo $row['genre'];?></td>
                        <td><?php echo $row['ratings'];?></td>
                        <td><?php echo $row['year_released'];?></td>
                        <td><?php echo $row['description'];?></td>
                        <td class="d-flex justify-content-center">
                          <button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editInfo">Edit</button>
                          <!-- UPDATE MODAL -->

                          <button class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#viewInfo">View</button>
                          <!-- VIEW MODAL -->

                          <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editInfo">Delete</button>
                          <!-- DELETE MODAL -->

                        </td>
                      </tr>
                    <?php endwhile; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="6" class="text-center">No No movies found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <!-- End Default Table Example -->

            </div>
            <div class="mx-4">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
              </nav>
            </div>
          </div>

        </div>

        
      </div>


      <!-- Add Modal &Mae is here -->
      <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class = "modal-dialog modal-dialog-cenetered">
          <form action="database/create.php" method="POST">
            <div class = "modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="addLabel">Add New Movie</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
             <div class="modal-body">
               <div class = "container">
                  <div class="row">
                    <div class="col-12 mt-2">
                      <label for="title">Title</label>
                      <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="col-12 mt-2">
                      <label for="genre">Genre</label>
                      <input type="text" name="genre" id="genre" class="form-control" placeholder="Enter Genre">
                    </div>
                    <div class="col-8 mt-2">
                      <label for="ratings">Ratings</label>
                      <input type="text" name="ratings" id="ratings" class="form-control" placeholder="Enter Ratings">
                    </div>
                    <div class="col-8 mt-2">
                      <label for="year_released">Year_released</label>
                      <input type="text" name="year_released" id="year_released" class="form-control" placeholder="Enter Year Released">
                    </div>
                    <div class="col-12 mt-2">
                      <label for="description">Description</label>
                      <input type="text" name="description" id="description" class="form-control" placeholder="Enter Description">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="editInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editInfoLabel">Employee Information</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php
include('partials\footer.php');
?>