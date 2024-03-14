
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Sticky Footer Navbar Template for Bootstrap</title>

    <link rel="canonical" href="sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
  </head>

  <body>
  <?php
 $name = $_POST['name'];
  $email = $_POST['email'];
  $reply_t0="Reply to: $email";
  $message = $_POST['message'];
  $to = 'jithin.jose@itas.ca';

	$email_subject = "Eamil : $email  ";

	$email_body = "You have received a new message from the user $name.\n".
                            "Here is the message:\n $message";

                            mail($to,$email_subject,$email_body,$reply_t0);

  ?> 

    <header>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
              <a class="navbar-brand" href="index.html">JJTech</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="Pricing.html">Pricing</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="contact.html">Contact</a>
                  </li>
                </ul>
                  
              </div>
            </nav>
          </header>

     <br><br><br>
    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">Thank You for you call back request</h1>
      <p class="lead">We just received you call back request. One of our Technician will get back to you about 
          the enquiry as soon as possibble. 
      </p>
    </main>

    <footer class="footer">
      <div class="container">
        <p>&copy; 2017-2018 Company, Inc. &middot; <a href="contact.html">Contact us</a> &middot; </p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
