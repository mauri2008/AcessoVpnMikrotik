<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->

    <title>Sticky Footer Navbar Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dist/css/sticky-footer-navbar.css" rel="stylesheet">

    <style>
      .status {
            border-radius: 50%;
            display: inline-block;
            height: 20px;
            width: 20px;
            
            background-color: #00FF11;
        }
    </style>
    
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Fixed navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?= base_url()?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('index.php/geral')?>">Geral</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>
          </ul>
          <!-- <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form> -->
        </div>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
		<div class="container">
			<div class="row">
				<h1 class="text-center">Usuário online</h1>

				<table class="table" >
					<thead>
						<tr>
              <th>Status</th>
              <th>Nome</th>
              <th>Data</th>
							<th>Login</th>
							<!-- <th>Logout</th> -->
						</tr>
					</thead>
					<tbody id='tableLog'>


					</tbody>
				</table>
			</div>
		</div>
    </main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
    <!-- <script src="../../assets/js/vendor/popper.min.js"></script> -->
    <!-- <script src=dist/js/bootstrap.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<script>
    loadData();
    var timeInterval = null;
    timeInterval = setInterval(function() { loadData(); }, 15000);
     
      function loadData(){
        updateData();
        $('#tableLog').empty();
        $.ajax({
          url   :'<?= base_url('index.php/LoadData/ReturDataOn')?>',
          method:'POST',
          dataType:'JSON',
            success: function(data){
              for(var i=0; data.length >i; i++){
                var desconected = data[i].desconectado !=null? data[i].desconectado : '';
                $('#tableLog').append(
                  '<tr>'+
                    '<td><div class="status"></div></td>'+
                    '<td>'+data[i].usuario+'</td>'+
                    '<td>'+data[i].data.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1')+'</td>'+
                    '<td>'+data[i].conectado+'</td>'+
                    // '<td>'+desconected+'</td>'+
                  '</tr>')
              }           
            }          
        })
         
      }

      function updateData(){
        $.ajax({
          url :'index.php/LoadData',
          method: 'POST',
          dataType:'JSON',

        })
        return true;
      }
    </script>
  </body>
</html>
