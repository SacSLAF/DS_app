<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Family Details Form</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="container mt-5">
      <div class="text-center mb-4">
        <h1 class="display-5 fw-bold">Divisional Secretariat - Colombo</h1>
        <p class="lead text-muted">Family Data Submission Form</p>
        <hr class="my-4" />
      </div>
    </div>

    <div class="container">
     <!-- Success Message -->
     <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data submitted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['success']) && $_GET['success'] == 0): ?>
            <!-- Failure Message -->
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Failed to submit data. Please try again later.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <div class="text-center">
            <a href="family-details.html" class="btn btn-primary">Go to Family details Submission Form</a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
