
<div id="container2"> <!-- aqui tenemos la tabla de los socios-->
    <div class="form_head" align="center"><h1>SOCIOS</h1></div>
    <div class="control-group">
    <?php App::get_template('socios/pidesocio'); ?>



        <table name="booklist" id="dtables" width="100%">
            <thead>
                <th style="text-align: left" width="5%">ID</th>
                <th style="text-align: left" width="5%">DNI</th>
                <th style="text-align: left" width="10%">Nombre</th>
                <th style="text-align: left" width="30%">Caso</th>
                <th style="text-align: left" width="5%">Promocionado</th>               
                <th style="text-align: left" width="5%">Cuota</th>
            </thead>
            <tbody>
				 
               <?php foreach( $socios as $socio ): ?>

                        <tr style="text-align: center" class='tb1' width="100%">
                            <td style="text-align: left" width="5%"><?php echo $socio['IdUser']; ?></td>
                            <td width="5%" style="text-align: left"><?php echo $socio['DNI']; ?></td>
                            <td width="10%"><?php echo $socio['Nombre']; ?></td>
                            <td width="30%" style="text-align: left"><?php echo $socio['Caso']; ?></td>
                            <td width="5%" style="text-align: left"><?php echo $socio['Promo']; ?></td>                            
                            <td width="5%"><?php echo $socio['Cuota']; ?></td>
                            <td> <a href='index.php?action=edit-customer&id=<?php echo $socio['IdUser']; ?>' id='ided'>Editar</a></td>
                            <td> <a href='index.php?action=delete-customer&id=<?php echo $socio['IdUser']; ?>'  onclick="return confirm('¿Seguro borrar este socio?');" id='idbo'>Borrar</a></td>							
                        </tr>

               <?php endforeach; ?>
              
            </tbody>
        </table>

    </div>
</div>


