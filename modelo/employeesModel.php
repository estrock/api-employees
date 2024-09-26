<?php


require_once "conexion.php";


class ModeloEmployees{


    static public function index($tabla1,$cantidad,$desde,$nombre,$department){
        /*=============================================
		consulta dependiendo de los parametros
		=============================================*/


        if($cantidad !=null){

            $stmt=Conexion::conectar()->prepare("SELECT * from employee_details LIMIT $desde,$cantidad");


         }
        else if($nombre !=null){
            $stmt=Conexion::conectar()->prepare("SELECT * from employee_details where nombre = $nombre");
        }if($department !=null){
            $stmt=Conexion::conectar()->prepare("SELECT * from employee_details where department_descrip = $department");
        }  else{

          $stmt=Conexion::conectar()->prepare("SELECT * from employee_details");

        }
        


        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->close();

        $stmt=null;


    }



    static public function create($tabla, $datos){
        /*=============================================
		insertar registros
		=============================================*/

        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, apellido, correo, puesto, salario, fechaCont, idRolFK, idDepartmentFK) VALUES (:nombre, :apellido, :correo, :puesto, :salario, :fechaCont, :idRolFK, :idDepartmentFK)");

        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":puesto", $datos["puesto"], PDO::PARAM_STR);
		$stmt -> bindParam(":salario", $datos["salario"], PDO::PARAM_STR);
		$stmt -> bindParam(":fechaCont", $datos["fechaCont"], PDO::PARAM_STR);
		$stmt -> bindParam(":idRolFK", $datos["idRolFK"], PDO::PARAM_STR);
		$stmt -> bindParam(":idDepartmentFK", $datos["idDepartmentFK"], PDO::PARAM_STR);

        if($stmt -> execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;

    }


    static public function show($tabla1,$id){
        /*=============================================
		consulta por id
		=============================================*/

        $stmt=Conexion::conectar()->prepare("SELECT * from employee_details where id=:id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->close();

        $stmt=null;




    }


    static public function update($tabla , $datos){
        /*=============================================
		actualiza
		=============================================*/
        
        $stmt=Conexion::conectar()->prepare("UPDATE employees SET nombre=:nombre,apellido=:apellido,correo=:correo,puesto=:puesto,salario=:salario,idRolFK=:idRolFK,fechaCont=:fechaCont WHERE idEmployee=:id");
       

        $stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
        $stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":puesto", $datos["puesto"], PDO::PARAM_STR);
		$stmt -> bindParam(":salario", $datos["salario"], PDO::PARAM_STR);
		$stmt -> bindParam(":fechaCont", $datos["fechaCont"], PDO::PARAM_STR);
		$stmt -> bindParam(":idRolFK", $datos["idRolFK"], PDO::PARAM_INT);
        //echo $stmt;
        if($stmt -> execute()){

			return "ok";

		}else{
			print_r(Conexion::conectar()->errorInfo());
		}

		$stmt-> close();

		$stmt = null;



    }


    static public function delete($tabla,$id){
         /*=============================================
		elimina
		=============================================*/

         $stmt=Conexion::conectar()->prepare("DELETE  FROM $tabla WHERE idEmployee=:id");
        


        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){

            return "ok";


        }else{

            print_r(Conexion::conectar()->errorInfo());



        }

      
	    $stmt-> close();

		$stmt = null;






    }




}






?>