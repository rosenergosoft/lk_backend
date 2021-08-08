<?php

namespace App\Http\Controllers;

use App\Models\Disclosure;
use App\Models\DisclosureDocs;
use App\Models\DisclosureList;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Object_;

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
    public function getList($group): JsonResponse
    {
        $list = DisclosureList::where("group", $group)->get();
        if ($list) {
            return response()->json([
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
                $documentDate = Carbon::parse(Request()->get('document_date'), 'GMT');
                $document->document_date = $documentDate->toDateTimeString();
                $document->name = Request()->get('name');
                if($Request->get('disclosure_id')) {
                    $disclosureId = $Request->get('disclosure_id');
                }
                if (isset($disclosureId)) {
                    $document->disclosure_id = $disclosureId;
                    $disclosure = new \StdClass;
                    $disclosure->id = $disclosureId;
                } else {
                    if($disclosureLabelId = $Request->get('disclosure_label_id')) {
                        $disclosure = new Disclosure();
                        $disclosure->is_processed = 0;
                        $disclosure->is_show = 0;
                        $disclosure->group_by = 0;
                        $disclosure->content = '';
                        $disclosure->user_id = auth()->user()->id;
                        $disclosure->disclosure_label_id = $disclosureLabelId;
                        $disclosure->save();
                        $disclosureId = $disclosure->id;
                        $document->disclosure_id = $disclosureId;
                    } else {
                        return response()->json(['success' => false, 'message' => 'Error']);
                    }
                }
                $document->save();
                $docs[] = $document;
            }
            return response()->json([
                'docs' => $docs,
                'disclosure' => $disclosure
            ]);
        }
        return response()->json(['success' => true]);
    }
}
