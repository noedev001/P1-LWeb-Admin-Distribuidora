<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>factura</title>

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
				font-size: 13px;
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
					<h2>Factura</h2>
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
				  <br><br>
				  <br>
				  <div class="row">
					<div class="col-md-9">
					  <h4>
						<?php 
							foreach ($clienteFac as $registro){  
								echo $registro['cli_usuario'];
							}
						?> 
						</h4>
					  <address>
					<strong><?php 
						foreach ($clienteFac as $registro){  
							echo ($registro['cli_nombres'].' '.$registro['cli_apellidos']);
						}
					?> </strong><br>
					<?php 
					foreach ($clienteFac as $registro){  
						echo ('Ci/Nit: '.$registro['ci']);
					}
					?> <br>
			
					<abbr title="Phone">P:</abbr> (+529) <?php 
					foreach ($clienteFac as $registro){  
						echo ($registro['cli_celular']);
					}
					?>
				  </address>
					</div>
					<!-- /col-md-9 -->
					<div class="col-md-3 ">
					  
					  <div>
						<div class="pull-left"> Factura N° :  &nbsp;<?php 
							foreach ($facturas as $re){  
								echo ($re['factura']);
							}
							?></div>
						<div class="pull-right"> &nbsp; </div>
						<div class="clearfix">&nbsp;</div>
					  </div>
              
					  <div>
						<!-- /col-md-3 -->
						<div class="pull-left"> Fecha : &nbsp; <?php 
						setlocale(LC_TIME, 'es_ES.UTF-8');
							foreach ($facturas as $re){  
								echo ($re['fechafac']);
							}
							?></div> </div>
						<div class="pull-right"> &nbsp; </div>
						<div class="clearfix">&nbsp;</div>
					  </div>
                      
					  <!-- /row -->
					
					 
					</div>
					<!-- /invoice-body -->
				  </div>
				  <br><br><br><br>
				  <!-- /col-lg-10 -->
				  <table class="table">
					<thead>
					  <tr>
						<th class="text-left">DESCRIPCION</th>
						<th style="width:80px" class="text-right">CANT.</th>
						<th style="width:100px" class="text-right">P. UNIT</th>
						<th style="width:100px" class="text-right">TOTAL</th>
					  </tr>
					</thead>
					<tbody>
						<?php 
							foreach ($detallepedido as $re){  ?>
								<tr>
									<td class="text-center"><?php echo ($re['nombre'].' - '.$re['marca']);?></td>
									<td class="text-right"><?php if($re['cantidad_caja']>0) { echo ($re['cantidad_caja']*$re['cantidad_unidad_caja']);}else {
										echo ($re['cantidad_unidad']);
									}?></td>
									<td class="text-right"><?php echo ($re['precio_unidad']);?></td>
									<td class="text-right"><?php echo ($re['precio_total']);?></td>
								</tr>
							
								<?php
							}
							?>
					<tr>
						<td colspan="2" rowspan="4">
						  <h4>Términos y Condiciones</h4>
						  <p>Gracias por hacer negocios con nosostros. Habrá un cargo de interés del 13%. </p>
						  <td class="text-right"><strong>Subtotal</strong></td>
						  <td class="text-right"><?php 
							foreach ($precioTotal as $re){  
								echo ($re['PrecioTotal']);
							}
							?> Bs</td>
					  </tr>
					  
					  <tr>
						<td class="text-right no-border">
						  <div class="well well-small green"><strong>Total</strong></div>
						</td>
						<td class="text-right"><strong><?php 
							foreach ($precioTotal as $re){  
								echo ($re['PrecioTotal'].'Bs');
							}
							?> </strong></td>
					  </tr>
					</tbody>
				  </table>
				  <br>
				  <br>
				</div>
	</body>
</html>