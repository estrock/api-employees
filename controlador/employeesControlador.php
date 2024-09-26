<?php 


class ControladorEmployees{
    private function validarCampos($datos) {
        $errores = [];
        /*=============================================
		Validar nombre
		=============================================*/

        if (isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["nombre"])) {
           // $errores[] = "Error en el campo del nombre, solo se permiten letras";
            array_push($errores,"Error en el campo del nombre, solo se permiten letras");
        }
        /*=============================================
		Validar apellido
		=============================================*/

        if (isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["apellido"])) {
          //  $errores[] = "Error en el campo del apellido, solo se permiten letras";
            array_push($errores,"Error en el campo del apellido, solo se permiten letras");
        }
        /*=============================================
		Validar correo
		=============================================*/

        if (isset($datos["correo"]) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $datos["correo"])) {
           // $errores[] = "Error en el campo correo";
            array_push($errores,"Error en el campo correo");
        }

        
        //

        return $errores;
    }
    private function validarCorreo($datos) {
        /*=============================================
		Validar correo repetido
		=============================================*/
        $errores = [];
        $empleados=ModeloEmployees::index("employees",null,null,null,null);
         foreach ($empleados  as $key => $value) {

            if($value["correo"] == $datos["correo"]){

                 
                array_push($errores, "el email esta repetido");
                

             }
        }
        return $errores;

    }


    public function index($pagina,$nombre,$department){

        if ($pagina !=null) {
            /*=============================================
		Validar si es una consulta paginada
		=============================================*/
            $cantidad = 3;
            $desde=($pagina-1)*$cantidad;
            $employees=ModeloEmployees::index("employees",$cantidad,$desde,null,null);
            $json=array(
                "status"=>200,
                "total_registros"=>count($employees),
                "detalle"=>$employees );
                echo json_encode($json,true);
                return;

        }else if($nombre != null){
            /*=============================================
		Validar si es una consulta filtrada por nombre
		=============================================*/
            $employees=ModeloEmployees::index("employees",null,null,$nombre,null);
            $json=array(
                "status"=>200,
                "total_registros"=>count($employees),
                "detalle"=>$employees );
                echo json_encode($json,true);
                return;
        }else if($department != null){
            /*=============================================
		Validar si es una consulta filtrada por departamento
		=============================================*/
            $employees=ModeloEmployees::index("employees",null,null,null,$department);
            $json=array(
                "status"=>200,
                "total_registros"=>count($employees),
                "detalle"=>$employees );
                echo json_encode($json,true);
                return;
        }else{
        $employees=ModeloEmployees::index("employees",null,null,null,null);
        $json=array(
        "status"=>200,
        "total_registros"=>count($employees),
        "detalle"=>$employees );
        echo json_encode($json,true);
        return;
        }
    }

    public function create($datos){
        /*=============================================
		funcion para registrar
		=============================================*/
        $errores = $this->validarCampos($datos);
        $errores = $this->validarCampos($datos);
   
        $datos = array("nombre"=>$datos["nombre"],
        "apellido"=>$datos["apellido"],
        "correo"=>$datos["correo"],
        "puesto"=>$datos["puesto"],
        "salario"=>$datos["salario"],
        "fechaCont"=>$datos["fechaCont"],
        "idRolFK"=>$datos["idRolFK"]);
        
        if (!empty($errores)) {
            $json = [
                "status" => 404,
                "detalle" => $errores
            ];
            echo json_encode($json, true);
            return;
        }
        $create=ModeloEmployees::create("employees",$datos);
        if($create == "ok"){

            $json=array(


                    "status"=>404,
                    "detalle"=> "se genero sus credenciales"

            );

            echo json_encode($json,true);

            return;
        }
        

    }

    public function show($id){
        /*=============================================
		funcion para guardar un solo registro
		=============================================*/
        $employee=ModeloEmployees::show("employees",$id);
        if (!empty($employee)) {
            
            $json=array(

            "status"=>"200",
            "detalle"=>$employee

                        );

            echo json_encode($json,true);

            return;
        }else {
            $json = array(

                "status"=>200,
                "detalles"=>"No hay ningún empleado registrado"
                
            );

            echo json_encode($json, true);	

            return;
        }
        
    }

    public function update($id, $datos){
        $errores = $this->validarCampos($datos);
        /*=============================================
		actualizar un registro
		=============================================*/


        $data = array("id"=>$id,
        "nombre"=>$datos["nombre"],
        "apellido"=>$datos["apellido"],
        "correo"=>$datos["correo"],
        "puesto"=>$datos["puesto"],
        "salario"=>$datos["salario"],
        "fechaCont"=>$datos["fechaCont"],
        "idRolFK"=>$datos["idRolFK"]);
       if (!empty($errores)) {
        $json = [
            "status" => 404,
            "detalle" => $errores
        ];
        echo json_encode($json, true);
        return;
        }

        //
        $employee=ModeloEmployees::show("employees",$id);
        if (!empty($employee)) {
            $update = ModeloEmployees::update("employees", $data);

            if($update == "ok"){

                $json = array(
                "status"=>200,
                "detalle"=>"Registro exitoso, su empleado ha sido actualizado"); 
            
                echo json_encode($json, true); 

                return;  
            }else{

                $json = array(

                "status"=>404,
                "detalle"=>"No se pudo modificar el empleado");

                echo json_encode($json, true);

                return;
            }         
        }else {
            $json = array(

                "status"=>200,
                "detalles"=>"No hay ningún empleado registrado"
                
            );

            echo json_encode($json, true);	

            return;
        }
       
    }

    public function delete($id){
        /*=============================================
		eliminar un registro
		=============================================*/
        ///***
        $employee=ModeloEmployees::show("employees",$id);
        if (!empty($employee)) {
            $delete = ModeloEmployees::delete("employees", $id);

            if($delete== "ok"){

                $json = array(
                    "status"=>200,
                    "detalle"=>"se ha borrado el empleado");
                echo json_encode($json, true);
                return;
            }
           
        }else {
            $json = array(

                "status"=>200,
                "detalles"=>"No hay ningún empleado registrado"
                
            );

            echo json_encode($json, true);	

            return;
        }
    }

}



?>