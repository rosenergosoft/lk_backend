<?php

namespace App\Http\Controllers;

use App\Models\Disclosure;
use App\Models\DisclosureList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class DisclosureController extends Controller
{
    /**
     * @param $group
     * @param $type
     * @return JsonResponse
     */
    public function getByType($group, $type): JsonResponse
    {
        $disclosure = Disclosure::select(
            'disclosure.*',
            'disclosure_list.title',
            'disclosure_list.group',
            'disclosure_list.type',
            'disclosure_list.type_label',
        )
            ->rightJoin('disclosure_list', "disclosure_list.id", "disclosure.disclosure_label_id")
            ->where('disclosure_list.type', $type)->where('disclosure_list.group', $group)->first();
        if ($disclosure) {
            return response()->json([
                'disclosure' => $disclosure
            ]);
        }
        return response()->json([
            'message' => 'No disclosure found'
        ]);
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
}
