<option></option>
<?php
foreach($caisses as $caisse){
    $d = new DateFR($caisse['DATETRANSACTION']);
echo "<option value = '".$caisse['IDCAISSE']."'>".$caisse['REFTRANSACTION']."-".$caisse['REFCAISSE']."-".
            $d->getDate()."/".$d->getMois(3)."/".$d->getYear()."</option>";
}