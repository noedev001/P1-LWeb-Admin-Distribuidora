<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Reporte</title>

		<style>
			.invoice-body {
				padding: 30px;
			}
			.pull-left {
				float: left !important;
			}
			.h1, h1 {
				font-size: 36px;
			}
			.h1, .h2, .h3, h1, h2, h3 {
				margin-top: 20px;
				margin-bottom: 10px;
			}
			address {
				margin-bottom: 20px;
				font-style: normal;
				line-height: 1.42857143;
			}
			body {
				color: #797979;
				font-family: 'Ruda', sans-serif;
				font-size: 10px;
				line-height: 1.42857143;
			}
			.pull-right {
				float: right !important;
			}
			h2 {
				font-size: 30px;
			}
			.row {
				margin-right: -15px;
				margin-left: -15px;
			}
			.col-md-9 {
				width: 75%;
              
			}
			.invoice-body h4 {
				margin-left: 0px;
			}

			address {
				margin-bottom: 20px;
				font-style: normal;
				line-height: 1.42857143;
			}
			.table {
			width: 100%;
			max-width: 100%;
			margin-bottom: 20px;
			}
			*{

				box-sizing: border-box;
			}

			table {
				border-spacing: 0;
				border-collapse: collapse;
			}
            
            .col-md-3{
                float: right;
            }
            .pull-left {
                float: left !important;
            }
            .pull-right {
                float: right !important;
            }

            .well.well-small {
                padding: 13px;
                width: auto;
            }
            .well.green {
                background-color: #48cfad;
                color: #fff;
                border: none;
            }

			.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
				position: relative;
				min-height: 1px;
				padding-right: 15px;
				padding-left: 15px;
			}

            .well {
                min-height: 45px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }

            .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                    padding: 8px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 1px solid #ddd;
                }

                .text-right {
                    text-align: right;
                }
				.text-center {
                    text-align: center;
                }

                .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                    padding: 8px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 1px solid #ddd;
                }

                strong {
                    font-weight: 700;
                }

                .col-md-3{
                width: 35%;
            }
            .green{
                background-color:  #76d7c4;
                padding: 12px;
                margin: 5px 0 5px 0;
                border-radius: 10px;
                color:   #117864 ;
            }
		</style>
	</head>

	<body>

				<div class="invoice-body">
				  <div class="pull-left">
					<h1>E&E</h1>
					<address>
				  <strong>DISTRIBUIDORA</strong><br>
				  Sucre, Bolivia<br>
				  <abbr title="Phone">Cel:</abbr> (+529) 75450473
				</address>
				  </div>
				  <!-- /pull-left -->
				  <div class="pull-right">
					<h2>Almacen</h2>
                    <img src="../public/img/lauch.png" style="width: 100%; max-width: 90px" />
				  </div>
				  <!-- /pull-right -->
				  <div class="clearfix"></div>
				  <br>
				  <br>
				  <br>
				  <br>
                  <br>
				  <br>
				  <br>


					<!-- /col-md-9 -->
					<div class="col-md-3" style="margin-right: 90px;margin-top: 60px;">
					                
					  <div>
						<!-- /col-md-3 -->
						<div class="pull-left"> Fecha : &nbsp; <?php 
						setlocale(LC_TIME, 'es_ES.UTF-8');
							
							echo ($fecha)
							?></div> </div>
						<div class="pull-right"> &nbsp; </div>
						<div class="clearfix">&nbsp;</div>
					  </div>
                      
					  <!-- /row -->
					
			
					<!-- /invoice-body -->
				  </div>
				  <br><br><br><br>
				  <!-- /col-lg-10 -->
				  <table class="table">
					<thead class="green">
					  <tr>
						<th class="centered">DESCRIPCION</th>
						<th  class="centered">UNIDADES POR CAJA</th>
                        <th class="centered">UNIDADES DISPONIBLES</th>
                        <th class="centered">CAJAS DISPONIBLES</th>
						<th  class="centered">PRECIO VENTA UNI.</th>
                        <th  class="centered">PRECIO TOTAL</th>
					  </tr>
					</thead>
					<tbody>
						<?php 
							foreach ($inventario as $inv){  
                                foreach ($producto as $pro){ 
                                    if($inv['producto_id']==$pro['id']){ 
                                ?>
								<tr>
									<td class="centered"><?php echo ($pro['nombre'].' - '.$pro['marca'].' - '.$pro['modelo']);?></td>
									<td class="text-center"><?php echo ($inv['cantidad_unidad_caja']);?></td>
									<td class="text-center"><?php echo ($inv['cantidad_unidad_almacen_dis']);?></td>
                                    <td class="text-center"><?php echo ($inv['cantidad_caja_almacen_dis']);?></td>
                                    <td class="text-center"><?php echo ($inv['precio_venta_unidad'].' Bs');?></td>
									<td class="text-center"><?php echo ($inv['precio_venta_unidad']*$inv['cantidad_unidad_almacen_dis']);?> </td>
								</tr>
							
								<?php
                                    }
                                }
							}
							?>

					  

					</tbody>
				  </table>
				  <br>
				  <br>
				</div>
	</body>
</html>