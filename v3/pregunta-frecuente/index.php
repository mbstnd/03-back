<?php
include_once '../version1.php';

//valores de los parametros
$existeId = false;
$valorId = 0;
$existsAction = false;
$valueAction = 0;

if (count($_parametros) > 0) {
    foreach ($_parametros as $p) {
        if (strpos($p, 'id') !== false) {
            $existeId = true;
            $valorId = explode('=', $p)[1];
        }
        if (strpos($p, 'action') !== false) {
            $existsAction = true;
            $valueAction = explode('=', $p)[1];
        }
    }
}

if ($_version == 'v3') {
    if ($_mantenedor == 'pregunta-frecuente') {
        switch ($_metodo) {
            case 'GET':
                if ($_header == $_token_get) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $lista = $control->getAll();
                    http_response_code(200);
                    echo json_encode(["data" => $lista]);
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion GET"]);
                }
                break;
            case 'POST':
                if ($_header == $_token_post) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $body = json_decode(file_get_contents("php://input", true));
                    // var_dump($body);
                    $respuesta = $control->postNuevo($body);
                    if ($respuesta) {
                        http_response_code(201);
                        echo json_encode(["data" => $respuesta]);
                    } else {
                        http_response_code(409);
                        echo json_encode(["data" => "Error: El nombre ingresado ya existe. Por favor, elija un nombre diferente."]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion POST"]);
                }
                break;
            case 'PATCH':
                if ($_header == $_token_patch) {
                    if ($existeId && $existsAction) {
                        include_once 'controller.php';
                        include_once '../conexion.php';
                        $control = new Controlador();
                        if ($valueAction == 'encender') {
                            // echo "patch...id: $valorId action:$valueAction";
                            $respuesta = $control->patchEncenderApagar($valorId, 'true');
                            http_response_code(200);
                            echo json_encode(["data" => $respuesta]);
                        } else if ($valueAction == 'apagar') {
                            $respuesta = $control->patchEncenderApagar($valorId, 'false');
                            http_response_code(200);
                            echo json_encode(["data" => $respuesta]);
                        } else {
                            http_response_code(400);
                            echo json_encode(["Error" => "Los parámetros proporcionados no son los requeridos. Por favor, revise la documentación y envíe los parámetros correctos."]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["Error" => "Los parámetros proporcionados no son los requeridos. Por favor, revise la documentación y envíe los parámetros correctos."]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion PATCH"]);
                }
                break;
            case 'PUT':
                if ($_header == $_token_put) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $contadorEntradas = 2;

                    $body = json_decode(file_get_contents("php://input", true));
                    // var_dump($body);
                    if (strlen($body->pregunta) > 0) {
                        $respuesta = $control->putPreguntaById($body->pregunta, $body->id);
                        $contadorEntradas--;
                    }
                    if (strlen($body->respuesta) > 0) {
                        $respuesta = $control->putRespuestaById($body->respuesta, $body->id);
                        $contadorEntradas--;
                    }
                    if ($contadorEntradas <= 1) {
                        //entro y modifico las 2
                        http_response_code(200);
                        echo json_encode(["data" => $respuesta]);
                    } else {
                        //no entro ni modifico
                        http_response_code(409);
                        echo json_encode(["data" => false]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorizacion PUT"]);
                }
                break;
                case 'DELETE':
                    if ($_header == $_token_delete) {
                        include_once 'controller.php';
                        include_once '../conexion.php';
                        $control = new Controlador();
                        if ($existeId) {
                            $listado = $control->getAll();
                            $existeRegistro = false;
                            foreach ($listado as $item) {
                                if ($item['id'] == $valorId) {
                                    $existeRegistro = true;
                                }
                            }
                            if (!$existeRegistro) {
                                http_response_code(404);
                                echo json_encode(["data" => false]);
                            } else {
                                $respuesta = $control->deleteById($valorId);
                                http_response_code(200);
                                echo json_encode(["data" => $respuesta]);
                            }
                        } else {
                            http_response_code(406);
                            echo json_encode(["data" => false]);
                        }
                    } else {
                        http_response_code(401);
                        echo json_encode(["Error" => "No tiene autorizacion DELETE"]);
                    }
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["Error" => "No implementado"]);
                    break;
        }
    }
}
