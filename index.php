<?php
session_start();
include('database/database.php');
include('partials\header.php');
include('partials\sidebar.php');

// Your PHP BACK CODE HERE
$sql = "SELECT * FROM movies";
$movies = $conn->query($sql);


$rows_per_page = 5;
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $rows_per_page;
$sql = "SELECT * FROM movies LIMIT $rows_per_page OFFSET $offset";
$movies = $conn->query($sql);

$total_rows = $conn->query("SELECT COUNT(*) AS count FROM movies")->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $rows_per_page);

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Movie Information Management System</h1>
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
                <h5 class="card-title">Movie Table</h5>
              </div>
              <div>
                <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#add">Add Movies</button>
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
                  <th scope="col">Year_released </th>
                  <th scope="col">Description</th>
                  <th scope="col" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($movies->num_rows > 0): ?>
                  <?php while ($row = $movies->fetch_assoc()): ?>
                    <tr>
                      <th scope="row"><?php echo $row['id']; ?> </th>
                      <td><?php echo $row['title']; ?></td>
                      <td><?php echo $row['genre']; ?></td>
                      <td><?php echo $row['ratings']; ?></td>
                      <td><?php echo $row['year_released']; ?></td>
                      <td><?php echo $row['description']; ?></td>
                      <td class="d-flex justify-content-center">
                        <button class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editMovie_<?php echo $row['id']; ?>">Edit</button>
                        <!-- UPDATE MODAL -->
                        <div class="modal fade" id="editMovie_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editMovieLabel_<?php echo $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="database/update.php" method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editMovieLabel_<?php echo $row['id']; ?>">Edit Movie</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="mb-3">
                                                <label for="title_<?php echo $row['id']; ?>" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title_<?php echo $row['id']; ?>" name="title" value="<?php echo htmlspecialchars($row['title']); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="genre_<?php echo $row['id']; ?>" class="form-label">Genre</label>
                                                <input type="text" class="form-control" id="genre_<?php echo $row['id']; ?>" name="genre" value="<?php echo htmlspecialchars($row['genre']); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="ratings_<?php echo $row['id']; ?>" class="form-label">Ratings</label>
                                                <input type="text" class="form-control" id="ratings_<?php echo $row['id']; ?>" name="ratings" value="<?php echo htmlspecialchars($row['ratings']); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="year_released_<?php echo $row['id']; ?>" class="form-label">Year Released</label>
                                                <input type="text" class="form-control" id="year_released_<?php echo $row['id']; ?>" name="year_released" value="<?php echo htmlspecialchars($row['year_released']); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description_<?php echo $row['id']; ?>" class="form-label">Description</label>
                                                <textarea class="form-control" id="description_<?php echo $row['id']; ?>" name="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#viewMovie_<?php echo $row['id']; ?>">View</button>
                        <!-- VIEW MODAL -->
                        <div class="modal fade" id="viewMovie_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewMovieLabel_<?php echo $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="viewMovieLabel_<?php echo $row['id']; ?>">Movie Details</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-12 mt-2">
                                      <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                                    </div>
                                    <div class="col-12 mt-2">
                                      <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                                    </div>
                                    <div class="col-12 mt-2">
                                      <p><strong>Ratings:</strong> <?php echo htmlspecialchars($row['ratings']); ?></p>
                                    </div>
                                    <div class="col-12 mt-2">
                                      <p><strong>Year Released:</strong> <?php echo htmlspecialchars($row['year_released']); ?></p>
                                    </div>
                                    <div class="col-12 mt-2">
                                      <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteInfo_<?php echo $row['id']; ?>">Delete</button>
                        <!-- DELETE MODAL -->
                        <div class="modal fade" id="deleteInfo_<?php echo $row['id']; ?>" data-bs-backdrop="static"data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete_<?php echo $row['id']; ?>"aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <form action="database/delete.php" method="POST">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="deleteLabel_<?php echo $row['id']; ?>">Confirm Deletion
                                  </h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <p>Are you sure you want to delete this record?</p>
                                  <p><strong>This action cannot be undone.</strong></p>
                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endwhile; ?>>
                <?php endif; ?>
              </tbody>
            </table>
            <!-- End Default Table Example -->

          </div>
          <!-- Pagination -->
          <div class="mx-4">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item <?php if ($current_page <= 1)
                  echo 'disabled'; ?>">
                  <a class="page-link" href="?page=<?php echo max(1, $current_page - 1); ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                  <li class="page-item <?php if ($i == $current_page)
                    echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($current_page >= $total_pages)
                  echo 'disabled'; ?>">
                  <a class="page-link" href="?page=<?php echo min($total_pages, $current_page + 1); ?>">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

      </div>


    </div>


    <!-- Add Modal &Mae is here -->
    <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="addLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-cenetered">
        <form action="database/create.php" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addLabel">Add New Movie</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container">
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
                    <input type="text" name="year_released" id="year_released" class="form-control"
                      placeholder="Enter Year Released">
                  </div>
                  <div class="col-12 mt-2">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" class="form-control"
                      placeholder="Enter Description">
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
    <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="editInfoLabel" aria-hidden="true">
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