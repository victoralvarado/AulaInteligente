<?php
require_once("Conexion.php");

class ComandoAC
{
    private $id;
    private $idAC;
    private $comando;
    public $db;

    public function __construct()
    {
        $this->db = conectar();
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
    public function getComando()
    {
        return $this->comando;
    }

    /**
     * @param mixed $comando
     *
     * @return self
     */
    public function setComando($comando)
    {
        $this->comando = $comando;

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

    public function getLastCommand()
    {
        $sqlAll = "SELECT comando FROM comandoac WHERE idAC=".$this->idAC."  ORDER BY id DESC LIMIT 1;";
        $info = $this->db->query($sqlAll);
        if(mysqli_num_rows($info) > 0)
        {
            $data = $info->fetch_assoc();
            $resComando=$data['comando'];
        }
        else
        {
            $resComando="N/A";
        }

        return $resComando;
    }

    public function saveComando()
    {
        $sql="INSERT INTO comandoac values (0,".$this->idAC.",'".$this->comando."');";
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

    public function deleteComando()
    {
        $sql="DELETE FROM comandoac WHERE idAC=".$this->idAC.";";
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

}

?>