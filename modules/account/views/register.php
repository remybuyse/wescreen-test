<main id="signup" class="container" style="background-color: #f9f9f9;">
	<h2>Inscription</h2>
  	<div class="row">
  		<form id="signup-form" class="col-sm-10 col-md-10 col-lg-8 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 form-horizontal" action="" method="post">
  			<?php if(isset($this->view['error'])) {
  				echo '<div class="alert alert-danger">'; 

  				if(isset($this->view['error']['gender'])) { echo $this->view['error']['gender']; }  			
  				if(isset($this->view['error']['firstname'])) { echo $this->view['error']['firstname']; } 
  				if(isset($this->view['error']['lastname'])) { echo $this->view['error']['lastname']; } 
  				if(isset($this->view['error']['email'])) { echo $this->view['error']['email']; } 
  				if(isset($this->view['error']['mdp'])) { echo $this->view['error']['mdp']; } 
  				if(isset($this->view['error']['confirmmdp'])) { echo $this->view['error']['confirmmdp']; } 
  	  		
  	  			echo '</div>';
  	  		} ?>

  			<!-- gender, firstname, lastname, email, password, confirmpassword -->
			<div class="form-group">
	  			<label id="gender" class="col-lg-4 col-md-4 col-sm-4 control-label" for="gender">Genre</label>
	  			<div class="col-lg-8 col-md-6 col-sm-8">
	                <input type="radio" name="gender" value="Mme" /> Homme
	                <input type="radio" name="gender" value="Mr" /> Femme
	            </div>
	        </div>

	  		<div class="form-group">
	  			<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="firstName">Prénom</label>
	  			<div class="col-lg-8 col-md-6 col-sm-8">
		  			<input
				        type="text"
				        id="firstName"
				        class="form-control"
				        name="firstName"
				        value="<?= (isset($_POST["firstName"]))?$_POST["firstName"]:"" ?>"
				        placeholder="Votre prénom"
					/>
				</div>
	  		</div>
	  		<div class="form-group">
	  			<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="lastName">Nom</label>
	  			<div class="col-lg-8 col-md-6 col-sm-8">
		  			<input
				        type="text"
				        id="lastName"
				        class="form-control"
				        name="lastName"
				        value="<?= (isset($_POST["lastName"]))?$_POST["lastName"]:"" ?>"
				        placeholder="Votre nom de famille"
					/>
				</div>
	  		</div>
	  		<div class="form-group">
	  			<label class="col-lg-4 col-md-4 col-sm-4 control-label" for="email">Email</label>
	  			<div class="col-lg-8 col-md-6 col-sm-8">
		  			<input
				        type="text"
				        id="email"
				        class="form-control"
				        name="email"
				        value="<?= (isset($_POST["email"]))?$_POST["email"]:"" ?>"
				        placeholder="Votre adresse mail valide"
					/>
				</div>
	  		</div>
	  		<div class="form-group">
	  			<label class="control-label col-lg-4 col-md-4 col-sm-4" for="birthdate">Date de naissance</label><br>
	  			<div class="col-lg-8 col-md-6 col-sm-8">
                    <select id="day" class="" name="day">
                        <?php for ($jour = 1 ; $jour <= 31 ; $jour++) {
                            if($jour<10) { ?>
                            	<option value="<?= '0'.$jour ?>"><?= '0'.$jour; ?></option>
                            <?php }
                            else { ?>
                                <option value="<?= $jour ?>" ><?= $jour ?></option>
                        	<?php }
                        } ?>
                    </select>
                    <select id="month" class="" name="month">
                        <?php for ($mois = 1 ; $mois <= 12 ; $mois++){
                            if($mois<10){ ?>
                            	<option value="<?= '0'.$mois ?>" ><?= '0'.$mois ?></option>
                        	<?php }
                            else{ ?>
                                <option value="<?= $mois ?>"><?= $mois ?></option>
                        <?php } } ?>
                    </select>
                    <select id="year" class="" name="year">
                    	<option></option>
                        <?php for ($annee = 1901 ; $annee <= 2010 ; $annee++){ ?>
                            <option value="<?= $annee ?>" <?php if($annee == 1970) { echo 'selected="selected"'; } ?> ><?php echo $annee; ?></option>
                        <?php } ?>
                    </select>
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
	  		<div class="form-group">
	  			<label class="control-label col-lg-4 col-md-4 col-sm-4" for="confirmPassword">Confirmer votre mot de passe</label>
	  			<div class="col-lg-8 col-md-6 col-sm-8">
		  			<input
				        type="password"
				        id="confirmPassword"
				        class="form-control"
				        name="confirmPassword"
				        value="<?= (isset($_POST["confirmPassword"]))?$_POST["confirmPassword"]:"" ?>"
				        placeholder ="Confirmer le mot de passe"
					/>
				</div>
	  		</div>
			<button class="" type="submit" name="signup" style="margin: auto;display:block;">Je m'inscris</button>
			<br><br><br>
  		</form>
  	</div>
</main>