<option value="">Select Modifier</option>
<?php                                   
foreach($modifierList  as $value){  
?>
<option value="<?php echo $value->id; ?>"><?php echo $value->modifier_name; ?></option>


<?php
}
?>