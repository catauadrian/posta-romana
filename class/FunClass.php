<?php

Class NumToLitere {


//error_reporting(E_ALL);
// *****************************************************************
// Converteste suma din cifre in litere
// $No - numarul de convertit
// $sp - delimitator mii
// $pct - punct zecimal
// @dechim 6-2006,8-2009
// *****************************************************************

public function strLei($No, $sp='.', $pct=',' ) {

// numerele literal
$na = array ( "", "Unu", "Doi", "Trei", "Patru", "Cinci", "Sase", "Sapte", "Opt", "Noua");
$nb = array ( "", "Un",  "Doua", "Trei", "Patru", "Cinci", "Sase", "Sapte", "Opt", "Noua");
$nc = array ( "", "Una", "Doua","Trei", "Patru", "Cinci", "Sase", "Sapte", "Opt", "Noua");
$nd = array ( "", "Unu", "Doua", "Trei", "Patru", "Cinci", "Sase", "Sapte", "Opt", "Noua");

// exceptie "saizeci"
$ex1 = 'Sai';

// unitati
$ua = array ( "", "Zece", "Zeci", "Zeci","Zeci","Zeci","Zeci","Zeci","Zeci","Zeci");
$ub = array ( "", "Suta", "Sute", "Sute","Sute","Sute","Sute","Sute","Sute","Sute");
$uc = array ( "", "Mie", "Mii");
$ud = array ( "", "Milion", "Milioane");
$ue = array ( "", "Miliard", "Miliarde");

// legatura intre grupuri
$lg1 = array ("", "Spre", "Spre", "Spre", "Spre", "Spre", "Spre", "Spre", "Spre", "Spre");
$lg2 = array ("", "", "Si",  "Si", "Si", "Si", "Si", "Si", "Si", "Si" );

// moneda
$mon = array ("", " leu", " lei");
$ban = array ("", " ban ", " bani ");

//se elimina $sp din numar
$sNo = (string) $No;
$sNo = str_replace($sp,"",$sNo);

//extrag partea intreaga si o completez cu zerouri la stg.
$NrI = sprintf("%012s",(string) strtok($sNo,$pct));

// extrag zecimalele
$Zec = (string) strtok($pct);
$Zec = substr($Zec . '00',0,2);

// grupul 4 (miliarde)
$Gr = substr($NrI,0,3);
$n1 = (integer) $NrI[0];
$n2 = (integer) $NrI[1];
$n3 = (integer) $NrI[2];
$Rez = $nc[$n1] . $ub[$n1];
$Rez = ($n2 == 1)?$Rez . $nb[$n3] . $lg1[$n3] . $ua[$n2]:
                $Rez . ($n2==6?$ex1:$nc[$n2]) . $ua[$n2] . $lg2[$n2] . ($Gr=="001"||$Gr=="002"?$nb[$n3]:$nd[$n3]);

$Rez = ($Gr == "000")?$Rez:(($Gr == "001")?($Rez . $ue[1]):($Rez . $ue[2]));

// grupul 3 (milioane)
$Gr = substr($NrI,3,3);
$n1 = (integer) $NrI[3];
$n2 = (integer) $NrI[4];
$n3 = (integer) $NrI[5];
$Rez = $Rez . $sp . $nc[$n1] . $ub[$n1];
$Rez = ($n2 == 1)?$Rez . $nb[$n3] . $lg1[$n3] . $ua[$n2]:
                $Rez . ($n2==6?$ex1:$nc[$n2]) . $ua[$n2] . $lg2[$n2] . ($Gr=="001"||$Gr=="002"?$nb[$n3]:$nd[$n3]);
$Rez = ($Gr == "000")?$Rez:(($Gr == "001")?($Rez . $ud[1]):($Rez . $ud[2]));

// grupul 2 (mii)
$Gr = substr($NrI,6,3);
$n1 = (integer) $NrI[6];
$n2 = (integer) $NrI[7];
$n3 = (integer) $NrI[8];
$Rez = $Rez . $sp . $nc[$n1] . $ub[$n1];
$Rez = ($n2 == 1)?$Rez . $nb[$n3] . $lg1[$n3] . $ua[$n2]:
                $Rez . ($n2==6?$ex1:$nc[$n2]) . $ua[$n2] . $lg2[$n2] . ($Gr=="001"||$Gr=="002"?$nc[$n3]:$nd[$n3]);
$Rez = ($Gr == "000")?$Rez:(($Gr == "001")?($Rez . $uc[1]):($Rez . $uc[2]));

 // grupul 1 (unitati)
$Gr = substr($NrI,9,3);
$n1 = (integer) $NrI[9];
$n2 = (integer) $NrI[10];
$n3 = (integer) $NrI[11];
$Rez = $Rez . $sp . $nc[$n1] . $ub[$n1];
$Rez = ($n2 == 1)?($Rez . $nb[$n3] . $lg1[$n3] . $ua[$n2].$mon[2]):($Rez . ($n2==6?$ex1:$nc[$n2]). $ua[$n2] .
                ($n3>0?$lg2[$n2]:'') . ($NrI=="000000000001"?($nb[$n3] .$mon[1]):($na[$n3]). $mon[2]));

if ((integer) $NrI == 0) {$Rez = ""; }

// banii
if ((integer) $Zec>0)
{
 $n2 = (integer) substr($Zec,0,1);
 $n3 = (integer) substr($Zec,1,1);
 $Rez .= ' si ';
 $lg22 = ($n3=='0'?'':$lg2[$n2]);
 $Rez = ($n2 == 1)?($Rez . $nb[$n3] . $lg1[$n3] . $ua[$n2].$ban[2]):
                ($Rez . ($n2==6?$ex1:$nc[$n2]) . $ua[$n2] . $lg22 . ($Zec=="01"?($nb[$n3] .$ban[1]):($na[$n3]). $ban[2]));
}
return $Rez;
}

}

 ?>
