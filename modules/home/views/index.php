<img src="public/img/header.jpg" style="width: 70%;height:800px;margin:auto;display:block; margin-top: -20px;">


<h1>Texte <?= $_SESSION['user']['prenom'] ?></h1>



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
	
