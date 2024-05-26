<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

/**
 * Class HandlerTest
 *
 * This class contains unit tests for the exception handler.
 */
class HandlerTest extends TestCase
{
    /**
     * Test that the handler renders a Not Found view for NotFoundHttpException.
     *
     * This test verifies that when a NotFoundHttpException is thrown,
     * the handler renders the 'NotFound' view and returns a 404 response status.
     */
    public function test_handler_renders_not_found_view_for_not_found_http_exception(): void
    {
        $request = new Request();
        $exception = new NotFoundHttpException();
        $handler = new Handler($this->app);

        Inertia::shouldReceive('render')->once()->with('NotFound');
        $response = $handler->render($request, $exception);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test that the handler renders the parent response for other exceptions.
     *
     * This test verifies that when a general exception is thrown,
     * the handler does not return a 404 response status and handles the exception as expected by the parent handler.
     */
    public function test_handler_renders_parent_for_other_exceptions(): void
    {
        $request = new Request();
        $exception = new Exception();
        $handler = new Handler($this->app);

        $response = $handler->render($request, $exception);

        $this->assertNotEquals(404, $response->getStatusCode());
    }
}
