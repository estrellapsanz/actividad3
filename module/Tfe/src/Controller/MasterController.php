<?php

namespace Tfe\Controller;

use Laminas\Http\Request;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Tfe\Service\DAOServiceInterface;
use Tfe\Service\SessionServiceInterface;
use Tfe\Util\Constantes;

class MasterController extends AbstractActionController
{

    /** @var DAOServiceInterface $daoService */
    protected $daoService;

    /** @var SessionServiceInterface $sesion */
    protected $sesion;

    /**
     * @params DAOServiceInterface $daoService
     * @params SessionServiceInterface $sessionService
     */

    public function __construct(DAOServiceInterface $daoService, SessionServiceInterface $sessionService)
    {
        $this->daoService = $daoService;
        $this->sesion = $sessionService;

    }

    public function onDispatch(MvcEvent $e)
    {
        /** @var Request $request */
        return parent::onDispatch($e);
    }

    /**
     * @return void
     */
    protected function controlLogueado()
    {

        if (!$this->sesion->offsetExists(Constantes::SESION_NOMBRE_USUARIO))
            $this->redirect()->toRoute('desconectar');

    }


    /**
     * @param bool $exito
     * @return void
     *
     * protected function informarEstadoOperacionSesion(bool $exito): void
     * {
     * if ($exito)
     * $this->sesion->setEstadoOperacion(Constantes::ESTADO_OPERACION_OK);
     * else
     * $this->sesion->setEstadoOperacion(Constantes::ESTADO_OPERACION_ERROR);
     * }
     */
}
