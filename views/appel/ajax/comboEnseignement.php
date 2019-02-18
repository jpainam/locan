<option value =""></option>
<?php
foreach ($enseignements as $ens){
    echo "<option value ='".$ens['IDEMPLOIS']."'>".substr($ens['HEUREDEBUT'], 0, 2)."h:".substr($ens['HEUREDEBUT'], 3, 2)
            ." - ".substr($ens['HEUREFIN'],0,2)."h:".substr($ens['HEUREFIN'], 3, 2)."&nbsp;&nbsp;".$ens['LIBELLE']."</option>";
}