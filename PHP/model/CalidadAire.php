<?php
require_once("Conexion.php");

class CalidadAire
{
    private $id;
    private $temperatura;
    private $humedad;
    private $idAula;
    private $idAC;
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
    public function getTemperatura()
    {
        return $this->temperatura;
    }

    /**
     * @param mixed $temperatura
     *
     * @return self
     */
    public function setTemperatura($temperatura)
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHumedad()
    {
        return $this->humedad;
    }

    /**
     * @param mixed $humedad
     *
     * @return self
     */
    public function setHumedad($humedad)
    {
        $this->humedad = $humedad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdAula()
    {
        return $this->idAula;
    }

    /**
     * @param mixed $idAula
     *
     * @return self
     */
    public function setIdAula($idAula)
    {
        $this->idAula = $idAula;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdAC()
    {
        return $this->idAC;
    }

    /**
     * @param mixed $idAC
     *
     * @return self
     */
    public function setIdAC($idAC)
    {
        $this->idAC = $idAC;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     *
     * @return self
     */
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }

    public function getAllCalidadAire()
    {
        $sql = "SELECT * FROM calidadaire;";
        $info = $this->db->query($sql);
        if ($info->num_rows>0) {
            $dato = $info;
        }else{

            $dato = false;
        }
        return $dato;
    }

    public function saveCalidadAire()
    {
        $sql="INSERT INTO calidadaire values (0,".$this->temperatura.",".$this->humedad.", ".$this->idAula.", ".$this->idAC.");";
        $res=$this->db->query($sql);
        $data=array();
        if($res)
        {
            $data['estado']=true;
            $data['descripcion']='Datos ingresado exitosamente';
        }
        else
        {
            $data['estado']=false;
            $data['descripcion']='Ocurrio un error en la inserción '.$this->db->error;
        }

        return $data;
    }

    public function updaCalidadAire()
    {
        $sql="UPDATE calidadaire SET temperatura=".$this->temperatura.", humedad=".$this->humedad.", idAula=".$this->telefono.", idAC=".$this->idAC." WHERE id=".$this->id.";";
            $res=$this->db->query($sql);
            $data=array();
            if($res)
            {
                $data['estado']=true;
                $data['descripcion']='Datos modificados exitosamente';
            }
            else
            {
                $data['estado']=false;
                $data['descripcion']='Ocurrio un error en la modificación '.$this->db->error;
            }

            return $data;
    }

    public function deleteCalidadAire()
    {
        $sql="DELETE FROM calidadaire WHERE id =".$this->id.";";
            $res=$this->db->query($sql);
            $data=array();
            if($res)
            {
                $data['estado']=true;
                $data['descripcion']='Registro eliminado exitosamente.';
            }
            else
            {
                $data['estado']=false;
                $data['descripcion']='Ocurrio un error en la eliminación: '.$this->db->error;
            }

            return $data;
    }

    public function getLastCalidadAC()
    {
        $sqlAll = "SELECT * FROM calidadaire WHERE idAC=".$this->idAC."  ORDER BY id DESC LIMIT 1;";
        $info = $this->db->query($sqlAll);
        $arreglo = array();

        if(mysqli_num_rows($info) > 0)
        {
            $data = $info->fetch_assoc();
            $arreglo['temperatura']=$data['temperatura'];
            $arreglo['humedad']=$data['humedad'];
        }
        else
        {
            $arreglo['temperatura']=null;
            $arreglo['humedad']=null;
        }

        return $arreglo;
    }

    public function getAverageCalidadAC()
    {
        $sqlAll = "SELECT AVG(temperatura) AS temperatura, AVG(humedad) AS humedad FROM calidadaire WHERE idAC=".$this->idAC.";";
        $info = $this->db->query($sqlAll);
        $arreglo = array();

        if(mysqli_num_rows($info) > 0)
        {
            $data = $info->fetch_assoc();
            $arreglo['temperatura']=$data['temperatura'];
            $arreglo['humedad']=$data['humedad'];
        }
        else
        {
            $arreglo['temperatura']=null;
            $arreglo['humedad']=null;
        }

        return $arreglo;
    }

}

?>