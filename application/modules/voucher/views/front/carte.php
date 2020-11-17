<!doctype html>



<html>

<head>

	<meta charset="utf-8">

	<title>Carte Cadeau</title>

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css">

    <link rel="stylesheet" href="/assets/css/global.css" type="text/css">

	<link media="all" type="text/css" href="/assets/css/print.css" rel="stylesheet"/>

</head>

<body id="pdf">

	<!-- CARTE CADEAU -->
	<table id="carteCadeau" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td id="ccCordonnees" width="30%" valign="top" >
							<table width="100%" cellpadding="0" cellspacing="0">
							  <tr>
							  	<td>
							  		<img src="../../assets/img/logo-secret-room-agency.png" alt="">
							  	</td>
							  </tr>
							  <tr>
							  	<td class="coordonnees">
							  	  <p class="mt0 mb0">Vous pouvez nous joindre<br/>tous les jours entrre 10h00 et 22h00</p>
							  	  <p class="tel mt0 mb0">07 84 96 43 48</p>
							  	  <p class="mt0 mb0">40 bis rue Voltaire<br/>Z.I. Nord<br/>82000 Montauban<br/>France</p>
							  	</td>
							  </tr>	
							  <tr>
							  	<td class="text-center">
								  <img src="../../assets/img/qrcode.png" alt="Qrcode">  
								</td>
							  </tr>	
							  <tr>
							  	<td class="text-center">
							  		<p>www.secretroomagency.com</p>
							  	</td>
							  </tr>	
							</table>
						</td>
						<td valign="top">
						  <table id="ccInfos" width="100%" cellpadding="0" cellspacing="0">
						  	<tr>
						  	  <td>
						  	  	<table width="100%" cellpadding="0" cellspacing="0">
								  <tr>
								    <td>
									  <h1 class="mt0 mb0">Carte cadeau</h1>
									  <p>n°VAR_REF</p>
								    </td>
								    <td width="10%">
								      VAR_TITRE_VOUCHER
								    </td>
								  </tr>
							  </table>
						  	  </td>
						  	</tr>
						  	<tr>
						  	  <td>
								  <p>Pour : <span>VAR_PRENOM</span></p>
						  	  </td>
						  	</tr>
						  	<tr>
						  	  <td>
						  	  	<p>Offert par : <span><?=$prenom?></span> le : <span>VAR_DATE</span></p>
						  	  </td>
						  	</tr>
						  	<tr>
						  	  <td>
						  	  	VAR_DESCRIPTION
						  	  </td>
						  	</tr>
						  	<tr>
						  	  <td></td>
						  	</tr>
						  	<tr>
						  	  <td class="text-center">
								  <h2 class="mt0 mb0">SECRET ROOM AGENCY</h2>
								  <h3 class="mt0 mb0">Live Escape Game Montauban</h3>
								  <p class="mt0 mb0">Un jeu d’équipe, une expérience unique et immersive</p>
								  <p class="mt0 mb0">1 heure pour résoudre des énigmes et remplir votre mission</p>
						  	  </td>
						  	</tr>
						  </table>
						  <table width="100%" cellpadding="0" cellspacing="0">
						  	<tr>
						  		<td>
						  		  <?=$cgv?>
						  		</td>
						  		<td width="10%">
						  			VAR_QRCODE
						  		</td>
						  		<td width="10%">
									Fin de validité du bon : <span>VAR_DATE_VALIDITE</span>
						  		</td>
						  	</tr>
						  </table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- /CARTE CADEAU -->
	
<p></p>
	HEY !!!

	<br /><br />

	<?=$prenom?> t'offre cette carte cadeau d'une valeur de <?=$montant?> qui te permettra de venir découvrir nos missions !

	<br /><br />

	Connectes toi sur http://reservation.sroomagency.com, effectues ta réservation et utilise le code suivant :

	 <h2><b><?=$code?> <?=$date_valid?></b></h2>

	<br /><br />

	<h4>CGV</h4>

	<em>

		<?=$cgv?>

	</em>

	<img src="<?php echo APP_URL; ?>/assets/img/qrcarteskdo/<?php echo $qrpath; ?>" />

</body>

</html>

