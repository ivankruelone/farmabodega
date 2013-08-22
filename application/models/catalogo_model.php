<?php
	class Catalogo_model extends CI_Model {

    function productos()
    {
        $sql = "SELECT * FROM catalogo.almacen where maxbo>0 order by sec, clabo";
        $query = $this->db->query($sql);
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        
        </tr>
        <tr>
        <th>Sec</th>
        <th>Clave</th>
        <th>Sustancia Activa</th>
        <th>Prv</th>
        <th>Proveedor</th>
        <th>Maximo</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            //$l1 = anchor('catalogo/cambiar_accesorio/'.$row->id, '<img src="'.base_url().'img/edit.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para modificar productos!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->sec."</td>
            <td align=\"center\">".$row->clabo."</td>
            <td align=\"left\">".$row->susa1."</td>
            <td align=\"center\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            <td align=\"center\">".$row->maxbo."</td>
            </tr>
            ";
        }
        
        $tabla.="
        </tbody>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////    
/////////////////////////////////////////////////////////////////
function trae_datos($clave){
    $sql = "SELECT *  FROM catalogo.catalogo_bodega  where clabo= ? ";
    $query = $this->db->query($sql,array($clave));
     return $query;
    }
/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// 
   function busca_sucursal()
	{
		$sql = "SELECT suc,nombre FROM  catalogo.sucursal where suc>1599 and suc<1699 order by nombre";
        $query = $this->db->query($sql);
        
        $suc = array();
        $suc[0] = "Selecciona una Sucursal";
        
        foreach($query->result() as $row){
            $suc[$row->suc] = $row->nombre." - ".$row->suc;
        }
        
        
        return $suc;
	}   
/////////////////////////////////////////////////////////////
 function busca_suc_unica($suc)
    {
      $sql = "SELECT  nombre FROM  catalogo.sucursal where suc = ?";
    $query = $this->db->query($sql,array($suc));
    $row= $query->row();
    $sucx=$row->nombre;
     return $sucx; 
    }

/////////////////////////////////////////////////////////////    
}