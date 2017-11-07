<main id="login" class="container" style="background-color: #f9f9f9;">
	<h2>Connexion</h2>
  	<div class="row">
  		<form id="login-form" class="col-sm-10 col-md-10 col-lg-8 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 form-horizontal" action="" method="post">
  			<?php if(isset($this->view['error'])) { 

  				echo '<div class="alert alert-danger">'; 

  				if(isset($this->view['error']['mail'])) { echo $this->view['error']['mail']; }  			
  				if(isset($this->view['error']['password'])) { echo $this->view['error']['password']; } 
			
  	  		echo '</div>';
  	  	} ?>

        <div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4" for="confirmPassword">Adresse email</label>
          <div class="col-lg-8 col-md-6 col-sm-8">
            <input
              type="text"
              class="form-control"
              id="email"
              name="email"
              value="<?= (isset($_POST["email"]))?$_POST["email"]:"" ?>"
              placeholder="Votre adrese email"
            />
        </div>
      </div>
      <div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4" for="password">Mot de passe</label>
          <div class="col-lg-8 col-md-6 col-sm-8">
            <input
                type="password"
                id="password"
                class="form-control"
                name="password"
                value="<?= (isset($_POST["password"]))?$_POST["password"]:"" ?>"
                placeholder ="8 caractères minimum"
            />
          </div>
      </div>
      <div class="form-group col-lg-12 col-md-12">
        <div class="col-md-4 col-md-offset-4">
          <button class="btn btn-default" type="submit" name="login">Connexion</button>
        </div>
        <div class="col-md-3 col-md-offset-1 pull-right">
          <a href="/inscription">Déjà Inscrit(e) ?</a>
        </div>
      </div>

        <br><br><br>
        </form>
    </div>
</main>