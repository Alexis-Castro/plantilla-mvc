<?php


class Usuario_Model extends Model
{


	public function __construct()
	{

		parent::__construct();
	}
	public function listarUsuario()
	{

		return $this->db->query("CALL  SP_LISTAR_USUARIOS()");
	}

	public function listarUsuariosWhere($valor)
	{

		return $this->db->query("CALL  SP_LISTAR_USUARIO_WHERE ($valor)");
	}


	public function insertarUsuario($data)
	{

		try {
			$sql = "CALL SP_INSERTAR_USUARIO(?,?,?,?,?,@mensaje)";

			$sth = $this->db->prepare($sql);

			$sth->bindParam(1, $data["usuario"], PDO::PARAM_STR);
			$sth->bindParam(2, $data["nombres"], PDO::PARAM_STR);
			$sth->bindParam(3, $data["clave"], PDO::PARAM_STR);
			$sth->bindParam(4, $data["fechacreacion"], PDO::PARAM_STR);
			$sth->bindParam(5, $data["correo"], PDO::PARAM_STR);

			$sth->execute();
			$sth->closeCursor();

			$ms = $this->db->query("select @mensaje as mensaje")->fetch(PDO::FETCH_ASSOC);
			$mensaje = sprintf($ms["mensaje"]);
			return $mensaje;
		} catch (Exception $e) {

			$mensaje = "Error del sistema" . $e->getMessage();
			return $mensaje;
		}
	}


	public function Buscar_Usuario($id)
	{

		$sql = "CALL  sp_listar_usuario_where($id)";


		$sth = $this->db->prepare($sql);
		$sth->execute();
		$data = $sth->fetch();
		return $data;
	}


	public function modificarUsuario($data)
	{

		try {
			$sql = "CALL sp_modificar_usuario(?,?,?,?,?,@mensaje)";
			$sth = $this->db->prepare($sql);

			$sth->bindParam(1, $data["idusuario"], PDO::PARAM_INT);
			$sth->bindParam(2, $data["usuario"], PDO::PARAM_STR);
			$sth->bindParam(3, $data["nombres"], PDO::PARAM_STR);
			$sth->bindParam(4, $data["clave"], PDO::PARAM_STR);
			$sth->bindParam(5, $data["correo"], PDO::PARAM_STR);


			$sth->execute();
			$sth->closeCursor();

			$ms = $this->db->query("select @mensaje as mensaje")->fetch(PDO::FETCH_ASSOC);
			$mensaje = sprintf($ms["mensaje"]);
			return $mensaje;
		} catch (Exception $e) {

			$mensaje = "Error del sistema " . $e->getMessage();
			return $mensaje;
		}
	}

	public function modificarEstadoUsuario($data)
	{

		try {
			$sql = "CALL  SP_CAMBIARESTADO_USUARIO(?,?,@mensaje)";
			$sth = $this->db->prepare($sql);

			$sth->bindParam(1, $data["idusuario"], PDO::PARAM_STR);
			$sth->bindParam(2, $data["estado"], PDO::PARAM_STR);


			$sth->execute();
			$sth->closeCursor();

			$ms = $this->db->query("select @mensaje as mensaje")->fetch(PDO::FETCH_ASSOC);
			$mensaje = sprintf($ms["mensaje"]);
			return $mensaje;
		} catch (Exception $e) {

			$mensaje = "Error del sistema" . $e->getMessage();
			return $mensaje;
		}
	}

	// public function eliminarUsuario($data)
	// {
	// 	try {
	// 		$sql = "CALL sp_eliminar_usuario(?,@mensaje)";
	// 		$sth = $this->db->prepare($sql);

	// 		$sth->bindParam(1, $data["idusuario"], PDO::PARAM_STR);

	// 		$sth->execute();
	// 		$sth->closeCursor();

	// 		$ms = $this->db->query("select @mensaje as mensaje")->fetch(PDO::FETCH_ASSOC);
	// 		$mensaje = sprintf($ms["mensaje"]);
	// 		return $mensaje;

	// 	} catch (Exception $e) {
	// 		$mensaje = "Error del sistema" . $e->getMessage();
	// 		return $mensaje;
	// 	}
	// }
}
