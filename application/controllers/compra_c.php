<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compra_c extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('login');
		}		
	}	

///////////////////////////////////////////////////////////  
///////////////////////////////////////////////////////////
	public function tabla_pendiente()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE FARMABODEGA";
       $data['contenido'] = "compra_c/compra_c";
       $data['tabla'] = $this->compra_model->pendiente();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
     
	public function tabla_control()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE FARMABODEGA";
       $data['contenido'] = "compra_c/compra_c_form";
       $data['tabla'] = $this->compra_model->control();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function insert_c()
	{
	$folio= $this->input->post('folio');
    $factura= $this->input->post('factura');
    $cia= $this->input->post('cia');
    $tipo=0;  
	$this->load->model('compra_model');
    $this->compra_model->create_member_c($folio,$tipo,$cia,$factura);
    redirect('compra_c/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle($id_cc)
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       $trae = $this->compra_model->trae_datos_c($id_cc);
       $row = $trae->row();
       
       $data['tit'] = "PROVEEDOR:  $row->prv - $row->prvx   <br />  FACTURA: $row->factura";
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE FARMABODEGA";
       $data['id_cc'] =$id_cc;
       $data['orden'] =$row->orden;
       $data['contenido'] = "compra_c/compra_d_form";
       $data['tabla'] = $this->compra_model->detalle_d($id_cc);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
 ///////////////////////////    
 /////////////////////////// 
 function insert_d()
	{
	$id_cc= $this->input->post('id_cc');
    $orden= $this->input->post('orden');
    $clave= $this->input->post('clave');
    $lote= $this->input->post('lote');
    $cad= $this->input->post('cad');
    $can= $this->input->post('can');
    $canr= $this->input->post('canr');
    $this->load->model('compra_model');
    $this->compra_model->create_member_d($id_cc,$orden,$clave,$lote,$cad,$can,$canr);
    redirect('compra_c/detalle'."/".$id_cc);
    
    }


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_c($id)
	{
	$this->load->model('compra_model');
    $this->compra_model->delete_member_c($id);
    redirect('compra_c/tabla_control');
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function delete_d($id,$id_cc)
	{
	$this->load->model('compra_model');
    $this->compra_model->delete_member_d($id);
    redirect('compra_c/detalle'."/".$id_cc);
    
    }
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
  function cierre_c($id, $orden)
	{
	$this->load->model('compra_model');
    $this->compra_model->cierre_member_c($id, $orden);
    redirect('compra_c/tabla_control');
    
    }   
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

	public function tabla_control_historico()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "HISTORICO  DE COMPRA DE FARMABODEGA";
       $data['contenido'] = "compra_c/compra_c";
       $data['tabla'] = $this->compra_model->control_historico();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

//////////////////////////////////////////////////////
//////////////////////////////////////////////////////    
	public function detalle_historico($id_cc)
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       $trae = $this->compra_model->trae_datos_c($id_cc);
       $row = $trae->row();
       
       $tit = "PROVEEDOR:  $row->prv - $row->prvx   <br />  FACTURA: $row->factura";
       
       $data['titulo'] = "HISTORICO  DE COMPRA DE FARMABODEGA";
       $data['id_cc'] =$id_cc;
       $data['orden'] =$row->orden;
       $data['contenido'] = "compra_c/compra_d";
       $data['tabla'] = $this->compra_model->detalle_d_historico($id_cc,$tit);
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}

 
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
   function imprime_d($id_cc)
	{
		
            $this->load->model('compra_model');
            $trae = $this->compra_model->trae_datos_c($id_cc);
            $row = $trae->row();
            
            $data['cabeza'] = "
            <table>
            <tr>
            <td colspan=\"6\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"6\" align=\"center\">FACTURA DE ALMACEN FARMABODEGA</td>
            </tr>
            <tr>
            <td colspan=\"6\"> PROVEEDOR:  $row->prv - $row->prvx</td>   
            </tr>
            <tr>
            <td colspan=\"6\">  FACTURA: $row->factura</td>
            </tr>
            <tr>
            <td colspan=\"6\"> ORDEN DE COMPRA:  $row->orden</td>
            </tr>
            <tr>
            <td colspan=\"6\"><strong align=\"right\">ORDEN DE CXP:  $row->foliocxp</strong></td>
            </tr>
            <tr> 
            <td colspan=\"6\">  FECHA DE CAPTURA : $row->fecha</td>
            </tr>
            </table>
            
            ";
            $data['detalle'] = $this->compra_model->imprime_detalle($id_cc); 
			$this->load->view('impresiones/reporte', $data);
			
		
		}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
     
     
	public function periodo_reporte()
	{
	   $data = array();
       $data['menu'] = 'compra';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('compra_model');
       
       $data['titulo'] = "CAPTURA DE PEDIDOS DE COMPRA DE FARMABODEGA";
       $data['contenido'] = "compra_c/compra_c_form_periodo_reporte";
       $data['tabla'] = $this->compra_model->control();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}



//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
   function imprime_concentrado()
	{
		
            $this->load->model('compra_model');
            
            $data['cabeza'] = "
            <table>
            
            <tr>
            <td colspan=\"5\" align=\"right\">Fecha de impresion.:".date('Y-m-d H:s:i')."</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"center\">FACTURA DE ALMACEN FARMABODEGA</td>
            </tr>
            <tr>
            <td colspan=\"5\" align=\"left\">Fecha de Entrada.:".$this->input->post('fecha')."</td>
            </tr>
            </table>
            
            ";
            $data['detalle'] = $this->compra_model->imprime_control($this->input->post('fecha')); 
			$this->load->view('impresiones/reporte', $data);
			
		
		}

//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////   
}