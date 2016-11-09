<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-Type: text/html; charset=utf-8');
class Encuesta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database('default');
        $this->load->model('Encuesta_model');
    }
	
	public function index() {
		if( isset($_GET['token']) || isset($_POST['token']) ) {
            $data = $_GET['token'];
            if(isset($_POST['token'])) $data = $_POST['token'];
            $this->session->set_userdata('token', $data);
            $key = "f969c5b9320c33912948824e";
            $data = base64_decode($data);
            $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');
            $block = mcrypt_get_block_size('tripledes', 'ecb');
            $len = strlen($data);
            $pad = ord($data[$len-1]);
            $variables = substr($data, 0, strlen($data) - $pad);
            $cabecera = substr($variables, 0, 5);
            
            if ($cabecera == 'DITSI') {
                $variables = explode("|", $variables);

                if (isset($variables[0]) && isset($variables[1]) && isset($variables[2]) && isset($variables[3]) && isset($variables[4]) && isset($variables[5]) ) {
                    date_default_timezone_set('America/Monterrey');
                    $hora = date("H:i:s");
                    $fecha = date("Y-m-d");
                    $matricula = substr($variables[0], 5);
                    $lista = array(
                        'hora'      => $hora,
                        'fecha'     => $fecha,
                        'nombre'    => $variables[1],
                        'ingreso'   => 'si',
                        'matricula' => $matricula
                    );
                    $this->Encuesta_model->ingresoAEncuesta($lista);
                    $this->session->set_userdata('matricula', $matricula);
                    $this->session->set_userdata('nombre', $variables[1]);
                    $this->session->set_userdata('carrera', $variables[2]);
                    $this->session->set_userdata('division', $variables[3]);
                    $this->session->set_userdata('periodo_ingreso_profesional', $variables[4]);
                    $this->session->set_userdata('periodo_realizo_encuesta', $variables[5]);
                    $this->load->view('Encuesta_view');
                } else
                    redirect('http://www.udem.edu.mx');
            } else
                redirect('http://www.udem.edu.mx');

        } else
            redirect('http://www.udem.edu.mx');
	}

    public function actualizarACK() {
        $datos = $this->Encuesta_model->actualizarACK($_POST['idResul']);
        print_r(json_encode($datos));
    }

    public function carrerasSel() {
        $datos = $this->Encuesta_model->carrerasSel($_POST['divisionId']);
        print_r(json_encode($datos));
    }

    public function cerrarSesion() {
        //$resultado = file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='.$this->session->userdata('accessTokenEncuesta'));
        $this->session->unset_userdata('matricula');
        $this->session->unset_userdata('nombre');
        $this->session->unset_userdata('carrera');
        $this->session->unset_userdata('division');
        $this->session->unset_userdata('periodo_realizo_encuesta');
        $this->session->unset_userdata('periodo_ingreso_profesional');
        $this->session->sess_destroy();
        redirect('http://www.udem.edu.mx');
    }

    public function divisionesSel() {
        $datos = $this->Encuesta_model->divisionesSel();
        print_r(json_encode($datos));
    }

    public function insertar() {
        $existente = $this->Encuesta_model->comprobarExistente($this->session->userdata('matricula'));
        if ( !isset($existente['resultados']->periodo_realizo_encuesta) || $existente['resultados']->periodo_realizo_encuesta != $this->session->userdata('periodo_realizo_encuesta') ) {
            date_default_timezone_set('America/Monterrey');
            $lista['id_encuesta'] = 1;
            $lista['nombre'] = $this->session->userdata('nombre');
            $lista['carrera'] = $this->session->userdata('carrera');
            $lista['division'] = $this->session->userdata('division');
            $lista['matricula'] = $this->session->userdata('matricula');
            $lista['periodo_realizo_encuesta'] = $this->session->userdata('periodo_realizo_encuesta');
            $lista['periodo_ingreso_profesional'] = $this->session->userdata('periodo_ingreso_profesional');
            $lista['fecha'] = date("Y-m-d H:i:s");
            $lista['ack'] = 'NO';
            foreach ($_POST as $variable => $valor) {
                $lista[$variable] = $valor;
            }
            $datos['exito'] = true;
            $datos['idResul'] = $this->Encuesta_model->insertarResultados($lista);
        } else {
            $datos['exito'] = false;
            $datos['idResul'] = 0;
        }

        $this->load->view('Captura_view', $datos);
    }

    public function porcentajes() {
        $civica = 0;
        $politica = 0;
        $liderazgo = 0;
        $sostenibilidad = 0;
        $interculturalidad = 0;

        for ($i=1; $i <= 60; $i++) {
            $R = 'R'.$i;
            $resultados = $this->Encuesta_model->correctasPorNivel($i, $_POST['idResul'], $R, "'Liderazgo'");
            $liderazgo = $liderazgo + $resultados;
            $resultados = $this->Encuesta_model->correctasPorNivel($i, $_POST['idResul'], $R, "'Sostenibilidad'");
            $sostenibilidad = $sostenibilidad + $resultados;
            $resultados = $this->Encuesta_model->correctasPorNivel($i, $_POST['idResul'], $R, "'Interculturalidad'");
            $interculturalidad = $interculturalidad + $resultados;
            $resultados = $this->Encuesta_model->correctasPorNivel($i, $_POST['idResul'], $R, "'Participación ciudadana - Cívica'");
            $civica = $civica + $resultados;
            $resultados = $this->Encuesta_model->correctasPorNivel($i, $_POST['idResul'], $R, "'Participación Ciudadana - Política'");
            $politica = $politica + $resultados;
        }

        $datos['total'] = $this->Encuesta_model->totalPorNivel();

        $datos['Civica'] = round($civica / $datos['total']['resultados'][2]->Total * 100, 0);
        $datos['Politica'] = round($politica / $datos['total']['resultados'][3]->Total * 100, 0);
        $datos['Liderazgo'] = round($liderazgo / $datos['total']['resultados'][1]->Total * 100, 0);
        $datos['Sostenibilidad'] = round($sostenibilidad / $datos['total']['resultados'][4]->Total * 100, 0);
        $datos['Interculturalidad'] = round($interculturalidad / $datos['total']['resultados'][0]->Total * 100, 0);

        if ($datos['Civica'] == 0)
            $datos['porcCivica'] = 'Por desarrollar';
        else
            $datos['porcCivica'] = $this->Encuesta_model->obtenerNivel($datos['Civica'], 'Civica');

        if ($datos['Politica'] == 0)
            $datos['porcPolitica'] = 'Por desarrollar';
        else
            $datos['porcPolitica'] = $this->Encuesta_model->obtenerNivel($datos['Politica'], 'Politica');

        if ($datos['Liderazgo'] == 0)
            $datos['porcLiderazgo'] = 'Por desarrollar';
        else
            $datos['porcLiderazgo'] = $this->Encuesta_model->obtenerNivel($datos['Liderazgo'], 'Liderazgo');

        if ( $datos['Sostenibilidad'] == 0)
            $datos['porcSostenibilidad'] = 'Por desarrollar';
        else
            $datos['porcSostenibilidad'] = $this->Encuesta_model->obtenerNivel($datos['Sostenibilidad'], 'Sostenibilidad');

        if ($datos['Interculturalidad'] == 0)
            $datos['porcInterculturalidad'] = 'Por desarrollar';
        else
            $datos['porcInterculturalidad'] = $this->Encuesta_model->obtenerNivel($datos['Interculturalidad'], 'Interculturalidad');

        $datos['token'] = $this->session->userdata('token');
        $datos['nombre'] = $this->session->userdata('nombre');
        $datos['matricula'] = $this->session->userdata('matricula');
        date_default_timezone_set('America/Monterrey');
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $datos['fecha'] = date('d')."/".$meses[date('n')-1]. "/".date('Y');
        print_r(json_encode($datos));
    }

    public function preguntasSel() {
        $datos['preguntas'] = $this->Encuesta_model->preguntasSel();
        for ($i=0; $i < $datos['preguntas']['longitud']; $i++) { 
            $datos['respuestas'][$i] = $this->Encuesta_model->respuestasSel($datos['preguntas']['resultados'][$i]->preguntaId);
        }
        print_r(json_encode($datos));
    }

    public function semestresSel() {
        $datos = $this->Encuesta_model->semestresSel();
        print_r(json_encode($datos));
    }

}

?>
