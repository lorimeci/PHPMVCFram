<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>ZenBlog</title>
   <meta content="" name="description">
   <meta content="" name="keywords">
   <!-- Favicons -->
   <link href="/assets/img/favicon.png" rel="icon">
   <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
   <!-- Vendor CSS Files -->
   <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
   <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
   <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
   <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
   <!-- Template Main CSS Files -->
   <link href="/assets/css/variables.css" rel="stylesheet">
   <link href="/assets/css/main.css" rel="stylesheet">
</head>

<body>
   <!-- ======= Header ======= -->
   <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
         <a href="/" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="/assets/img/logo.png" alt="Logo">
            <h1>ZenBlog</h1>
         </a>
         <nav id="navbar" class="navbar">
            <ul>
               <li><a href="/">Blog</a></li>
               <li><a href="/">Single Post</a></li>

               <?php if (isLoggedIn() && isAdmin() || isCreator()) :  ?>
                  <a href="/profile?id=<?= getUser()['id'] ?>">Profile</a>
                  <a href="/logout">Logout</a>
                  <li><a href="/dashboard">Dashboard </a></li>
                  <?php elseif (isLoggedIn()) :  ?>
                        <a href="/profile?id=<?= getUser()['id'] ?>">Profile </a>
                           <a href="/logout">Logout <?//= getUser()['firstname'] ?> <?//= getUser()['lastname'] ?></a>
                  <?php else :  ?>
                     <li><a href="/register">Register</a></li>
                     <li><a href="/login">Login</a></li>
                  <?php endif; ?>
            </ul>
         </nav>
         <!-- .navbar -->
         <div class="position-relative">
            <!-- <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
            <i class="bi bi-list mobile-nav-toggle"></i> -->
            <!-- ======= Search Form ======= -->
            <!-- End Search Form -->
         </div>
      </div>
   </header>
   <!-- End Header -->
   <main id="main">
      <?php if (getFlash('success')) : ?>
         <div class="alert alert-success">
            <?php echo getFlash('success') ?>
         </div>
         <?php elseif (getFlash('error')) : ?>
            <div class="alert alert-danger">
            <?php echo getFlash('error') ?>
         </div>
      <?php endif; ?>
      {{content}}
   </main>
   <!-- End #main -->
   <!-- ======= Footer ======= -->
   <footer id="footer" class="footer">
      <div class="footer-legal">
         <div class="container">
            <div class="row justify-content-between">
               <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                  <div class="copyright">
                     © Copyright <strong><span>ZenBlog</span></strong>. All Rights Reserved
                  </div>
                  <div class="credits">
                     <!-- All the links in the footer should remain intact. -->
                     <!-- You can delete the links only if you purchased the pro version. -->
                     <!-- Licensing information: https://bootstrapmade.com/license/ -->
                     <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </footer>
   <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
   <!-- Vendor JS Files -->
   <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
   <script src="/assets/vendor/glightbox/js/glightbox.min.js"></script>
   <script src="/assets/vendor/aos/aos.js"></script>
   <script src="/assets/vendor/php-email-form/validate.js"></script>
   <!-- Template Main JS File -->
   <script src="/assets/js/main.js"></script>
</body>

</html>