<?php
class Registro_model extends CI_Model {
    public $id='idregistro';
    public $tabela='registros';

	public function salvar($resposta){

		    $this->db->insert($this->tabela,$resposta);
            $retorno= $this->db->insert_id();
     
		return $this->buscar(array($this->id=>$retorno));
	}



	public function editar($id, $where= array())
	{
		$this->db->where("usuario",$id);
		$this->db->where('desconectado',null);
		$query = $this->db->update($this->tabela,$where);
		return $query;
	}
	
	public function listar ($where=array()){

		$this->db->where($where);
		$this->db->order_by('indice','desc');
		return $this->db->get($this->tabela)->result_array();
    }

	public function listarAprovar ($where=array()){

		$this->db->select('registros.*, ROUND(SUM(registros.valor),2) as valor, registros.quinzena, usuario.nome as nome,usuario.sobrenome as sobrenome, veiculo.modelo as modelo, veiculo.placa as placa');
		$this->db->join("usuario","registros.IDusuario = usuario.IDusuario","inner");
		$this->db->join("veiculo","registros.IDveiculo = veiculo.IDveiculo","inner");
		$this->db->where("aprovado",1);
		//$this->db->where("mesreferencia",$mesref['mesreferencia']);
		$this->db->group_by("registros.IDveiculo, registros.mesreferencia, registros.quinzena");
		
		return $this->db->get($this->tabela)->result_array();
    }
	
	public function buscar ($where=array()){

		$this->db->where($where);
		return $this->db->get($this->tabela)->row_array();
    }

    public function excluir($id, $where=array()){
		$this->db->where($this->id, $id);
		$this->db->delete($this->tabela);
	}
}


