<?php App::get_template('header'); ?>
<?php if ( isset( $alert ) ): ?>
	<div class="alert <?php echo $alert['type']; ?>">
		<p><?php echo $alert['msg']; ?></p>
	</div>
<?php endif; ?>

<form id="userForm" method="POST" action="index.php">
	<input type="hidden" name="action" value="update-customer">
	<input type="hidden" name="id" value="<?php echo $socio['Id_Socio']; ?>">

			<div>
				<label class="dni">DNI</label>
				<input type="text"  name="dni" value="<?php echo $socio['DNI']; ?>">
			</div>
			<div >
				<label class="nombre">Nombre</label>
				<input type="text" class="snombre" name="name" value="<?php echo $socio['Nombre']; ?>">
			</div>			
			<div >
				<label class="tipo">Caso</label>
				<input type="text" class="scaso" name="case" value="<?php echo $socio['Caso']; ?>">
			</div>
			<div >
				<label class="promocionado">Promocionado</label>
				<input type="text" class="spromo" name="promo" value="<?php echo $socio['Promo']; ?>">
			</div>
			<div >
				<label class="cuota">Cuota</label>
				<input type="text" class="scuota" name="fee" value="<?php echo $socio['Cuota']; ?>">
			</div>
			<div>
				<div>
		      		<button type="submit" name="enviar">Confirmar</button>
		      	</div>
		    </div>   
</form>
<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
<?php App::get_template('footer'); ?>
