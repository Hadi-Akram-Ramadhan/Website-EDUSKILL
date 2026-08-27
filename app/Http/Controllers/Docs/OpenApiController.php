<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OpenApiController extends Controller
{
    /**
     * Render interactive Scalar OpenAPI 3.0 UI.
     */
    public function view(): View
    {
        return view('docs.index');
    }

    /**
     * Return the raw OpenAPI 3.0 YAML spec.
     */
    public function yaml(): Response
    {
        $path = resource_path('docs/openapi.yaml');
        if (!file_exists($path)) {
            abort(404, 'OpenAPI specification not found.');
        }

        $content = file_get_contents($path);

        return response($content, 200, [
            'Content-Type' => 'text/yaml; charset=UTF-8',
        ]);
    }
}
