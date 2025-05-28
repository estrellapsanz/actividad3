<?php

declare(strict_types=1);

namespace Tfe\Controller;

use DateTimeZone;
use Laminas\Http\Header\SetCookie;
use Laminas\View\Model\ViewModel;

/*use Tfe\Model\Entity\Parametro;
use Tfe\Model\Entity\ParametroPsico;*/

use Tfe\Util\Constantes;


class IndexController extends MasterController
{

    /**
     * @return ViewModel
     */
    public function homeAction()
    {
        
        /* https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/help
         *  1.https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/ComunidadesAutonomas/
         *   2.https://datos.gob.es/es/catalogo/e05068001-precio-de-carburantes-en-las-gasolineras-espanolas
        */

        $urls = [
            ["COD_URL" => 0,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/ComunidadesAutonomas/",
                "NOMBRE" => "Comunidades Autónomas"
            ],
            ["COD_URL" => 1,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/Provincias/",
                "NOMBRE" => "Provincias"

            ], ["COD_URL" => 2,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/Municipios/",
                "NOMBRE" => "Municipios"

            ],
            ["COD_URL" => 3,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/Listados/ProductosPetroliferos/",
                "NOMBRE" => "Listado Productos petrolíferos"
            ],
            ["COD_URL" => 4,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/FiltroCCAA/10",
                "NOMBRE" => "Estaciones de Servicios Comunidad Valenciana"
            ],
            ["COD_URL" => 5,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/PostesMaritimos/FiltroProvincia/08",
                "NOMBRE" => "Listado de postes por Provincia (08, Barcelona) y producto (1, gasolina)"
            ],
            ["COD_URL" => 6,
                "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestresHist/FiltroMunicipio/21-11-2024/4288",
                "NOMBRE" => "Precios de estaciones de servicio para el día (12-01-2025) y el municipio Aranjuez (4288)"
            ],

        ];

        $request = $this->getRequest();
        $post = ($request->isPost()) ? $request->getPost() : null;

        $uri = $request->getUri()->getPath();
        $data = null;

        $peticion = -1;

        if ($request->isPost()) {

            $post = $request->getPost();

            if (isset($post['url']) || isset($post['campos_opcionales'])) {
                // URL de la API
                $url = $urls[$post['url']]['URL'];
                $peticion = $post['url'];

                // Inicializar cURL
                $ch = curl_init($url);

                // Configuración de opciones cURL
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Obtener respuesta como string
                curl_setopt($ch, CURLOPT_HTTPGET, true); // Método GET

                // Ejecución de la solicitud
                $response = curl_exec($ch);

                // Verificar si hubo algún error
                if (curl_errno($ch)) {
                    echo "Error en la solicitud: " . curl_error($ch);
                } else {
                    // Decodificar JSON en un array asociativo
                    $data = json_decode($response, true);

                    // Mostrar respuesta
                    /*echo "<pre>";
                    print_r($data);
                    echo "</pre>";
                    die;*/

                }

                // Cerrar la conexión cURL
                curl_close($ch);
            }


        } else
            //$this->controlErrores();
            $data = null;

        return new ViewModel(
            [
                'urls' => $urls,
                'data' => $data,
                'peticion' => $peticion,
                'locationData' => $this->geolocalizacion()
            ]);
    }


    private function geolocalizacion()
    {
        $zh = new DateTimeZone("Europe/Madrid");
        $locationData = [
            'Location' => $zh->getLocation(),
            //'Timezone' => timezone_location_get($zh)
        ];
        return [
            'locationData' => $locationData,
        ];

    }


    /*
     * Función para desconectar (borrar la cookie)
     */

    /*private function controlErrores()
     {
         //Comprobamos si al hacer un login erroneo, guardamos las operaciones antes de que sean destruidas

         if ($this->sesion->offsetExists('estado_operacion'))
             $eo = $this->sesion->offsetGet('estado_operacion');
         if ($this->sesion->offsetExists('error'))
             $e = $this->sesion->offsetGet('error');

         $estudiante = $this->sesion->offsetGet(Constantes::SESION_ESTUDIANTE);
         $docente = $this->sesion->offsetGet(Constantes::SESION_DOCENTE);

         // destruimos la sesion
         $this->sesion->offsetUnset('estado_operacion');
         $this->sesion->offsetUnset('error');
         $this->sesion->offsetUnset(Constantes::SESION_USUARIO);
         $this->sesion->offsetUnset(Constantes::SESION_USUARIO_DOCENTE);
         $this->sesion->offsetUnset(Constantes::SESION_NOMBRE_USUARIO);
         $this->sesion->offsetUnset(Constantes::CURRENT_URL);


         // al destruir la sesion si hubo algún error los volvemos a recuperar, y creamos los estados en la sesió
         if (!empty($eo)) {
             $this->sesion->estado_operacion = $eo;
         }
         if (!empty($e)) {
             $this->sesion->error = $e;
         }
         if (!empty($estudiante)) {
             $this->sesion->offsetSet(Constantes::SESION_ESTUDIANTE, $estudiante);
         }
         if (!empty($docente)) {
             $this->sesion->offsetSet(Constantes::SESION_DOCENTE, $docente);
         }
     }
 */

    /*
     * Función auxiliar para controlar todo lo almacenado en sesion
     */

    /* public function desconectarAction()
        {
            $this->controlErrores();
            //Borramos la cookie
            $this->getResponse()->getHeaders()->addHeader(new SetCookie(Constantes::NOMBRE_COOKIE, "", time() - 1, "/", Constantes::DOMINIO_COOKIE));
            //Redireccionamos
            return $this->redirect()->toRoute("login");
        }
    */

}
