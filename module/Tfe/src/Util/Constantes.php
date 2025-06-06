<?php

/**
 *
 */

namespace Tfe\Util;


class Constantes
{


    /*URL PETICIONES*/
    const URLS_PETICIONES_API = [

        //PETICIONES PARA PARTE 2
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

        //PETICIONES PARTE 1
        ["COD_URL" => 4,
            "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/FiltroCCAA/10",
            "NOMBRE" => "Estaciones de Servicios Comunidad Valenciana"
        ],
        ["COD_URL" => 5,
            "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/PostesMaritimos/FiltroProvinciaProducto/8/1",
            "NOMBRE" => "Listado de postes por Provincia (08, Barcelona) y producto (1, gasolina)"
        ],
        ["COD_URL" => 6,
            "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestresHist/FiltroMunicipio/12-01-2025/4288",
            "NOMBRE" => "Precios de estaciones de servicio para el día (12-01-2025) y el municipio Aranjuez (4288)"
        ],
        ["COD_URL" => 7,
            "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/FiltroCCAA/cod_comunidad",
            "NOMBRE" => "Estaciones de Servicios por Comunidad Autónoma"
        ],
        ["COD_URL" => 8,
            "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/PostesMaritimos/FiltroProvincia/cod_provincia",
            "NOMBRE" => "Listado de postes por Provincia"
        ],
        ["COD_URL" => 9,
            "URL" => "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestresHist/fecha",
            "NOMBRE" => "Precios de las estaciones de servicio por día"
        ]

    ];

    /*ESTADO DE LAS OPERACIONES*/
    const ESTADO_OPERACION = 'estado_operacion';
    const ESTADO_OPERACION_OK = "operacion_ok";
    const ESTADO_OPERACION_ERROR = "operacion_error";


    /*RUTAS*/
    const CURRENT_URL = 'current_url';

    /*CONSTANTES PARA INFORMACIÓN DE USUARIO EN SESIÓN*/
    const NOMBRE_SESION = 'sesionTecEmergentes';
    const SESION_USUARIO = "usuario";
    const SESION_NOMBRE_USUARIO = "nombreUsuario";
    const SESION_USUARIO_DOCENTE = "usuarioDocente";
    const SESION_ESTUDIANTE = "estudiante";
    const SESION_DOCENTE = "docente";


    //NOMBRE SESION
    const SITE_TITULO = "Laminas-TEC_EMER";
    const NOMBRE_COOKIE = "unir_login";
    const DOMINIO_COOKIE = ".nir.es";


    static function full_url()
    {
        $s = $_SERVER;
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = self::class . substr($sp, 0, strpos($sp, '/'));
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = (isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : isset($s['HTTP_HOST'])) ? $s['HTTP_HOST'] : $s['SERVER_NAME'];
        return $protocol . '://' . $host . $port . $s['REQUEST_URI'];
    }

    static function rutaRoot()
    {
        return Constantes::full_host() . "/laminas-tecnologias3/public";
    }

    //PRAMETROS DE SESION

    static function full_host()
    {
        $s = $_SERVER;
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = self::class . substr($sp, 0, strpos($sp, '/'));
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = (isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : isset($s['HTTP_HOST'])) ? $s['HTTP_HOST'] : $s['SERVER_NAME'];
        return $protocol . '://' . $host . $port;
    }

    /*public static function rutaLogin()
    {
        return Constantes::full_host() . "/laminas-tecnologias/login";
    }


    public static function rutaMailer()
    {
        return Constantes::full_host() . "/laminas-tecnologias/mailer";
    }
*/

}
