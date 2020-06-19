<?php

namespace Tests\Simplex;

use App\Calendar\Controller\LeapYearController;
use App\Simplex\Framework;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \Framework
 *
 * @internal
 */
class FrameworkTest extends TestCase
{
    public function testNotFoundHandling(): void
    {
        $framework = $this->getFrameworkForException(new Exception\ResourceNotFoundException());

        $response = $framework->handle(new Request());

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testErrorHandling()
    {
        $framework = $this->getFrameworkForException(new \RuntimeException());

        $response = $framework->handle(new Request());

        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testControllerResponse()
    {
        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();
        /** @var \PHPUnit\Framework\MockObject\MockObject|Routing\Matcher\UrlMatcherInterface */
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);
        /** @var \PHPUnit\Framework\MockObject\MockObject|EventDispatcherInterface */
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        // use getMock() on PHPUnit 5.3 or below
        // $matcher = $this->getMock(Routing\Matcher\UrlMatcherInterface::class);

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

        $framework = new Framework($matcher, $controllerResolver, $argumentResolver, $dispatcher);

        $response = $framework->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Yep, this is a leap year!', $response->getContent());
    }

    private function getFrameworkForException(\Exception $exception): Framework
    {
        /** @var ControllerResolverInterface|\PHPUnit\Framework\MockObject\MockObject */
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        /** @var ArgumentResolverInterface|\PHPUnit\Framework\MockObject\MockObject */
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);
        /** @var \PHPUnit\Framework\MockObject\MockObject|Routing\Matcher\UrlMatcherInterface */
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);
        /** @var \PHPUnit\Framework\MockObject\MockObject|EventDispatcherInterface */
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        // use getMock() on PHPUnit 5.3 or below
        // $matcher = $this->getMock(Routing\Matcher\UrlMatcherInterface::class);

        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->throwException($exception));
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(Routing\RequestContext::class)));

        return new Framework($matcher, $controllerResolver, $argumentResolver, $dispatcher);
    }
}
