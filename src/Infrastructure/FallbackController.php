<?php

namespace App\Infrastructure;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class FallbackController extends Controller
{
    public function fallback(Request $request): JsonResponse
    {
        return new JsonResponse(["error"=>"iot_emulator does not understand this request, please check route, http verb or payloads"], 400);
    }
}
