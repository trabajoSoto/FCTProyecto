<?php App::get_template('header'); ?>
<div id="container2"> <!-- aqui tenemos la tabla de los socios-->
    <div class="form_head" align="center"><h1>DEUDORES</h1></div>
    <div class="control-group">



        <table name="booklist" id="dtables" width="100%">
            <thead>
                <th style="text-align: center" width="5%">ID</th>
                <th style="text-align: center" width="5%">Metodo Pago</th>

            </thead>
            <tbody>
				 
               <?php foreach( $socios as $socio ): ?>

                        <tr style="text-align: center" class='tb1' width="100%">
                            <td width="5%"><?php echo $socio['idPago']; ?></td>
                            <td width="5%"><?php echo $socio['tipoPago']; ?></td>
                        </tr>

               <?php endforeach; ?>
              
            </tbody>
        </table>

    </div>
</div>