<?php

namespace App\Http\Controllers;

use App\Http\Resources\DisclosureCollection;
use App\Models\Disclosure;
use App\Models\DisclosureDocs;
use App\Models\DisclosureList;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DisclosureController extends Controller
{
    /**
     * @param $group
     * @param $type
     * @return JsonResponse
     */
    public function getByType($group, $type): JsonResponse
    {
        $disclosureListItem = DisclosureList::with('disclosure')->where('type', $type)
            ->where('group', $group)
            ->first();
        if ($disclosureListItem) {
            if($disclosureListItem->disclosure)
            {
                $disclosure = $disclosureListItem->disclosure;
                if(isset($disclosure->docs)) {
                    $docs = $disclosureListItem->disclosure->docs;
                } else $docs = '';
            }
            else {
                $disclosure = '';
                $docs = '';
            }

            return response()->json([
                'disclosureListItem' => $disclosureListItem,
                'disclosure'    => $disclosure,
                'docs' => $docs
            ]);
        } else {
            return response()->json(['message' => 'Something went wrong']);
        }
    }

    /**
     * @param $group
     * @return JsonResponse
     */
    public function getList($group, $type = false): JsonResponse
    {
        $list = DisclosureList::select('disclosure_list.*', 'disclosure.is_processed', 'disclosure.is_show')
            ->where("disclosure_list.group", $group)
            ->leftJoin("disclosure", function($join) {
                $join->on('disclosure.disclosure_label_id', '=', 'disclosure_list.id');
                $join->on('disclosure.client_id', DB::raw(auth()->user()->client_id));
            })
            ->orderBy('disclosure_list.type_label')->get();

        if ($list) {
            return response()->json([
                'disclosures' => $list
            ]);
        }
        return response()->json([
            'message' => 'No disclosures in this group'
        ]);
    }

    public function getPublicList($clientId, $type = 0): JsonResponse
    {
        $disclosureCollection = Disclosure::with(['docs', 'disclosureList' => function($query) use ($type) {
            $query->where('type', $type);
        }])->where('client_id', $clientId)->where('is_show',1);
        $disclosureCollection->get();
        $list = new DisclosureCollection($disclosureCollection);

        $sorted = $list->sortBy(function ($order) {
            return $order->disclosureList->type_label;
        });

        $list = $sorted->values()->all();

        if ($list) {
            return response()->json([
                'success' => true,
                'disclosures' => $list
            ]);
        }
        return response()->json([
            'message' => 'No disclosures in this group'
        ]);
    }

    /**
     * @param null $disclosureId
     * @param null $disclosureLabelId
     * @return JsonResponse
     */
    public function fileUpload (Request $Request): JsonResponse
    {
        if ($Request->file()){
            foreach ($Request->file() as $type => $file) {
                $path_parts = pathinfo($file->getClientOriginalName());
                $document = new DisclosureDocs();
                $filename = Str::random(40).'.'.$path_parts['extension'];
                $filePath = $file->storeAs('uploads', $filename,'public');
                $document->file = $filePath;
                $document->original_name = $file->getClientOriginalName();
                if(Request()->get('document_date')) $document->document_date = Carbon::parse(Request()->get('document_date'), 'GMT')->toDateTimeString();
                else $document->document_date = '';
                $document->name = Request()->get('name') ?? '';
                if($Request->get('disclosure_id')) {
                    $disclosureId = $Request->get('disclosure_id');
                }
                if (isset($disclosureId)) {
                    $document->disclosure_id = $disclosureId;
                    $disclosure = Disclosure::find($disclosureId);
                } else {
                    if($disclosureLabelId = $Request->get('disclosure_label_id')) {
                        $disclosure = new Disclosure();
                        $disclosure->is_processed = 0;
                        $disclosure->is_show = 0;
                        $disclosure->group_by = 0;
                        $disclosure->content = '';
                        $disclosure->client_id = auth()->user()->client_id;
                        $disclosure->disclosure_label_id = $disclosureLabelId;
                        $disclosure->save();
                        $disclosureId = $disclosure->id;
                        $document->disclosure_id = $disclosureId;
                    } else {
                        return response()->json(['success' => false, 'message' => 'Error']);
                    }
                }
                $document->save();
            }
            return response()->json([
                'success' => true,
                'docs' => $disclosure->docs,
                'disclosure' => $disclosure
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request) {
        $data = $request->all();
        $disclosure = Disclosure::updateOrCreate(
            ['id' => @$data['disclosure_id']],
            [
                'content' => $data['content'] ?? '',
                'disclosure_label_id' => $data['disclosure_label_id'],
                'is_processed' => intval($data['is_processed']),
                'is_show' => intval($data['is_show']),
                'group_by' => intval($data['group_by']),
                'client_id' => auth()->user()->client_id,
            ]
        );
        if(isset($data['docs'])) {
            $disclosure->docs()->delete();
            foreach ($data['docs'] as $doc) {
                unset($doc['created_at']);
                unset($doc['updated_at']);
                if(!$doc['name']) $doc['name'] = '';
                if(!$doc['document_date']) $doc['document_date'] = '';
                $disclosure->docs()->insert($doc);
            }
        }
        if($disclosure) {
            return response()->json([
                'success' => true,
                'disclosure' => $disclosure
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Disclosure can\'t be saved']);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fileDelete(Request $request): JsonResponse
    {
        $doc = DisclosureDocs::find($request->get('doc_id'));
        if($doc->disclosure_id == $request->get('disclosure_id')) {
            $doc->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'You don\'t have enough permissions for this action']);
        }
    }
}
