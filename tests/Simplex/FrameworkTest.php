<?php

namespace Tests\Simplex;

use App\Calendar\Controller\LeapYearController;
use App\Simplex\Controller\BaseController;
use App\Simplex\Framework;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\EventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @covers \Framework
 *
 * @internal
 */
class FrameworkTest extends TestCase
{

    public function exceptionDataProvider(): \Generator
    {
        yield 'NotFoundHttpException' => [
            [NotFoundHttpException::class, '404']
        ];
        yield 'BadRequestHttpException' => [
            [BadRequestHttpException::class, '400']
        ];
        yield 'RuntimeException' => [
            [\RuntimeException::class, '500']
        ];
    }

    /**
     * @test
     * @testdox Test list of exceptions
     * @dataProvider exceptionDataProvider
     */
    public function testErrorHandling(array $exception): void
    {
        // $exception = BadRequestHttpException::class;
        // $this->expectException($exception);
        [$class, $statusCode] = $exception;
        $framework = $this->getFrameworkForException($class);
        $response = $framework->handle(new Request());

        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertStringContainsString('My custom test message', $response->getContent());
    }

    /**
     * @test
     * @testdox Test simple corrrect response with 200 status code
     */
    public function testControllerResponse(): void
    {
        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        // $matcher = new Routing\Matcher\UrlMatcher($this->getRoutes(), new Routing\RequestContext());
        /** @var \PHPUnit\Framework\MockObject\MockObject|Routing\Matcher\UrlMatcherInterface */
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);
        $dispatcher = new EventDispatcher();
        $requestStack = new RequestStack();


        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->returnValue([
                '_route' => 'is_leap_year/{year}',
                'year' => '2020',
                '_controller' => [new LeapYearController(), 'index'],
            ]));
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(Routing\RequestContext::class)));

        $dispatcher->addSubscriber(new EventListener\ResponseListener('UTF-8'));
        $dispatcher->addSubscriber(new EventListener\RouterListener($matcher, $requestStack));

        $framework = new Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);

        $response = $framework->handle(new Request()); // Request::create('/islpyear/2020')

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Yep, this is a leap year!', $response->getContent());
    }

    /**
     * Simulate response with some exceptions
     *
     * @param string $exception
     *
     * @return \App\Simplex\Framework
     */
    private function getFrameworkForException(string $exception): Framework
    {
        // /** @var ControllerResolverInterface|\PHPUnit\Framework\MockObject\MockObject */
        // $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $controllerResolver = new ControllerResolver();
        // /** @var ArgumentResolverInterface|\PHPUnit\Framework\MockObject\MockObject */
        // $argumentResolver = $this->createMock(ArgumentResolverInterface::class);
        $argumentResolver = new ArgumentResolver();
        // /** @var \PHPUnit\Framework\MockObject\MockObject|EventDispatcherInterface */
        // $dispatcher = $this->createMock(EventDispatcherInterface::class);
        /** @var \PHPUnit\Framework\MockObject\MockObject|Routing\Matcher\UrlMatcherInterface */
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);
        $dispatcher = new EventDispatcher();
        $requestStack = new RequestStack();

        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->returnValue([
                '_route' => 'hello',
                '_controller' => [new BaseController(), 'render'],
            ]));
        // ->will($this->throwException(new $exception));
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(Routing\RequestContext::class)));

        $dispatcher->addSubscriber(new EventListener\RouterListener($matcher, $requestStack));
        // Throw custom exception
        $dispatcher->addListener('kernel.controller', function (ControllerEvent $event) use ($exception) {
            // var_dump("Controller event");
            throw new $exception("My custom test message");
        });
        // Simulate http response with my custom the exception info
        $dispatcher->addListener('kernel.exception', function (ExceptionEvent $event) {
            // var_dump("Exeception event")
            // I can set here if I throw the exception from the matcher above
            // $event->setThrowable(new $exception("My custom test message"));
            $exception = $event->getThrowable();

            // create json response and set the nice message from exception
            $customResponse = new JsonResponse(
                [
                    'status' => false,
                    'message' => $exception->getMessage()
                ],
                method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500
            );
            // set it as response and it will be sent
            $event->setResponse($customResponse);
        });

        return new Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
    }

    /**
     * Return a real roting collection list
     *
     * @return Routing\RouteCollection
     */
    private function getRoutes(): Routing\RouteCollection
    {
        return include __DIR__ . '/../../src/routing.php';
    }
}
