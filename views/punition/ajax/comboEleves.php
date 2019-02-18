<option></option>
<?php
foreach($eleves as $el){
    echo "<option value = '".$el['IDELEVE']."'>".$el['CNOM']."</option>";
}