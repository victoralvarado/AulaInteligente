<?php
require_once ("Conexion2Prueba.php");
class Alumno
{
    private $id;
    private $carnet;
    private $nombres;
    private $apellidos;
    private $activo;
    public $db;

    public function __construct()
    {
        $this->db = conectar();
    }


     /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarnet()
    {
        return $this->carnet;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setCarnet($carnet)
    {
        $this->carnet = $carnet;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     * @return self
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     * @return self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    public function getAllAlumnos()
    {
        $sql = "SELECT * FROM alumnos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result : false;
    }

    public function getOneAlumno($id)
    {
        $sql = "SELECT * FROM alumnos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result : false;
    }

    public function getOneAlumnoCarnet($carnet)
    {
        $sql = "SELECT carnet FROM alumnos WHERE carnet = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $carnet);
        $stmt->execute();
        $stmt->bind_result($c);
        $stmt->fetch();
        return $c;
    }

    public function getAllAlumnosActivos()
    {
        $sql = "SELECT * FROM alumnos WHERE activo = ? ORDER BY apellidos DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $this->activo);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result : false;
    }

    public function saveAlumno()
    {
        $sql = "INSERT INTO alumnos (carnet, nombres, apellidos, activo) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssi", $this->carnet, $this->nombres, $this->apellidos, $this->activo);
        $res = $stmt->execute();
        $data = array();
        if ($res) {
            $data['estado'] = true;
            $data['descripcion'] = 'Datos ingresados exitosamente';
        } else {
            $data['estado'] = false;
            $data['descripcion'] = 'Ocurrió un error en la inserción: ' . $this->db->error;
        }
        return $data;
    }

    public function updateAlumno()
    {
        $sql = "UPDATE alumnos SET carnet = ?, nombres = ?, apellidos = ?, activo = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssii", $this->carnet, $this->nombres, $this->apellidos, $this->activo, $this->id);
        $res = $stmt->execute();
        $data = array();
        if ($res) {
            $data['estado'] = true;
            $data['descripcion'] = 'Datos modificados exitosamente';
        } else {
            $data['estado'] = false;
            $data['descripcion'] = 'Ocurrió un error en la modificación: ' . $this->db->error;
        }
        return $data;
    }

    public function getCarnetById($id)
    {
        $sql = "SELECT carnet FROM alumnos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($carnet);
        $stmt->fetch();
        return $carnet;
    }

    public function deleteAlumno()
    {
        $sql = "DELETE FROM alumnos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $res = $stmt->execute();
        $data = array();
        if ($res) {
            $data['estado'] = true;
            $data['descripcion'] = 'Registro eliminado exitosamente.';
        } else {
            $data['estado'] = false;
            $data['descripcion'] = 'Ocurrió un error en la eliminación: ' . $this->db->error;
        }
        return $data;
    }
}
