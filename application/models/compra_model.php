<?php
	class Compra_model extends CI_Model {

    function pendiente()
    {
       
       $sql = "SELECT * FROM almacen.compraped where aplica_bo<cansbo and cansbo>0 and tipo3='C' order by prv,folprv, clabo";
        $query = $this->db->query($sql);
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Orden</th>
        <th>Clave</th>
        <th align=\"left\">Sustancia Activa</th>
        <th align=\"left\">Pedido</th>
        <th align=\"left\">Pendiente</th>
        <th align=\"left\">_</th>
        <th align=\"left\" colspan=\"2\">Proveedor</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
          $can=$row->cansbo-$row->aplica_bo;  
            $tabla.="
            <tr>
            <td align=\"center\">".$row->folprv."</td>
            <td align=\"center\">".$row->clabo."</td>
            <td align=\"left\">".$row->susa."</td>
            <td align=\"right\">".number_format($row->cansbo,0)."</td>
            <td align=\"right\">".number_format($can,0)."</td>
            <td align=\"left\"> - </td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            
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

    function control()
    {
       
       $this->db->select('a.*,b.razon');
       $this->db->from('compra_c a');
       $this->db->join('catalogo.compa b', 'a.cia=b.cia');
       $this->db->where('tipo',0);
       $query = $this->db->get();
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th>Orden</th>
        <th>Factura</th>
        <th align=\"left\" colspan=\"2\">Proveedor</th>
        <th align=\"left\" colspan=\"2\">Compa&ntilde;ia</th>
        <th align=\"left\">Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('compra_c/detalle/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('compra_c/delete_c/'.$row->id, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar factura!', 'class' => 'encabezado'));
            $l3 = anchor('compra_c/cierre_c/'.$row->id.'/'.$row->orden, '<img src="'.base_url().'img/icons/emoticon/emoticon_bomb.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para cerrar factura!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->orden."</td>
            <td align=\"center\">".$row->factura."</td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            <td align=\"left\">".$row->cia."</td>
            <td align=\"left\">".$row->razon."</td>
            <td align=\"left\">".$row->fecha."</td>
            <td align=\"left\">$l1</td>
            <td align=\"left\">$l2</td>
            <td align=\"left\">$l3</td>
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

   function detalle_d($id_cc)
    {
       
       $this->db->select('a.*,b.susa1');
       $this->db->from('farmabodega.compra_d a');
       $this->db->join('catalogo.catalogo_bodega b', 'a.clave=b.clabo');
       $this->db->where('id_cc',$id_cc);
       $this->db->order_by('id desc');
       $query = $this->db->get();
        
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        
        </tr>
        <tr>
        <th>Clave</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Regalo</th>
        <th>Lote</th>
        <th>Caducidad</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $totcan=0;
        $num=0;
        $totcanr = 0;
        foreach($query->result() as $row)
        {
            $l1 = anchor('compra_c/delete_d/'.$row->id.'/'.$id_cc, '<img src="'.base_url().'img/icons/icon_error.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para borrar productos!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->clave."</td>
            <td align=\"left\">".$row->susa1."</td>
            <td align=\"center\">".$row->can."</td>
            <td align=\"center\">".$row->canr."</td>
            <td align=\"center\">".$row->lote."</td>
            <td align=\"center\">".$row->caducidad."</td>
            <td align=\"center\">$l1</td>
            </tr>
            ";
        $totcan= $totcan + $row->can;
        $totcanr= $totcanr + $row->canr;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
            <td align=\"left\">Productos= $num</td>
            <td align=\"center\">TOTAL</td>
            <td align=\"center\">".$totcan."</td>
            <td align=\"center\">".$totcanr."</td>
        </tr>
        </tbody>
        </table>";
        
        return $tabla;
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
    function control_historico()
    {
       
       $this->db->select('a.*,b.razon');
       $this->db->from('compra_c a');
       $this->db->join('catalogo.compa b', 'a.cia=b.cia');
       $this->db->where('tipo', 1);
       $this->db->order_by('fecha desc');
       $query = $this->db->get();
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        <th>Orden</th>
        <th>Factura</th>
        <th align=\"left\" colspan=\"2\">Proveedor</th>
        <th align=\"left\" colspan=\"2\">Compa&ntilde;ia</th>
        <th align=\"left\">Fecha</th>
        </tr>
        </thead>
        <tbody>
        ";
        
        foreach($query->result() as $row)
        {
            $l1 = anchor('compra_c/detalle_historico/'.$row->id, '<img src="'.base_url().'img/icons/list-style/icon_list_style_arrow.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para agregar productos a la factura!', 'class' => 'encabezado'));
            $l2 = anchor('compra_c/imprime_d/'.$row->id, '<img src="'.base_url().'img/reportes2.png" border="0" width="20px" /></a>', array('title' => 'Haz Click aqui para imprimir factura!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
            <td align=\"center\">".$row->orden."</td>
            <td align=\"center\">".$row->factura."</td>
            <td align=\"left\">".$row->prv."</td>
            <td align=\"left\">".$row->prvx."</td>
            <td align=\"left\">".$row->cia."</td>
            <td align=\"left\">".$row->razon."</td>
            <td align=\"left\">".$row->fecha."</td>
            <td align=\"left\">$l1</td>
            <td align=\"left\">$l2</td>
            
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
       
       $this->db->select('a.*,b.susa1');
       $this->db->from('farmabodega.compra_d a');
       $this->db->join('catalogo.catalogo_bodega b', 'a.clave=b.clabo');
       $this->db->where('id_cc',$id_cc);
       $query = $this->db->get();
        
        
        
        
        
        $tabla= "
        <table id=\"hor-minimalist-b\">
        <thead>
        <tr>
        <th colspan=\"5\">$tit</th>
        
        <tr>
        <th>Clave</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Regalo</th>
        <th>Lote</th>
        <th>Caducidad</th>
        </tr>
        
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
            <td align=\"center\">".$row->can."</td>
            <td align=\"center\">".$row->canr."</td>
            <td align=\"center\">".$row->lote."</td>
            <td align=\"center\">".$row->caducidad."</td>
            
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


function trae_datos_c($id_cc){
    $sql = "SELECT *  FROM compra_c  where id= ? ";
    $query = $this->db->query($sql,array($id_cc));
     return $query;
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
function create_member_c($folio,$tipo,$cia,$factura)
	{

         
       $sql = "SELECT * FROM almacen.compraped where cansbo>0 and aplica_bo<cansbo and folprv = ? group by folprv";
        $query = $this->db->query($sql,array($folio));
        if($query->num_rows() > 0){
        
        $row= $query->row();
        $prv=$row->prv;    
        $prvx=$row->prvx;
        
        
        $sql1 = "SELECT * FROM compra_c where factura= ? and prv= ? and orden= ? ";
       $query1 = $this->db->query($sql1,array($factura,$prv,$folio));
       
       if($query1->num_rows()== 0 and $cia>0){
        
    //////////////////////////////////////////////inserta los datos en la base de datos
    	
        $new_member_insert_data = array(
			'orden' => $folio,
			'prv' => $prv,
			'prvx' => $prvx,
            'tipo' => $tipo,			
			'fecha'=> '0000-00-00:00:00',
            'factura'=> str_replace(' ', '',strtoupper(trim($factura))),
            'cia'=> $cia,
			'foliocxp' => 0						
		);
		
		$insert = $this->db->insert('compra_c', $new_member_insert_data);
		
	}

}
 return FALSE;
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////

function create_member_d($id_cc,$orden,$clave,$lote,$cad,$can,$canr)
	{
        
       $sql = "SELECT * FROM almacen.compraped where cansbo>0 and aplica_bo<cansbo and folprv = ? and clabo = ? and cansbo - aplica_bo +1000 > ? ";
        $query = $this->db->query($sql,array($orden,$clave,$can));
        
        //echo $this->db->last_query();
        //die();
        
        
        if($query->num_rows() > 0){
        
        $row= $query->row();
        $cansbo=$row->cansbo;    
        $costo=$row->costo;
        $codigo=$row->codigo; 
        
        
        $sql1 = "SELECT * FROM compra_d where id_cc= ? and clave= ? and lote= ? ";
       $query1 = $this->db->query($sql1,array($id_cc,$clave,$lote));
       
       if($query1->num_rows()== 0){
        
    //////////////////////////////////////////////inserta los datos en la base de datos
    	
        $new_member_insert_data = array(
			'id_cc' => $id_cc,
			'clave' => $clave,
			'lote' =>  str_replace(' ', '',strtoupper(trim($lote))),
            'caducidad' => $cad,
			'can' => $can,
			'fecha'=> date('Y-m-d H:s:i'),
            'canp'=> $cansbo,
            'costo'=> $costo,
            'codigo'=>$codigo,
            'canr'=> $canr
            						
		);
		
		$insert = $this->db->insert('compra_d', $new_member_insert_data);
		
	}

}
 return FALSE;
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_c($id)
{
        $this->db->delete('compra_c', array('id' => $id));
        $this->db->delete('compra_d', array('id_cc' => $id));

}    
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function delete_member_d($id)
{
        $this->db->delete('compra_d', array('id' => $id));

} 
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
function cierre_member_c($id, $orden)
{
    $this->__cierra_compra_c($id);


///*****
$sql0 = "SELECT * FROM compra_d where id_cc= ? and aplica='NO' ";
       $query0 = $this->db->query($sql0,array($id));
       foreach($query0->result() as $row0)
        {
       
        
        //////////////////////////////////////////////////////////////////inventario_d
        // clave, can, lote, caducidad
        
        $this->__actualiza_inventario_d($row0->id,$row0->clave, $row0->can,$row0->canr, $row0->lote, $row0->caducidad, $row0->costo, $row0->codigo);
        
        
        //////////////////////////////////////////////////////////////////compraped
        
        $this->__actualiza_compraped($orden, $row0->clave, $row0->can);

        //////////////////////////////////////////////////////////////////
       }
///*****
//++++++++++++++++++++++++++++//++++++++++++++++++++++++++++/++++++++++++++++++++++++++++/++++++++++++++++++++++++++++/inv        
$scxp = "SELECT *from catalogo.foliador1 where clav='cxp' ";
        $qcxp = $this->db->query($scxp);
        if($qcxp->num_rows() >0){
        $rcxp= $qcxp->row();
        $folcxp=$rcxp->num;
        
        $dataf = array(
        'foliocxp'=> $folcxp
        );
        $this->db->where('id', $id);
        $this->db->update('compra_c', $dataf);
        
        $datacxp = array(
        'num'     => $folcxp+1
        );
        $this->db->where('clav', 'cxp');
        $this->db->update('catalogo.foliador1', $datacxp);  
        
        
        }
        
}

private function __cierra_compra_c($id)
{
    //Actualiza el tipo en compra_c para cerrar una factura
        $data = array(
			'tipo' => 1,
			'fecha'=> date('Y-m-d H:s:i')
		);
		
		$this->db->where('id', $id);
        $this->db->update('compra_c', $data);
        
        return $this->db->affected_rows();

}

private function __actualiza_inventario_d($id_d,$clave, $cantidad,$cantidadr, $lote, $caducidad,$costo,$codigo)
{
        $sql2 = "SELECT * FROM inventario_d where clave= ? and lote = ? ";
           $query2 = $this->db->query($sql2,array($clave,$lote));
           if($query2->num_rows()== 0){
                   $new_member_insert_data = array(
			       'clave' => $clave,
                   'lote' => $lote,
                   'caducidad' => $caducidad,
			       'cantidad' => $cantidad+$cantidadr,
                   'costo'=>$costo,
                   'codigo'=>$codigo
		           );
		
		  $insert = $this->db->insert('inventario_d', $new_member_insert_data);
          }else{
           $row2= $query2->row();
           $cantidad_existente = $row2->cantidad;
            
                  $data1 = array(
			      'cantidad' => $cantidad +$cantidadr + $cantidad_existente
			      );
		
		$this->db->where('clave', $clave);
        $this->db->where('lote', $lote);
        $this->db->update('inventario_d', $data1);     
        }
        
 ////////////////////////// actualiza compra_d para que no dupliquen existencia
$aplica_d='SI';
$data4 = array(
			  'aplica' => $aplica_d
			  );
		
		$this->db->where('id', $id_d);
        $this->db->update('compra_d', $data4);            
 //////////////////////////
    
}

private function __actualiza_compraped($orden, $clave, $cantidad)
{
        $sql3 = "SELECT * FROM almacen.compraped where folprv= ? and clabo = ? ";
        $query3 = $this->db->query($sql3,array($orden, $clave));
        $row3= $query3->row();
        $aplica= $row3->aplica_bo;
        $data2 = array(
			      'aplica_bo' => $aplica + $cantidad
			      );
		
		$this->db->where('folprv', $orden);
        $this->db->where('clabo', $clave);
        $this->db->update('almacen.compraped', $data2);  
    
}

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function imprime_detalle($id)
    {
        $tocan=0;
        $tocanr=0;
        $num=0;
        $sql = "SELECT a.*,b.susa1
        from compra_d a
        left join catalogo.catalogo_bodega b on a.clave=b.clabo
        where a.id_cc= ? order by clave";
        $query = $this->db->query($sql,array($id));
        
        $tabla= "
        <table id=\"hor-minimalist-b\" >
        <thead>
        <tr>
        <th colspan=\"6\">_____________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"70\"><strong>Clave</strong></th>
        <th width= \"280\"><strong>Sustancia Activa</strong></th>
        <th width= \"80\" align=\"left\"><strong>Lote</strong></th>
        <th width= \"80\" align=\"right\"><strong>Caducidad</strong></th>
        <th width= \"60\" align=\"right\"><strong>Cantidad</strong></th>
        <th width= \"60\" align=\"right\"><strong>Regalo</strong></th>
        </tr>
        <tr>
        <th colspan=\"6\">_____________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"70\" align=\"left\">".$row->clave."</td>
            <td width= \"280\" align=\"left\">".$row->susa1."</td>
            <td width= \"80\" align=\"left\">".$row->lote."</td>
            <td width= \"80\" align=\"right\">".$row->caducidad."</td>
            <td width= \"60\" align=\"right\">".$row->can."</td>
            <td width= \"60\" align=\"right\">".$row->canr."</td>
            
            
            </tr>
            ";
        $tocan=$tocan+$row->can;
        $tocanr=$tocanr+$row->canr;
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"6\">_____________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"510\" align=\"left\">Total de productos.: $num</td>
        <td width= \"60\" align=\"right\">".$tocan."</td>
        <td width= \"60\" align=\"right\">".$tocanr."</td>
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
function imprime_control($fecha)
    {
        $tocan=0;
        $num=0;
        $sql = "SELECT * from compra_c where tipo=1 and date_format(fecha, '%Y-%m-%d')= ?
        order by id";
        
        $query = $this->db->query($sql,array($fecha));
        
        $tabla= "
        <table id=\"hor-minimalist-b\" >
        <thead>
        <tr>
        <th colspan=\"6\">__________________________________________________________________________________________</th>
        </tr>
        
        <tr>
        <th width= \"80\" align=\"center\"><strong>Cia</strong></th>
        <th width= \"90\" align=\"center\"><strong>Foliocxp</strong></th>
        <th width= \"90\" align=\"left\"><strong>Factura</strong></th>
        <th width= \"90\" align=\"center\"><strong>Prv</strong></th>
        <th width= \"145\" align=\"left\"><strong>Proveedor</strong></th>
        <th width= \"111\" align=\"right\"><strong>Orden de Compra</strong></th>
        </tr>
        <tr>
        <th colspan=\"6\">_________________________________________________________________________________________</th>
        </tr>
        </thead>
        <tbody>
        ";
  
        
        foreach($query->result() as $row)
        {

            $tabla.="
            <tr>
            <td width= \"80\" align=\"center\">".$row->cia."</td>
            <td width= \"90\" align=\"center\">".$row->foliocxp."</td>
            <td width= \"90\" align=\"left\">".$row->factura."</td>
            <td width= \"90\" align=\"center\">".$row->prv."</td>
            <td width= \"145\" align=\"left\">".$row->prvx."</td>
            <td width= \"111\" align=\"right\">".$row->orden."</td>
            
            
            </tr>
            ";
        
        $num=$num+1;
        }
        
        $tabla.="
        <tr>
        <th colspan=\"6\">_________________________________________________________________________________________</th>
        </tr>
        <tr>
        <td width= \"530\" align=\"left\">Total de Facturas.: $num</td>
        
        </tr>
        
        </tbody>
        </table>";
        
        return $tabla;
        
    }
/////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////    
}