<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoadData extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$this->load->model('registro_model');

		if(file_exists('./tmplog.log')):
			$lines = file('./tmplog.log');

			foreach($lines as $line):
				$line = trim($line);
				$exline = explode(',', $line);
				
				if($exline[0] == 'l2tp'&& $exline[1] !='debug' && isset($exline[2])):
					$exdesc = explode(' ', trim(mb_ereg_replace('[<>]','',$exline[2])));
						if(isset($exdesc[1])):
							if($exdesc[0] =='info'):
								$exuser = explode('-', $exdesc[1]);
								$User = mb_ereg_replace(':','', $exuser[1]);
									if($exdesc[2] !='terminating...' && $exdesc[2] !='authenticated'):
										//echo $exdesc[0].' ';
										// echo $User.' ,';
										// echo $exdesc[2].' ,';

										$key = mb_ereg_replace('-','', $exdesc[4]).mb_ereg_replace('[:.]','',$exdesc[5]); 
										//echo mb_ereg_replace('-','', $exdesc[4]).' ,';
										//echo $exdesc[5].' <br>';
										$extime = explode('.', $exdesc[5]);
									
										// echo $extime[0].',';

										// echo $key.'<br>';
										if($exdesc[2]=='connected'):
											$register = $this->registro_model->buscar(array('usuario'=>$User,'key_login'=>$key));
											if(!$register):
 
												$data = array(
													'key_login'=>$key,
													'usuario'=>$User,
													'conectado'=>$extime[0]
												);
												$this->registro_model->salvar($data);
											endif;
										elseif($exdesc[2]=='disconnected'):
											$register = $this->registro_model->buscar(array('usuario'=>$User,'key_logout'=>$key));
											if(!$register):
												$this->registro_model->editar($User,array('desconectado'=>$extime[0],'key_logout'=>$key));
											endif;
										else:

										endif;
						
									endif;
							endif;
						endif;
				endif;
			endforeach;
		else:
			echo json_encode(array('retorno'=>'erro'));
		endif;

	}

	public function ReturDataOn()
	{
		$this->load->model('registro_model');

		$return = $this->registro_model->listar(array('desconectado'=>null));

		echo json_encode($return);
	}

	public function ReturData()
	{
		date_default_timezone_set('America/Sao_Paulo');
		$start = ($this->input->post('start'))? $this->dateEmMysql($this->input->post('start')):'2019-04-02';
		$end = ($this->input->post('end'))? $this->dateEmMysql($this->input->post('end')):date('Y-m-d');
		$user = ($this->input->post('user'))? "and usuario ='".$this->input->post('user')."'":'' ;


		$query = "data BETWEEN CAST('".$start."' AS DATE) AND CAST('".$end."' AS DATE)".$user;
		

		$this->load->model('registro_model');
		
		$return = $this->registro_model->listar($query);

		echo json_encode($return);

		 
	}

	public static function dateEmMysql($dateSql){
		$ano= substr($dateSql, 6);
		$mes= substr($dateSql, 3,-5);
		$dia= substr($dateSql, 0,-8);
		return $ano."-".$mes."-".$dia;
	}


	


}
