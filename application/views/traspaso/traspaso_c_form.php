  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'traspaso_c_form');
    echo form_open('traspaso/insert_c', $atributos);
 
  ?>
  
  <table>


<tr>
	<td align="left" ><font size="+1">SELE: </font></td>
    <td align="left"> 
    <select name="sale" id="sale">
    <option value="0" <?php if($sale=='0') echo "Selected"?> >selecciona sucursal</option>
    <option value="1600" <?php if($sale=='1600') echo "Selected"?> >FARMABODEGA</option>
    <option value="100" <?php if($sale=='100') echo "Selected"?> >OTROS ALMACENES</option>
    </select>
    </td>
    <td align="left" ><font size="+1">ENTRA: </font></td>
    <td align="left"> 
    <select name="entra" id="entra">
    <option value="0" <?php if($entra=='0') echo "Selected"?> >selecciona sucursal</option>
    <option value="1600" <?php if($entra=='1600') echo "Selected"?> >FARMABODEGA</option>
    <option value="100" <?php if($entra=='100') echo "Selected"?> >OTROS ALMACENES</option>
    </select>
    </td>
    
</tr>
 

	<td colspan="4" align="center"><?php echo form_submit('envio', 'GENERAR TRASPASO');?></td>
</tr>
</table>
<input type="hidden" value="0" name="valida" id="valida" />
  <?php
	echo form_close();
  ?>
<table align="center">
<tr>
	<td><?php echo $tabla;?></td>
</tr>
</table>

</div>    
  <script language="javascript" type="text/javascript">
   <script language="javascript" type="text/javascript">
   $(window).load(function () {
        $("#sale").focus();
    });
    $(document).ready(function(){
    
  
 


    $('#traspaso_c_form').submit(function() {
        
        var sale = $('#sale').attr("value");
        alert(sale)
         
    	  if(sale >0 && entra>0 ){
    	
    	    if(confirm("Seguro que los datos son correctos?")){
    	    return true;
    	    }else{
    	    return false;
    	    }
    	    
    	  }else{

    	    alert('Verifica la informacion de producto por favor');
    	    $('#clave').focus();
    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>