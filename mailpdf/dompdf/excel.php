<?php

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=invoice.xls");
?>


<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>
            body{
               
                margin: 0;
                font-family: 'Roboto', sans-serif;
                font-size: 12px;
            }



            .invoice-container{
                max-width: 800px;
                margin: 10px auto;
                background: #fff;
                padding: 20px;
              
            }

            .comp_addr{
                text-align: center;
                line-height: 10px;
            }

            table{
                text-align: center;
                width: 100%;
            }


            table th{
                border-right: 1px solid #ccc;
            }

            table td{
                border-right: 1px solid #ccc;
                padding: 20px 0px;
            }

            .my-address{
                background: #f1e9e9;
                padding: 7px;
            }

        </style>
    </head>
    <body>
        <div class="invoice-container">
            <div class="comp_addr">
                <h3>TAX INVOICE</h3>
                <hr>
                <div class="my-address">
                    <h1>Tech. Rudranshi Software Solution</h1>
                    <h4>407/3 Gram - Banher, THE. - Bhagwanpura, Dist. - Khargone 451441</h4>
                </div>
            </div>
            <hr>
            <table>
                <tr>
                    <th>Bill To</th>
                    <th>Place of Supply</th>
                </tr>
                <tr>
                    <td>RK Electrical Works</td>
                    <td>A-240 Rajouri Garden,New Delhi</td>
                </tr>
            </table><hr>
            <table>
                <tr>    
                    <th>INVOICE No</th>
                    <th>Description of Goods</th>
                    <th>QTY</th>
                    <th>RATE</th>
                    <th>Dated</th>
                    <th>GST</th>
                    <th>Taxable Value</th>
                    <th>Amount</th>
                </tr>

                <tr>
                    <td>#TR-2587</td>
                    <td>LED LIGHTS</td>
                    <td>1</td>
                    <td>250</td>
                    <td>26/07/2018</td>
                    <td>18%</td>
                    <td>45</td>
                    <td>295</td>
                </tr>

                <tr>
                    <td>#TR-2588</td>
                    <td>Tube LIGHTS</td>
                    <td>4</td>
                    <td>1000</td>
                    <td>26/07/2018</td>
                    <td>18%</td>
                    <td>180</td>
                    <td>1180</td>
                </tr>

            </table>
            <hr>
            <table>
                <tr style="text-align: right">
                    <th>Total</th>
                    <th>1475</th>
                </tr>
            </table>
            <hr>
            <p>This is a system generated invoice and needs no signature. </p>
        </div>
    </body>
</html>
