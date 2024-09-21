<?php

namespace App\Http\Controllers\crimeguardm;

use App\Http\Controllers\Controller;
use App\Models\IncidentCategories;
use App\Models\IncidentSubTypes;
use App\Models\IncidentTypes;
use App\Models\TrailLog;
use DateTime;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class incidentNamesModule extends Controller
{
    //table display
    public function tableDisplay(Request $request)
    {
        $data = [];
    
        try {
            /* Table headers */
            $data['table']['headers'] = [
                'id',
                'incident type',
                'incident sub types',
                'incident category',
            ];
    
            $query = IncidentTypes::leftJoin('incident-sub-types', 'incident-types.sub_type_id', '=', 'incident-sub-types.id')
                ->leftJoin('incident-categories', 'incident-types.category_id', '=', 'incident-categories.id')
                ->select([
                    'incident-types.id',
                    'incident-types.incident_name',
                    'incident-sub-types.sub_type',
                    'incident-categories.category_name'
                ])
                ->whereNull('incident-types.archived_at')
                ->whereNull('incident-types.deleted_by');
    
            /* seach */
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('incident-types.id', 'like', "%{$search}%")
                        ->orWhere('incident-types.incident_name', 'like', "%{$search}%")
                        ->orWhere('incident-sub-types.sub_type', 'like', "%{$search}%")
                        ->orWhere('incident-categories.category_name', 'like', "%{$search}%");
                });
            }
    
            $data['table']['data'] = $query->get();
            $data['table']['type'] = 1;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }
    
        return response()->json($data);
    }
    

    public function search(Request $request)
    {
        $data = [];
    
        try {
    
            $query = IncidentTypes::leftJoin('incident-sub-types', 'incident-types.sub_type_id', '=', 'incident-sub-types.id')
                ->leftJoin('incident-categories', 'incident-types.category_id', '=', 'incident-categories.id')
                ->select([
                    'incident-types.id',
                    'incident-types.incident_name',
                    'incident-sub-types.sub_type'
                ])
                ->whereNull('incident-types.archived_at')
                ->whereNull('incident-types.deleted_by');
    
            /* seach */
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->orWhere('incident-types.id', 'like', "%{$search}%")
                        ->orWhere('incident-types.incident_name', 'like', "%{$search}%")
                        ->orWhere('incident-sub-types.sub_type', 'like', "%{$search}%")
                        ->orWhere('incident-categories.category_name', 'like', "%{$search}%");
                });
            }
    
            $data['data'] = $query->get();
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
        }
    
        return response()->json($data);
    }
    

    public function archive(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        $currentDate = new DateTime();
        $data = [];

        try {

            $archive = [
                'archived_at' => $currentDate->format('Y-m-d H:i:s'),
                'deleted_by' => $request['archived_by']
            ];
            IncidentTypes::where('id', $request['id'])->update($archive);
            
            TrailLog::create(['user_id'=> $request->input('deleted_by'), 'action' => 'deleted', 'item' => 'incident type']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {

            $data['response'] = 'Error';
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    /* use to add incidents */
    public function addIncidentName(Request $request)
    {
        $data = [];
         /*        $request = [
            'incident_name' => 'Theft',
            'category' => 'Unkown',
            'sub_type' => 'Very',
            'edited_by' => 2,
            'added_by' => 2,
        ]; */

        $sub_id = $this->subTypeId($request['sub_type']);
        $cat_id = $this->categoryId($request['category']);

        $incType = [
            'incident_name' => $request['incident_name'],
            'edited_by' => $request['edited_by'],
            'added_by' => $request['added_by'],
        ];
        try {
            if ($sub_id == -1 && (trim($request['sub_type']) != '')) {
                $this->insertSubType([
                    'sub_type' => $request['sub_type'],
                    'edited_by' => $request['edited_by'],
                    'added_by' => $request['added_by']
                ]);
                $incType['sub_type_id'] = $this->subTypeId($request['sub_type']);
            }
            if ($cat_id == -1 && (trim($request['category']) != '')) {
                $this->insertCategory([
                    'category_name' => $request['category'],
                    'edited_by' => $request['edited_by'],
                    'added_by' => $request['added_by']
                ]);
                $cat_id = $this->categoryId($request['category']);
            }
            $incType['category_id'] = $cat_id;

            IncidentTypes::create($incType);


            TrailLog::create(['user_id'=> $request->input('added_by'), 'action' => 'added', 'item' => 'incident type']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = "Error";
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    

    public function editDisplayData(Request $request)
    {
        $data = [];
        try {
            $incidentName = IncidentTypes::leftJoin('incident-sub-types', 'incident-types.sub_type_id', '=', 'incident-sub-types.id')
            ->leftJoin('incident-categories', 'incident-types.category_id', '=', 'incident-categories.id')
            ->select([
                'incident-types.incident_name',
                'incident-sub-types.sub_type',
                'incident-categories.category_name'
            ])->where('incident-types.id', $request['id'])->first();

            
            $data['data']['incidentName'] = $incidentName;
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = 'Error';
            $data['Err'] = $e;
        }
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = [];

        $sub_id = $this->subTypeId($request['sub_type']);
        $cat_id = $this->categoryId($request['category']);

        $incType = [
            'incident_name' => $request['incident_name'],
            'edited_by' => $request['edited_by'],
        ];
        try {
            if ($sub_id == -1 && (trim($request['sub_type']) != '')) {
                $this->insertSubType([
                    'sub_type' => $request['sub_type'],
                    'edited_by' => $request['edited_by'],
                    'added_by' => $request['added_by']
                ]);
                $incType['sub_type_id'] = $this->subTypeId($request['sub_type']);
            }
            if ($cat_id == -1 && (trim($request['category']) != '')) {
                $this->insertCategory([
                    'category_name' => $request['category'],
                    'edited_by' => $request['edited_by'],
                    'added_by' => $request['added_by']
                ]);
                $cat_id = $this->categoryId($request['category']);
            }
            $incType['category_id'] = $cat_id;

            IncidentTypes::find($request['id'])->update($incType);


            TrailLog::create(['user_id'=> $request->input('edited_by'), 'action' => 'edited', 'item' => 'incident type']);
            $data['response'] = 'Success';
        } catch (\Exception $e) {
            $data['response'] = "Error";
            $data['err'] = $e;
        }
        return response()->json($data);
    }

    private function insertSubType($param)
    {
        IncidentSubTypes::create($param);
    }

    private function insertCategory($param)
    {
        IncidentCategories::create($param);
    }

    private function subTypeId($param)
    {
        try {
            return IncidentSubTypes::where('sub_type', $param)->select('id')->first()['id'];
        } catch (\Exception $e) {
            return -1;
        }
    }

    private function isObjNull($param)
    {
        $indicator = FALSE;
        foreach ($param as $key => $value) {
            if ($value != NULL || $value != '') {
                $indicator = TRUE;
                break;
            }
        }
        return $indicator;
    }
    private function categoryId($param)
    {
        try {
            return IncidentCategories::where('category_name', $param)->select('id')->first()['id'];
        } catch (\Exception $e) {
            return -1;
        }
    }
}
