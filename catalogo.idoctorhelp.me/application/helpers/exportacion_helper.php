<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('exporta_excel'))
{


function exporta_excel($tabla) {


    $xls = "<html><head><style type='text/css'>"; 
    $xls .= "td {border:0.5px solid #000; vertical-align:top; font-size:9pt;} </style> ";
    $xls .= "</head><body>"; 

    $xls .= "<table>";

    $xls .= "<tr style='background-color:black;color:white;'>";
     $tablarow = $tabla[0];
     foreach ($tablarow as $k=>$v) {
      $xls .= "<td>" . str_replace('_', ' ', $k) . "</td>";
     }
      $xls .= "</tr>";    
    
    foreach ($tabla as $k=>$v) {
      $xls .= "<tr style='background-color:white;'>";
      foreach ($tablarow as $kr=>$vr) {
      $xls .= "<td>" . $v[$kr] . "</td>";
      }   
    }
    $xls .= "</table></body></html>";

    return $xls;
    
  }

 } 

  ?>