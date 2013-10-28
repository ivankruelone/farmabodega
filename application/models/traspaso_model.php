<?php
	class Traspaso_model extends CI_Model {
    
    function control()
    {
        
        $this->db->select('a.*,b.nombre as salex,c.nombre as entrax');
        $this->db->from('traspaso_c a');
        $this->db->join('catalogo.sucursal b','a.sale=b.suc');
        $this->db->join('catalogo.sucursal c','a.entra=c.suc');
        $this->db->where('activo',1);
        $this->db->where('tipos',1);
        $query = $this->db->get();
        
        
        //titulos//
        $tabla= "
        <table>
        <thead>
        <tr>
        <th align=\"center\">Folio</th>
        <th align=\"left\">Sale</th>
        <th align=\"left\">Entra</th>
        
        
        </tr>
        </thead>";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('traspaso/detalle/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('traspaso/delete_c/'.$row->id, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar factura!', 'class' => 'encabezado'));
            $l3 = anchor('traspaso/cierre_c/'.$row->id, '<img src="'.base_url().'img/icons/emoticon/emoticon_bomb.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para cerrar factura!', 'class' => 'encabezado'));
            
            $tabla.="
            <tr>
        <td align=\"center\">$row->id</td>
        
        <td align=\"left\">".$row->sale."-".$row->salex." </td>
        <td align=\"left\">".$row->entra."-".$row->entrax." </td>
        <td align=\"center\">$l1</td>
        <td align=\"center\">$l2</td>
        <td align=\"center\">$l3</td>
        </tr>
        ";
        }
        $tabla.="
         
         </table>";   
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////    
/////////////////////////////////////////////////////////////////
    function detalle_d($id_cc)
    {
        
        $this->db->select('a.*, b.susa1, b.susa2,b.prv,b.prvx');
        $this->db->from('traspaso_d a');
        $this->db->join('catalogo.catalogo_bodega_clave b','a.clave=b.clabo');
        $this->db->where('id_cc',$id_cc);
        $this->db->where('a.activo',1);
        $this->db->order_by('a.id desc');
        $query = $this->db->get();
        
        
        
        $tabla= "
        <table>
        <thead>
        <tr>
        <th align=\"center\">Clave</th>
        <th align=\"center\">Prv</th>
        <th align=\"center\">Proveedor</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"left\">Lote</th>
        <th align=\"left\">Caducidad</th>
        <th align=\"right\">Entra</th>
        <th align=\"right\">Sale</th>
        </tr>
        </thead>";
        
        foreach($query->result() as $row)
        {
         $l1 = anchor('traspaso/delete_d/'.$row->id.'/'.$id_cc, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar productos!', 'class' => 'encabezado'));
            
            $tabla.="
            <tr>
        <td align=\"center\">$row->clave</td>
        <td align=\"left\">$row->prv</td>
        <td align=\"left\">$row->prvx</td>
        <td align=\"left\">$row->susa1<br />$row->susa2</td>
        <td align=\"left\">$row->lote</td>
        <td align=\"left\">$row->cad</td>
        <td align=\"right\">$row->cane</td>
        <td align=\"right\">$row->cans</td>
        <td align=\"right\">$l1</td>
        </tr>
            ";
        }
         $tabla.= "
         </table>
         ";
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
    function control_historico()
    {
       
       $this->db->select('a.*,b.nombre as salex,c.nombre as entrax');
        $this->db->from('traspaso_c a');
        $this->db->join('catalogo.sucursal b','a.sale=b.suc');
        $this->db->join('catalogo.sucursal c','a.entra=c.suc');
        $this->db->where('activo',1);
        $this->db->where('tipos',2);
        $this->db->order_by('id desc');
        $query = $this->db->get();
        
        
        //titulos//
        $tabla= "
        <table>
        <thead>
        <tr>
        <th align=\"center\">Folio</th>
        <th align=\"left\">Sale</th>
        <th align=\"left\">Entra</th>
        
        
        </tr>
        </thead>";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('traspaso/detalle_historico/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('traspaso/imprime_d/'.$row->id, '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para imprimir pedido!', 'class' => 'encabezado'));
            $l3 = anchor('traspaso/imprime_e/'.$row->id, '<img src="'.base_url().'img/icon_nav_products.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para imprimir solo existencia!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
        <td align=\"center\">$row->id</td>
        
        <td align=\"left\">".$row->sale."-".$row->salex." </td>
        <td align=\"left\">".$row->entra."-".$row->entrax." </td>
        <td align=\"center\">$l1</td>
        <td align=\"center\">$l2</td>
        <td align=\"center\">$l3</td>
        </tr>
        ";
        }
        $tabla.="
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

   function detalle_d_historico($id_cc,$tit)
    {
       
       $this->db->select('a.*,b.susa1, b.susa2');
       $this->db->from('farmabodega.traspaso_d a');
       $this->db->join('catalogo.catalogo_bodega b', 'a.clave=b.clabo', 'LEFT');
       $this->db->where('id_cc',$id_cc);
       //$this->db->where('tipos',1);
       $query = $this->db->get();
       
        
        $tabla= "
        <table>
        <thead>
        <tr>
        <th colspan=\"4\">$tit</th>
        </tr>
        
        <tr>
        <th>Clave</th>
        <th>Sustancia Activa</th>
        <th>Descripcion</th>
        <th>Cantidad</th>
        </tr>
        
        
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."</td>
            <td align=\"left\">".$row->susa1."</td>
            <td align=\"left\">".$row->susa2."</td>
            <td align=\"center\">".$row->cans."</td>
            </tr>
            ";
        }
        
        $tabla.="
        </tbody>
        </table>";
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function imprime_detalle($id)
    {
        $tocan=0;
        $num=0;
        $sql = "SELECT a.*,b.susa1,b.susa2 from traspaso_d a
        left join catalogo.catalogo_bodega b on a.clave=b.clabo
        where a.id_cc= ?  order by clave";
        $query = $this->db->query($sql,array($id));
        
        $tabla= "
        <table>
        <thead>
        
        <tr>
        <th colspan=\"4\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width=\"70\"><strong>Clave</strong></th>
        <th width=\"230\"><strong>Sustancia Activa</strong></th>
        <th width=\"230\" align=\"left\"><strong>Descripcion</strong></th>
        <th width=\"80\" align=\"right\"><strong>Cantidad</strong></th>
        </tr>
        
        <tr>
        <th colspan=\"4\">__________________________________________________________________________________________</th>
        </tr>
        
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width=\"70\" align=\"left\">".$row->clave."</td>
            <td width=\"230\" align=\"left\">".$row->susa1."</td>
            <td width=\"230\" align=\"left\">".$row->susa2."</td>
            <td width=\"80\" align=\"right\">".$row->cans."</td>
            </tr>
            ";
        $tocan=$tocan+$row->cans;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"4\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <td width=\"530\" align=\"left\">Total de productos.: $num</td>
        <td width=\"80\" align=\"right\">".$tocan."</td>
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function imprime_detalle_e($id)
    {
        $tocan=0;
        $num=0;
        $sql = "SELECT a.*,b.susa1,b.susa2 from traspaso_d a
        left join catalogo.catalogo_bodega b on a.clave=b.clabo
        left join inventario_d_clave c on a.clave=c.clave
        where a.id_cc= ?  and c.cantidad>0 order by clave";
        $query = $this->db->query($sql,array($id));
        
        $tabla= "
        <table>
        <thead>
        
        <tr>
        <th colspan=\"5\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width=\"70\"><strong>Clave</strong></th>
        <th width=\"150\"><strong>Sustancia Activa</strong></th>
        <th width=\"230\" align=\"left\"><strong>Descripcion</strong></th>
        <th width=\"80\" align=\"right\"><strong>Cantidad</strong></th>
        <th width=\"80\" align=\"right\"><strong>Lote</strong></th>
        </tr>
        
        <tr>
        <th colspan=\"5\">__________________________________________________________________________________________</th>
        </tr>
        
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width=\"70\" align=\"left\">".$row->clave."</td>
            <td width=\"150\" align=\"left\">".$row->susa1."</td>
            <td width=\"230\" align=\"left\">".$row->susa2."</td>
            <td width=\"80\" align=\"right\">".$row->cans."</td>
            <td width=\"80\" align=\"right\">".$row->lote."</td>
            </tr>
            ";
        $tocan=$tocan+$row->cans;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"5\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <td width=\"530\" align=\"left\">Total de productos.: $num</td>
        <td width=\"80\" align=\"right\">".$tocan."</td>
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////


function trae_datos_c($id_cc){
    $sql = "SELECT a.*,b.nombre as salex,c.nombre as entrax
      FROM traspaso_c a
       left join catalogo.sucursal b on a.sale=b.suc
       left join catalogo.sucursal c on a.entra=c.suc
      where a.id= ? and a.activo=1";
    $query = $this->db->query($sql,array($id_cc));
     return $query;
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function trae_datos($id_cc,$clave){
    $sql = "SELECT *  FROM traspaso_d  where id_cc= ? and  clave= ? ";
    $query = $this->db->query($sql,array($id_cc,$clave));
     return $query;
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function busca_canp($clave,$can)
	{
		$sql = "SELECT *from traspaso_d  
        where clave= ? and canp >= ? ";
        $query = $this->db->query($sql,array($clave,$can));
        return $query->num_rows(); 
	}

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////insert y delete
function create_member_c($sale,$entra)
	{
       
       if($sale<>$entra & $sale>0 & $entra>0){
        
       
       $sql = "SELECT * FROM catalogo.sucursal where suc = ? ";
        $query = $this->db->query($sql,array($suc));
        $row= $query->row();
        $sucx=$row->nombre;    
    //////////////////////////////////////////////inserta los datos en la base de datos
        $new_member_insert_data = array(
			'sale' => $sale,
            'entra' => $entra,
            'tipoe' => 1,
            'tipos' => 1,
            'activo' => 1,
			'fecha'=> '0000-00-00:00:00',
            'fechacan'=> '0000-00-00:00:00'
		);
		
		$insert = $this->db->insert('traspaso_c', $new_member_insert_data);
        }
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

function create_member_d($id_cc,$clave,$can,$lote,$cad)
	{
        
      $sql = "SELECT * FROM catalogo.catalogo_bodega_clave where clabo= ? ";
        $query = $this->db->query($sql,array($clave));
        if($query->num_rows() > 0){
        $row= $query->row();
        $vta=$row->vtabo; 
        $lin=$row->lin;
        $costo=$row->costo;
        $codigo=$row->codigo;
        
        $sql1 = "SELECT * FROM traspaso_d where id_cc= ? and clave= ? and lote= ? and activo= 1 ";
       $query1 = $this->db->query($sql1,array($id_cc,$clave,$lote));
       
       if($query1->num_rows()== 0){
        
    //////////////////////////////////////////////inserta los datos en la base de datos
    	
        $new_member_insert_data = array(
			'id_cc' => $id_cc,
			'clave' => $clave,
            'lote' => $lote,
            'cad' => $cad,
            'cane' => $can,
            'cans' => $can,
            'costo'=>$costo,
            'codigo'=>$codigo,
            'fecha'=> date('Y-m-d H:s:i'),
            'activo'=>1
            						
		);
		
		$insert = $this->db->insert('traspaso_d', $new_member_insert_data);
		
	}
    }
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_c($id)
{
$data = array(
			'activo' => 4,
			'fechacan'=> date('Y-m-d H:s:i')
		);
		$this->db->where('id', $id);
        $this->db->update('traspaso_c', $data); 
}    
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_d($id)
{
$data = array(
			'activo' => 4,
			'fecha'=> date('Y-m-d H:s:i')
		);
		$this->db->where('id', $id);
        $this->db->update('traspaso_d', $data); 
} 
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function cierre_member_c($id)
{
        $sql1 = "SELECT a.*,b.entra,b.sale
                 FROM traspaso_d a
                 left join traspaso_c b on b.id=a.id_cc 
                 where id_cc= ? and a.inv='N'and a.activo=1";
        $query1 = $this->db->query($sql1,array($id));
        if($query1->num_rows() > 0){
        
        foreach($query1->result() as $row1)
        {
        $clave=$row1->clave;
        $lote=$row1->lote;
        $cad=$row1->cad;
        $stat=$row1->entra;
        $id_pro=$row1->id;
        
        if($stat==1600){
////_____________________________________///ENTRA MERCANCIA AL ALMACEN

        $sql = "SELECT * FROM inventario_d where clave= ? and lote = ? ";
        $query = $this->db->query($sql,array($clave,$lote));
        if($query->num_rows() == 1){
        $row= $query->row();
        $existencia=$row->cantidad;

$data = array(
			'cantidad'=> $existencia+$row1->cane
		);
		$this->db->where('clave', $clave);
        $this->db->where('lote', $lote);
        $this->db->update('inventario_d', $data); 
//**        
        }else{
//**
        $new_member_insert_data = array(
			'clave' => $clave,
            'lote' => $lote,
            'caducidad' => $cad,
            'cantidad' => $row1->cane,
		);
		
		$insert = $this->db->insert('inventario_d', $new_member_insert_data);    
        }
            $data0=array(
            'inv'=> 'S'
            );        
            $this->db->where('id', $id_pro);
            $this->db->update('traspaso_d', $data0); 
 ////_____________________________________///   
        }else{
////_____________________________________///SALE MERCANCIA DEL ALMACEN

        $sql = "SELECT * FROM inventario_d where clave= ? and lote = ? ";
        $query = $this->db->query($sql,array($clave,$lote));
  
        if($query->num_rows() == 1){
          
        $row= $query->row();
        $existencia=$row->cantidad;
    
$data = array(
			'cantidad'=> $existencia-$row1->cans
		);
		$this->db->where('clave', $clave);
        $this->db->where('lote', $lote);
        $this->db->update('inventario_d', $data); 
//**        
        }else{
//**
        $new_member_insert_data = array(
			'clave' => $clave,
            'lote' => $lote,
            'caducidad' => $cad,
            'cantidad' => 0 - $row1->cans
		);
		
		$insert = $this->db->insert('inventario_d', $new_member_insert_data);    
        }
            $data0=array(
            'inv'=> 'S'
            );        
            $this->db->where('id', $id_pro);
            $this->db->update('traspaso_d', $data0); 
        }
 ////_____________________________________///

         
$data1 = array(
			'tipos' => 2,
            'tipoe' => 2,
			'fecha'=> date('Y-m-d H:s:i')
		);
		$this->db->where('id', $id);
        $this->db->update('traspaso_c', $data1); 
}
}
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
}