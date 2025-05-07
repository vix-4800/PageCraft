<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\UserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

final class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        /** @var User $user */
        $user = $request->user();

        return UserAddressResource::collection($user->userAddresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddressRequest $userAddressRequest): JsonResource
    {
        /** @var User $user */
        $user = $userAddressRequest->user();
        $model = $user->userAddresses()->create($userAddressRequest->validated());

        return new UserAddressResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $userAddress): JsonResource
    {
        return new UserAddressResource($userAddress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAddressRequest $userAddressRequest, UserAddress $userAddress): JsonResource
    {
        $userAddress->update($userAddressRequest->validated());

        return new UserAddressResource($userAddress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $userAddress): Response
    {
        $userAddress->delete();

        return ApiResponse::empty();
    }
}
