<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @mixin Product
 */
class ProductDebugResource extends JsonResource
{
//    public $additional=[
//        'author' => 'Daud Hidayat Ramadhan',
//    ];
    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data'=>[
                'id' => $this->id,
                'category_id' => $this->category_id,
                'category' => new CategorySimpleResource($this->category),
                'name' => $this->name,
                'price' => $this->price,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'author' => 'Daud Hidayat Ramadhan',
            'server_time' => now()->toDateTimeString(),
        ];
    }
}
