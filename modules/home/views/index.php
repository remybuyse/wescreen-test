<img src="public/img/header.jpg" style="width: 70%;height:800px;margin:auto;display:block; margin-top: -20px;">


<h1>Texte <?= $_SESSION['user']['prenom'] ?></h1>

<input type="text" id="searchMovie" name="searchMovie">
<input type="hidden" id="idMovie">



<?php if(!empty($this->view['allMovies'])): ?>
	<div class="row container col-md-8" style="margin:auto;">

	<?php foreach($this->view['allMovies'] as $movie): ?>

		<div class="col-md-8" style="margin:auto;">
			<img style="width: 100px;" src="https://image.tmdb.org/t/p/w640/<?= $movie['img'] ?>">
			<h3><?= $movie['title'] ?>
			<p>Note : <?= $movie['popularity'] ?> / 1000</p>

			<br>
			<p><?= $movie['overview'] ?></p>
		

	</div><br><br>
	<?php endforeach;	
endif; ?>

<script>
	// $('#searchMovie').autocomplete({
	// 	max:10,
	// 	source: function(requete, reponse) {
	// 		var settings = {
	// 		  "async": true,
	// 		  "crossDomain": true,
	// 		  "url": "https://api.themoviedb.org/3/search/multi?include_adult=false&page=1&query="+ $('#searchMovie').val() +"&language=fr-FR&sort_by=popularity.desc&api_key=cefb77c896541c52e2647edd2da146ab",
	// 		  "method": "GET",
	// 		  "headers": {},
	// 		  "data": "{}"
	// 		}

	// 		$.ajax(settings).done(function(response) {
	// 			console.log(response);
	// 			for(i = 0; i <= 10; i++) {
	// 				console.log(response.results[i].title);
	// 				console.log(response.results[i].id);
	// 				console.log('-----------------------');
	// 			}				
	// 		});
	// 	}
	// });
	var tableauResultats = [];
	var maxLength = 5;
	var chaine = $('#searchMovie').val().replace(' ','%20');
	$('#searchMovie').autocomplete({
		max:10,
		source: function(term, response){
	        $.getJSON('https://api.themoviedb.org/3/search/multi?include_adult=false&page=1&query='+ $('#searchMovie').val() +'&language=fr-FR&sort_by=popularity.desc&api_key=cefb77c896541c52e2647edd2da146ab', 
	        	{ q: term }, function(data){
	        	console.log(chaine);
	        	 console.log(data);
	        	if(data.results > 6) {
	        		maxLength = 6;
	        	} else {
	        		maxLength = data.results.length;
	        	}
	        	console.log(maxLength);
	        	for(i = 0; i < maxLength; i++) {
	        		if(data.results[i].title != 'undefined') {
	        			tableauResultats.push(data.results[i].title + ' (' + data.results[i].release_date + ')');
		 				console.log(data.results[i].title);
		 				console.log(data.results[i].id);
		 				console.log('-----------------------');
		 				
	        		}

	        		 
	        		
	 			}
	        	response(tableauResultats); 
	        });
	    }
	});		
</script>
	
