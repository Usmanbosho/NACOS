<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NACOS ATBU - Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    body {
      background: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
    }
    .signup-container {
      max-width: 600px;
      margin: 30px auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .logo {
      display: block;
      margin: 0 auto 20px;
      width: 100px;
    }
    .form-control:focus {
      border-color: green;
      box-shadow: 0 0 0 0.2rem rgba(0, 128, 0, 0.25);
    }
    .btn-success {
      background-color: green;
      border: none;
    }
  </style>
</head>
<body>

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3 mx-auto w-75 text-center" role="alert" data-aos="fade-down">
      🎉 Registration successful! Welcome to NACOS ATBU.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="signup-container" data-aos="zoom-in">
    <img src="img/ictunitskillbuilderpayment.png" alt="NACOS Logo" class="logo">

    <h4 class="text-center mb-4">Student Sign-Up Form</h4>

    <form action="process_signup.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="profile_picture" class="form-label">Profile Picture (Max 1MB)</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" required accept="image/*">
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" required>
      </div>

      <div class="mb-3">
        <label for="reg_number" class="form-label">Registration Number</label>
        <input type="text" class="form-control" name="reg_number" required>
      </div>

      <div class="mb-3">
        <label for="course" class="form-label">Course</label>
        <select class="form-select" name="course" required>
          <option selected disabled>Select Course</option>
          <option>Computer Science</option>
          <option>Software Engineering</option>
          <option>Cyber Security</option>
          <option>Artificial Intelligence</option>
          <option>Information Technician</option>
          <option>Information Science</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="year_of_admission" class="form-label">Year of Admission</label>
        <input type="number" class="form-control" name="year_of_admission" min="2000" max="2099" required>
      </div>

      <div class="mb-3">
        <label for="level" class="form-label">Level</label>
        <select class="form-select" name="level" required>
          <option selected disabled>Select Level</option>
          <option>100 Level</option>
          <option>200 Level</option>
          <option>300 Level</option>
          <option>400 Level</option>
          <option>500 Level</option>
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-success px-4">Submit</button>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AOS JS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000 });

    // Optional auto