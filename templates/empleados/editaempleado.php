<?php App::get_template('header'); ?>
<?php if ( isset( $alert ) ): ?>
	<div class="alert <?php echo $alert['type']; ?>">
		<p><?php echo $alert['msg']; ?></p>
	</div>
<?php endif; ?>

<form id="userForm" method="POST" action="index.php">
	<input type="hidden" name="action" value="update-employee">
	<input type="hidden" name="id" value="<?php echo $empleados['IdUser']; ?>">
	<div>
		<label class="dni">DNI</label>
		<input type="text" class="idni"  name="dni" value="<?php echo $empleados['DNI']; ?>">
	</div>
	<div >
		<label class="nombre">Nombre</label>
		<input type="text" class="inombre"  name="name" value="<?php echo $empleados['Nombre']; ?>">
	</div>						
	<div >
		<label class="cuota">Sueldo</label>
		<input type="text" class="icuota" name="salary" value="<?php echo $empleados['Sueldo']; ?>">
	</div>
	<div>
		<div>
      		<button type="submit">Confirmar</button>
      	</div>
    </div>   
</form>
<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
<?php App::get_template('footer'); ?>
