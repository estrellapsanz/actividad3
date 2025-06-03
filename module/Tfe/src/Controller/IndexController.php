<?php

declare(strict_types=1);

namespace Tfe\Controller;

use DateTimeZone;
use Laminas\Http\Header\SetCookie;
use Laminas\View\Model\ViewModel;
use Tfe\Util\Constantes;

class IndexController extends MasterController
{

    /**
     * @return ViewModel
     */
    public function homeAction()
    {

        //por defecto, geolocalizamos
        $peticion = -1;
        //obtenemos: localidades, municipios y provincias
        $comunidades = $this->obtenerComunidades();  //0
        $provincias = $this->obtenerProvincias();    //1
        $municipios = $this->obtenerMunicipios();    //2


        //datos de post
        $request = $this->getRequest();
        $post = ($request->isPost()) ? $request->getPost() : null;

        $uri = $request->getUri()->getPath();
        $data = null;


        if ($request->isPost()) {

            $post = $request->getPost();

            if (isset($post['url']) || (isset($post['peticion']) && $post['peticion'] != -1)) {

                if (isset($post['url'])) {
                    //parte 1
                    $url = Constantes::URLS_PETICIONES_API[$post['url']]['URL'];
                    $peticion = $post['url'];
                } else {
                    //parte2

                    $peticion = $post['peticion'];

                    switch ($peticion) {
                        case '7': //peticion de estaciones de servicios por comunidades autónomas
                            $url = str_replace('cod_comunidad', $post['comunidad'], Constantes::URLS_PETICIONES_API[$peticion]['URL']);
                            break;
                        case '8': //peticion de estaciones de servicios por comunidades autónomas
                            $url = str_replace('cod_provincia', $post['cod_provincia'], Constantes::URLS_PETICIONES_API[$peticion]['URL']);
                            break;
                        case '9': //precio de estaciones de servicios por día
                            $url = str_replace('fecha', $post['fecha'], Constantes::URLS_PETICIONES_API[$peticion]['URL']);
                            break;
                    }

                }

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
                    echo "<pre>";
                    print_r($data);
                    echo "</pre>";
                    die;

                }

                // Cerrar la conexión cURL
                curl_close($ch);
            } else
                $data = null;

        } else
            $data = null;

        return new ViewModel(
            [
                'urls' => Constantes::URLS_PETICIONES_API,
                'data' => $data,
                'peticion' => $peticion,
                'locationData' => $this->geolocalizacion(),
                'comunidades' => $comunidades,
                'provincias' => $provincias,
                'municipios' => $municipios,
                'cod_comunidad' => (isset($post['comunidad']) ? $post['comunidad'] : null),
                'cod_municipio' => (isset($post['cod_provincia']) ? $post['cod_provincia'] : null),
                'id_fecha' => (isset($post['fecha']) ? $post['fecha'] : null),
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


    private function obtenerComunidades()
    {
        // Inicializar cURL
        $ch = curl_init(Constantes::URLS_PETICIONES_API[0]['URL']);

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

        }

        // Cerrar la conexión cURL
        curl_close($ch);
        return $data;
    }

    private function obtenerProvincias()
    {
        // Inicializar cURL
        $ch = curl_init(Constantes::URLS_PETICIONES_API[1]['URL']);

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

        }

        // Cerrar la conexión cURL
        curl_close($ch);
        return $data;
    }

    private function obtenerMunicipios()
    {
        // Inicializar cURL
        $ch = curl_init(Constantes::URLS_PETICIONES_API[2]['URL']);

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

        return $data;
    }

}
