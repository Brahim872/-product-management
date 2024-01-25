<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cookie;

class ProductResource extends JsonResource
{

    protected $invite, $token;


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "name" => $this->name,
            "size" => $this->size,
            "color" => $this->color,
            "description" => $this->description,
            "price" => $this->price,
            "category" => $this->category,
            "discount" => $this->discount,
        ];
    }
}
