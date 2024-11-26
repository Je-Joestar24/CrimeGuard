<?php

namespace App\Http\Controllers\CrimeGuardM\Dynamic;

use App\Http\Controllers\Controller;
use App\Models\OfficerCredential;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DynamicFunctions extends Controller
{

    public function upload(Request $request)
    {

        date_default_timezone_set('Asia/Manila');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = date('Y-m-d_H-i-s');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = $originalFilename . '_' . $timestamp . '.' . $extension;
            $path = 'public/files/' . $filename;

            // Store the file
            $file->storeAs('public/files', $filename);

            return response()->json(["response" => "Success", "file_path" => Storage::url($path)]);
        }
        return response()->json(["response" => "Error"]);
    }

    public function getUserStation($id)
    {
        date_default_timezone_set('Asia/Manila');


        $station = OfficerCredential::select('station')->where('user_id',  $id)->first();

        if (!$station) {
            return ['response' => false, 'message' => 'Station not found'];
        }

        return ['response' => true, 'station' => $station['station']];
    }

    public function getUserLevel($id)
    {
        $user =  User::select('user_level')->where('id', $id)->first();
        return $user ? $user['user_level'] : null;
    }

    /* use for pure foreign key */
    public function addByKeyValue($model, $k1, $k2, $v1, $v2)
    {
        $model::create([$k1 => $v1, $k2 => $v2]);
    }


    public function nulled($param)
    {
        foreach ($param as $key => $value) if ($value != null) return false;

        return true;
    }

    /* use to check if it really exists */
    public function doesItExists($param, $key)
    {
        try {
            $param[0][$key];
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    public function doestKeyExists($assoc, $key)
    {
        try {
            $assoc[$key];
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    /* add by key, use to extract array from array by its key */
    public function addByKey($param, $key)
    {
        $transferred = [];
        foreach ($param as $item) array_push($transferred, $item[$key]);
        return $transferred;
    }

    /* mass add item dynamically but only works on adding persons */
    public function massAddItem($model, $items)
    {
        $ids = [];
        foreach ($items as $item) {
            $itemId = $this->getId($model, $item);
            if ($itemId == -1) $itemId = $this->addItem($model, $item);

            if (($itemId != null && $itemId != -1) && !in_array($itemId, $ids)) array_push($ids, $itemId);
        }
        return $ids;
    }
    /* add item dynamic */
    public function addItem($model, $param)
    {
        try {
            $model::create($param);
            $id = $this->getId($model, $param);

            return $id;
        } catch (\Exception) {
            return null;
        }
    }
    /* get id dynamically */
    public function getId($model, $param)
    {
        try {
            $query = $model::query();

            foreach ($param as $key => $value) {
                if ($key != 'password') $query->where($key, $value);
            }

            $result = $query->select('id')->first();

            return $result ? $result->id : -1;
        } catch (\Exception $e) {
            return -1;
        }
    }

    public function insertBeforeKey($array, $newPairs, $key)
    {
        $newArray = [];
        foreach ($array as $k => $v) {
            if ($k === $key) {
                foreach ($newPairs as $nk => $nv) {
                    $newArray[$nk] = $nv;
                }
            }
            $newArray[$k] = $v;
        }
        return $newArray;
    }

    public function cleanInsertId($array)
    {
        $noID = [];
        $ids = [];
        foreach ($array as $item) {
            if ($this->doestKeyExists($item, 'id')) {
                array_push($ids, $item['id']);
            } else {
                array_push($noID, $item);
            }
        }
        $arr = ['no_id' => $noID, 'id' => $ids];
        return $arr;
    }

    public function deepCleanInsertId($array, $key)
    {
        $noID = [];
        $ids = [];
        foreach ($array as $item) {
            if ($this->doestKeyExists($item[$key], 'id')) {
                array_push($ids, $item[$key]['id']);
            } else {
                array_push($noID, $item);
            }
        }
        $arr = ['no_id' => $noID, 'id' => $ids];
        return $arr;
    }

    public function removeNuls($array, $key)
    {

        $arr = [];
        foreach ($array as $item) {
            if ($item[$key]) {
                array_push($arr, $item);
            }
        }
        return $arr;
    }

    public function convertArrayByKey($array, $key)
    {

        $arr = [];
        foreach ($array as $item) array_push($arr, $item[$key]);

        return $arr;
    }
}
