<?php

namespace Charlotte\Administration\Http\Controllers;


use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Http\Requests\AjaxQuickDeleteFileRequest;
use Charlotte\Administration\Http\Requests\AjaxQuickMediaSort;
use Charlotte\Administration\Http\Requests\AjaxQuickReorder;
use Charlotte\Administration\Http\Requests\AjaxQuickSwitchRequest;
use Charlotte\Administration\Http\Requests\AjaxQuickUploadFile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class AjaxController {

    public function changeColor(Request $request) {
        $admin = Administration::getLoggedAdmin();
        $admin->dark_theme = filter_var($request->get('theme'), FILTER_VALIDATE_BOOLEAN);
        $admin->save();

        return response()->json(['success' => true]);
    }

    public function saveQuickSwitch(AjaxQuickSwitchRequest $request) {
        $object = new $request->class;

        if (in_array(SoftDeletes::class, class_uses($object))) {
            $object = $object->withTrashed();
        }
        $object = $object->where('id', $request->id)->first();

        $object->update([
            $request->field => $request->state,
        ]);

        return response()->json();
    }

    public function quickUploadFile(AjaxQuickUploadFile $request) {
        $object = new $request->class;

        if (in_array(SoftDeletes::class, class_uses($object))) {
            $object = $object->withTrashed();
        }

        $object = $object->where('id', $request->id)->first();

        $media = $object->addMedia($request->file)->toMediaCollection($request->collection);

        return response()->json(['id' => $media->id]);
    }

    public function quickDeleteFile(AjaxQuickDeleteFileRequest $request) {
        $media = Media::where('id', $request->id)->first();

        if (!empty($media)) {
            $media->delete();
        }

        return response()->json(['id' => $request->id]);

    }

    public function quickReorder(AjaxQuickReorder $request) {
        $object = new $request->class();
        $ids = $request->position_ids;
        $ids_collection = collect($request->position_ids)->filter();

        if (in_array(SoftDeletes::class, class_uses($object))) {
            $object = $object->withTrashed();
        }

        $models = $object->whereIn('id', array_keys(array_filter($ids)))->get();
        $positions_static = [];

        foreach ($models as $model) {
            $positions_static[$model->id] = [
                '_lft' => $model->_lft,
                '_rgt' => $model->_rgt,
            ];
        }

        foreach ($ids_collection as $new_data) {

            $old_data = $ids_collection->filter(function($array) use ($new_data){
                return $array['old_position'] == $new_data['new_position'];
            })->first();
            //TODO check if result is present if not exception


            //TODO check if found if not exception
            $current_model = $models->firstWhere('id', $new_data['id']);



            $current_model->_lft = $positions_static[$old_data['id']]['_lft'];
            $current_model->_rgt = $positions_static[$old_data['id']]['_rgt'];
            $current_model->save();

        }
        $object::fixTree();
    }

    public function quickMediaSort(AjaxQuickMediaSort $request) {
        $media_ids = $request->ids;

        Media::setNewOrder($media_ids);
    }
}