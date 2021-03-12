<?php App::get_template('header'); ?>
<p>CALENDARIO</p>
<a href='index.php?action=dashboard' id='idm'>INICIO</a></td>
<div id='calendar'></div>
<div id="modal-insert-time" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">RESERVAS</h4>
      </div>
      <div class="modal-body">
      	<form id="bookingForm" method="POST" action="index.php">
      		<input type="hidden" name="action" value="insert-reserve">
      		<input type="hidden" name="idr" value="">
      		<label class="calendari" name="calendari" action="insert-reserve" placeholder="calendar">Instalaciones </label>
	      		<select class="select-instalacion" name="inst">
	      			<option value="-1" selected="selected">Elige uno</option> 
	      			<?php foreach($instalaciones as $instalacion ): ?>
      				  <option value="<?php echo $instalacion['Id_Instalacion,']; ?>"><?php echo $instalacion['Nombre_Instalacion']; ?></option> 
	      			<?php endforeach; ?> 	
	      		</select>
<!--
          <label class="calendarh" name="calendarh" action="insert-reserve" placeholder="calendar">Hora </label>            
            <select name="hora">
              <option value="-1" selected="selected">Elige uno</option> 
              <?php foreach($horas as $clave => $nombre ): ?>
                <option value="<?php echo $clave['Id_Reservas']; ?>"><?php echo $nombre['start']; ?></option> 
              <?php endforeach; ?>  
            </select>
-->
          <label class="calendarh" name="calendarh" action="insert-reserve" placeholder="calendar">Hora </label>            
            <select name="hora">
              <option value="-1" selected="selected">Elige uno</option> 
              <?php foreach($horas as $hora ): ?>
                <option value="<?php echo $hora['Id_Reservas']; ?>"><?php echo $hora['start']; ?></option> 
              <?php endforeach; ?>  
            </select>
		    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php App::get_template('footer'); ?>
