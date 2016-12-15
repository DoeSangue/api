<?php

namespace App\Http\Controllers;

use App\Traits\QueryParameters;
use App\Traits\Responses;
use App\Transformers\Transform;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

abstract class APIController extends Controller
{
    use Responses, QueryParameters;

    /**
     * Transform.
     *
     * @var \App\Transformers\Transform
     */
    protected $transform;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var ResponseFactory
     */
    private $response;

    /**
     * APIController constructor.
     *
     * @param Request         $request
     * @param ResponseFactory $response
     * @param Transform       $transform
     */
    public function __construct(Request $request, ResponseFactory $response, Transform $transform)
    {
        $this->request = $request;
        $this->response = $response;
        $this->transform = $transform;
    }
}
