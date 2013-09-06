<?php

namespace spec\PhproSmartCrud\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;

class ParametersServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('PhproSmartCrud\Service\ParametersService');
    }

    public function it_should_implement_factoryInterface()
    {
        $this->shouldBeAnInstanceOf('\Zend\ServiceManager\FactoryInterface');
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\StdLib\RequestInterface $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    protected function mockServiceLocator($serviceLocator, $request, $controller, $params)
    {
        $prophet = new Prophet();
        $app = $prophet->prophesize('\Zend\Mvc\Application');
        $event = $prophet->prophesize('\Zend\Mvc\MvcEvent');

        if ($controller) {
            $controller->plugin('params')->willReturn($params->getWrappedObject());
            $controller = $controller->getWrappedObject();
        }

        $event->getController()->willReturn($controller);
        $event->getRequest()->willReturn($request->getWrappedObject());
        $app->getMvcEvent()->willReturn($event);
        $serviceLocator->get('application')->willReturn($app);
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_return_params_plugin($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator)->shouldReturn($this);
        $controller->plugin('params')->shouldBeCalled();

    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\StdLib\RequestInterface $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_return_null_on_invalid_request($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator)->shouldReturn($this);
        $controller->plugin('params')->shouldNotBeCalled();
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     */
    public function it_should_return_null_on_invalid_controller($serviceLocator, $request, $controller)
    {
        $this->mockServiceLocator($serviceLocator, $request, null, null);
        $this->createService($serviceLocator)->shouldReturn($this);

        // Todo: add controller to mock method --> find a valid interface to use
        $controller->plugin('params')->shouldNotBeCalled();
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_load_file_data_from_plugin($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator);

        $this->fromFiles('key', 'default');
        $params->fromFiles('key', 'default')->shouldBeCalled();
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_load_header_data_from_plugin($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator);

        $this->fromHeader('key', 'default');
        $params->fromHeader('key', 'default')->shouldBeCalled();
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_load_post_data_from_plugin($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator);

        $this->fromPost('key', 'default');
        $params->fromPost('key', 'default')->shouldBeCalled();
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_load_query_data_from_plugin($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator);

        $this->fromQuery('key', 'default');
        $params->fromQuery('key', 'default')->shouldBeCalled();
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param \Zend\Http\Request $request
     * @param \PhproSmartCrud\Controller\CrudController $controller
     * @param \Zend\Mvc\Controller\Plugin\Params $params
     */
    public function it_should_load_route_data_from_plugin($serviceLocator, $request, $controller, $params)
    {
        $this->mockServiceLocator($serviceLocator, $request, $controller, $params);
        $this->createService($serviceLocator);

        $this->fromRoute('key', 'default');
        $params->fromRoute('key', 'default')->shouldBeCalled();
    }

}