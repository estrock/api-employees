<?php 
// Validamos la ruta en la que se encuentra y la guardamos en un array
$arrayRutas=explode("/",$_SERVER['REQUEST_URI']);   

// Si en el array se encuentra el metodo get y la variable ?pagina=1 o cualquier numero filtra por paginacion de 3 registros
if(isset($_GET["pagina"]) && is_numeric($_GET["pagina"])&&isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){

    $empleados=new ControladorEmployees();
    $empleados->index($_GET["pagina"],null,null);



}else if(isset($_GET["nombre"]) && is_string($_GET["nombre"])&&isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){
    // Si en el array se encuentra el metodo get y la variable ?nombre filtra por los nombres de los empleados
    $empleados=new ControladorEmployees();
    $empleados->index(null,$_GET["nombre"]);
}else if(isset($_GET["departamento"]) && is_string($_GET["departamento"])&&isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){
    // Si en el array se encuentra el metodo get y la variable ?departamento filtra por departamento 
    $empleados=new ControladorEmployees();
    $empleados->index(null,null,$_GET["departamento"]);
}
else{

if (count(array_filter($arrayRutas))==1) {
    // Si en el array se encuentra en la raiz http://localhost/proyectoprueba/ no muestra nada  
    $json=array(
        "detalle"=>"no encontrado"
    );
    echo json_encode($json,true);
    return;
}else{
    // Si en el array se encuentra dentro de http://localhost/proyectoprueba/employees valida metodo y parametros y llama la funcion en employeesControlador
    if (count(array_filter($arrayRutas))==2) {
        if(array_filter($arrayRutas)[2]=="employees") {

            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="POST"){
                
                $postBody = json_decode(file_get_contents("php://input"));
                $data = array("nombre"=>$postBody->nombre,
                            "apellido"=>$postBody->apellido,
                            "correo"=>$postBody->correo,
                            "puesto"=>$postBody->puesto,
                            "salario"=>$postBody->salario,
                            "fechaCont"=>$postBody->fechaCont,
                            "idRolFK"=>$postBody->idRolFK,
                            "idDepartmentFK"=>$postBody->idDepartmentFK);
                $employee=new ControladorEmployees();
                $employee->create($data);
 
            }else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){
                $employee=new ControladorEmployees();
                $employee->index(null);

            }
        }
    }else if (array_filter($arrayRutas)[2]=="employees" && is_numeric(array_filter($arrayRutas)[3])) {
     
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="GET"){
        $employee=new ControladorEmployees();
        $employee->show(array_filter($arrayRutas)[3]);

        }else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="PUT"){

            $postBody = json_decode(file_get_contents("php://input"));
            $data = array(
                        "nombre"=>$postBody->nombre,
                        "apellido"=>$postBody->apellido,
                        "correo"=>$postBody->correo,
                        "puesto"=>$postBody->puesto,
                        "salario"=>$postBody->salario,
                        "fechaCont"=>$postBody->fechaCont,
                        "idRolFK"=>$postBody->idRolFK);

             $employee=new ControladorEmployees();
             $employee->update(array_filter($arrayRutas)[3],$data);
    
        }else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=="DELETE"){
            $employee=new ControladorEmployees();
            $employee->delete(array_filter($arrayRutas)[3]);
    
        }
    }
    


}}

?>