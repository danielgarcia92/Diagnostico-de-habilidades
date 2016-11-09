<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Encuesta_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function actualizarACK($id) {
		$data = array(
			'ack' => 'SI'
		);
		$this->db->where('id', $id);
		$datos = $this->db->update('resultados', $data);

		return $datos;
	}

	public function carrerasSel($divisionId) {
		$this->db->where('id_divisiones', $divisionId);
		$this->db->order_by('nombre');
		$consulta = $this->db->get('carreras');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}

	public function comprobarExistente($matricula) {
		$this->db->select('matricula');
		$this->db->select('periodo_realizo_encuesta AS periodo_realizo_encuesta');
		$this->db->where('matricula', $matricula);
		$consulta = $this->db->get('resultados');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'] = $consulta->row($i);

 		return $datos;
	}

	public function correctasPorNivel($i, $id, $R, $variable) {
		$this->db->select('CAT.puntos AS Puntos');
		$this->db->join('catalogo CAT', 'CAT.id_respuesta = RES.'.$R.' AND CAT.id_pregunta = '.$i.' AND CAT.variable = ' . $variable, 'left');
		$this->db->where('RES.id', $id);
		$consulta = $this->db->get('resultados RES');
 		$datos = $consulta->row()->Puntos;

 		return $datos;
	}

	public function divisionesSel() {
		$consulta = $this->db->get('divisiones');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}

	public function ingresoAEncuesta($datos) {
		$this->db->insert('ingreso', $datos);
	}

	public function insertarResultados($lista) {
		$this->db->insert('resultados', $lista);
		$insertId = $this->db->insert_id();
		return  $insertId;
	}

	public function obtenerNivel($parametro, $tema) {
		$this->db->select('nivel');
		$this->db->where($parametro . ' >= ' . $tema . '_porcen_menor');
		$this->db->where($parametro . ' <= ' . $tema . '_porcen_mayor');
		$consulta = $this->db->get('interpretacion_resultados');
 		$datos = $consulta->row()->nivel;
 		return $datos;
	}

	public function preguntasSel() {
		$this->db->select('titulo');
		$this->db->select('pregunta');
		$this->db->select('requerido');
		$this->db->select('id_pregunta AS preguntaId');
		$this->db->select('id_tipo_pregunta AS preguntaTipo');
		$this->db->group_by('id_pregunta');
		$consulta = $this->db->get('catalogo');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}

	public function respuestasSel($preguntaId) {
		$this->db->select('id_respuesta AS respuestaId');
		$this->db->select('respuesta');
		$this->db->where('id_pregunta', $preguntaId);
		$consulta = $this->db->get('catalogo');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}

	public function semestresSel(){
		$consulta = $this->db->get('semestres');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}

	public function totalPorNivel() {
		$this->db->select('Tema');
		$this->db->select('Total');
		$consulta = $this->db->get('puntuacion_por_tema');
		$datos['longitud'] = $consulta->num_rows();
		for ($i=0; $i < $datos['longitud']; $i++)
 			$datos['resultados'][$i] = $consulta->row($i);

 		return $datos;
	}

}
