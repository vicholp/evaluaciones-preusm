<?php

namespace App\Http\Resources;

use App\Models\StatementPrototype;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin StatementPrototype
 */
class StatementPrototypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) // @phpstan-ignore-line
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'body' => $this->body,
            'questions' => QuestionPrototypeResource::collection($this->whenLoaded('questions'))->keyBy('id') // @phpstan-ignore-line
        ];
    }
}
