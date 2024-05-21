<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class HandlerTest extends TestCase
{
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

    public function test_handler_renders_parent_for_other_exceptions(): void
    {
        $request = new Request();
        $exception = new Exception();
        $handler = new Handler($this->app);

        $response = $handler->render($request, $exception);

        $this->assertNotEquals(404, $response->getStatusCode());
    }
}
