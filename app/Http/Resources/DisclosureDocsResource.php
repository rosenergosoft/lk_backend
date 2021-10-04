<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DisclosureDocsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'original_name' => $this->original_name,
            'id' => $this->id,
            'document_date' => Carbon::parse($this->document_date)->format('d.m.Y'),
            'file' => $this->file
        ];
    }
}
