
<?php

if(!empty($_GET['searchaddress'])){
	$searchaddress = $_GET['searchaddress']; 
	$searchaddress_final = str_replace(' ', '%20', $searchaddress);
}
else {
	$searchaddress = 'Your Zipcode'; 
	$searchaddress_final = '18111%20Nordhoff%20St.%20Northridge%20CA'; 
}

// function rand_color() {
//     return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
// }
// <body style="background-color: <?php echo rand_color();

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>findmyREPS </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<link href="https://fonts.googleapis.com/css?family=Lobster|Space+Mono:400,700" rel="stylesheet">


</head>
<body>
<!-- navbar -->
<!--    <div class="navbar-fixed-top navbar-inverse">
      <div class="container-fluid">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
          <!THIS IS WHAT YOUR ICON WILL BE -->
        <!--   MENU
        </button> --> 

        <!-- start of nav text -->
<!--         <div class="collapse navbar-collapse navHeaderCollapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#home">home</a></li>
            <li><a href="#about">about</a></li>
            <li><a href="#education">education</a></li>
            <li><a href="#photos">photos</a></li>
            <li><a href="#contact">contact</a></li>
          </ul>
        </div>
      </div>
    </div> -->
	<nav class="navbar">
		<div class="navbar-brand">
			<p> findmyREPS</p>
		</div>
		
	</nav> 
<!-- end navbar-->

<!-- jumbotron -->
	<div class="jumbotron">
		<h1> We're here to find your representatives! </h1>
	</div>
	<div class="container">
		<!-- <div class="row"> -->
		      <form action="" method="GET">
			<label for="searchaddress">What's your location?</label>
				<input type="text" class="form-control" id="searchaddress" name="searchaddress" value="<?php echo $searchaddress; ?>">
				<button class="btn btn-info btn-sm">Search</button>

			</form>
		<!-- </div> -->
	</div>
<!-- end jumbotron -->


	<div class="cards">

	<!-- search form was here -->

			<?php

				$data = json_decode(file_get_contents('https://www.googleapis.com/civicinfo/v2/representatives?key=AIzaSyCjji7mmf4M00AdbiVWSJcIgU_3I3YXhNQ&address='.$searchaddress_final));

				// setup blank array
				$jobs = [];
				// loop through each office 
				foreach ($data->offices as $office) {
					// loop through each officialIndices array
			    if (isset($office->officialIndices)) {
			  		foreach ($office->officialIndices as $officialIndices) {
			  			$jobs += [ $officialIndices => $office->name];
			  		}
			    }
				}
				// print_r($jobs);

			// setup count
			$i = 0;

// style="background-image: url(../images/background3.png)" background-repeat: no-repeat; background-size: 100%;>'
	echo '<div class="container-fluid main">';
	echo '<div id="results" class="container card-section">';
	echo '<div class="row">';
			// loop through officials
			foreach ($data->officials as $person) {
				// print_r($person);	
				echo '<div class="col-lg-3 col-md-4 col-sm-12">';			
				echo '<div class="card" style="width: 100%">';	
				echo '<div class="card-block">';
				// echo '<button data-toggle="collapse" data-target="#info">'.$person->name.'</button>';
				echo '<div class="card-header">';
				echo '<h3>'.$person->name.'</h3>';
				echo '</div>';
				echo '<h6>'.$jobs[$i].'</h6>';
				echo '<img src="'.(isset($person->photoUrl)? $person->photoUrl : '../images/placeholder2.png').'" alt="'.$person->name.'" class="img-fluid">';
				// echo '<div id="info" class="collapse">';
				echo '<p> Party:'.(isset($person->party)? $person->party :'Not Listed').'</p>';
				echo '<ul class="list-group">';
				echo '<li class="list-group-item">'.(isset($person->phones[0])? $person->phones[0] :'Not Listed').'</li>';
				echo '<li class="list-group-item"><a href="'.(isset($person->urls[0])? $person->urls[0] :'Not Listed').'" target="blank">website</a></li>';
				echo '<li class="list-group-item">
					'.(isset($person->address[0])? $person->address[0]->line1 :'Address not listed').'
					'.(isset($person->address[0]->line1)? '</br>' :'').'
					'.(isset($person->address[0])? $person->address[0]->line2 :'').'
					'.(isset($person->address[0]->line2)? '</br>' :'').'
					'.(isset($person->address[0])? $person->address[0]->city :'').', 
					'.(isset($person->address[0])? $person->address[0]->state :'').' 
					'.(isset($person->address[0])? $person->address[0]->zip :'').'
				  </li>';

				echo '</div>';
				echo '</div>';
				echo '</div>';
				// echo '</div>';

			// add 1 count to $i;
			$i++;
			}
	echo '</div>';
	echo '</div>';
	echo '</div>';

			?>
	</div>

	<footer>
		<div class="container-fluid-footer">
			<h5><a href="#"> Back to Top</a></h5>
		</div>
	</footer>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  <script>
  $(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
  </script>
</body>
</html> 
