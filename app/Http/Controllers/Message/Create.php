<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class Create extends Controller
{
    public function __construct(private MessageService $service)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $inputs = $request->validate([
            'sender_uuid' => 'required|uuid|exists:users,uuid',
            'recipient_uuid' => 'required|uuid|exists:users,uuid',
            'message' => 'required|string'
        ]);

       $this->service->create(
            senderUuid: Uuid::fromString($inputs['sender_uuid']),
            recipientUuid: Uuid::fromString($inputs['recipient_uuid']),
            message: $inputs['message']
        );

        return response()->json(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
