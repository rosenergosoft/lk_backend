<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisclosureResource extends JsonResource
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
            'client_id' => $this->client_id,
            'content' => $this->content,
            'disclosure_label_id' => $this->disclosure_label_id,
            'disclosure_list' => $this->disclosureList,
            'docs' => DisclosureDocsResource::collection($this->docs),
            'id' => $this->id,
            'is_processed' => $this->is_processed,
            'is_show' => $this->is_show
        ];
    }
}
