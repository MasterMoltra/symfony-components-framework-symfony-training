<?php

namespace App\Simplex;

// use App\Simplex\Events\ResponseEvent;
// use Symfony\Component\EventDispatcher\EventDispatcherInterface;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
// use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
// use Symfony\Component\HttpKernel\HttpKernelInterface;
// use Symfony\Component\Routing\Exception\ResourceNotFoundException;
// use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpKernel\HttpKernel;

class Framework extends HttpKernel
{
    // private $matcher;
    // private $controllerResolver;
    // private $argumentResolver;
    // private $dispatcher;

    // public function __construct(
    //     UrlMatcherInterface $matcher,
    //     ControllerResolverInterface $controllerResolver,
    //     ArgumentResolverInterface $argumentResolver,
    //     EventDispatcherInterface $dispatcher
    // ) {
    //     $this->matcher = $matcher;
    //     $this->controllerResolver = $controllerResolver;
    //     $this->argumentResolver = $argumentResolver;
    //     $this->dispatcher = $dispatcher;
    // }

    // public function handle(
    //     Request $request,
    //     $type = HttpKernelInterface::MASTER_REQUEST,
    //     $catch = true
    // ) {
    //     $this->matcher->getContext()->fromRequest($request);

    //     try {
    //         $request->attributes->add($this->matcher->match($request->getPathInfo()));

    //         $controller = $this->controllerResolver->getController($request);
    //         $arguments = $this->argumentResolver->getArguments($request, $controller);

    //         $response = call_user_func_array($controller, $arguments);
    //         // $response = call_user_func($request->attributes->get('_controller'), $request);
    //     } catch (ResourceNotFoundException $exception) {
    //         $response = new Response('Not Found', 404);
    //     } catch (\Exception $exception) {
    //         $response = new Response('An error occurred -> ' . $exception->getMessage(), 500);
    //     }

    //     // dispatch a response event
    //     $this->dispatcher->dispatch(
    //         new ResponseEvent($response, $request),
    //         'response'
    //     );

    //     return $response;
    // }
}
