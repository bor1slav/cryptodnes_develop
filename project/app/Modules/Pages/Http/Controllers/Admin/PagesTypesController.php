<?php

namespace App\Modules\Pages\Http\Controllers\Admin;

use App\Modules\Pages\Forms\PageTypeForm;
use App\Modules\Pages\Http\Requests\StorePagesTypeRequest;
use App\Modules\Pages\Models\PagesType;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class PagesTypesController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return Response
     */
    public function index(DataTables $datatable)
    {
        $columns = [
            'id' => ['title' => trans('pages::admin.id')],
            'title' => ['title' => trans('pages::admin.title')],
            'created_at' => ['title' => trans('pages::admin.created_at')],
            'action' => ['title' => trans('pages::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(PagesType::withTrashed()->orderBy('created_at', 'DESC'));
        $table->columns($columns);
        $table->addColumn('action', function ($type) {
            $action = AdministrationField::edit(Administration::route('pages_types.edit', $type->id));

            if (empty($type->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('pages_types.destroy', $type->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('pages_types.destroy', $type->id));
            }

            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {

            if ($request->has('search')) {
                $query->where('title', 'LIKE', '%' . $request->search["value"] . '%');
            }
        });
        $table->rawColumns(['action']);


        Administration::setTitle(trans('pages::admin.module_types_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('pages::admin.module_types_name'));
        });

        return $table->generate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = new AdministrationForm();
        $form->route(Administration::route('pages_types.store'));
        $form->form(PageTypeForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('pages::admin.module_types_name'), Administration::route('pages_types.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('pages_types.create'));
        });

        Administration::setTitle(trans('pages::admin.module_types_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePagesTypeRequest $request
     * @return Response
     */
    public function store(StorePagesTypeRequest $request)
    {
        $type = new PagesType();
        $type->fill($request->validated());
        $type->save();

        return redirect(Administration::route('pages_types.index'))->withSuccess([trans('administration::admin.success_create')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $type = PagesType::withTrashed()->where('id', $id)->first();

        if (empty($type)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('pages_types.update', $type->id));
        $form->form(PageTypeForm::class);
        $form->model($type);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('pages::admin.module_types_name'), Administration::route('pages_types.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('pages::admin.page') . ' - ' . trans('administration::admin.edit') . ' #' . $type->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePagesTypeRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StorePagesTypeRequest $request, $id)
    {
        $type = PagesType::withTrashed()->where('id', $id)->first();

        if (empty($type)) {
            abort(404);
        }

        $type->fill($request->validated());
        $type->save();

        return redirect(Administration::route('pages_types.index'))->withSuccess([trans('administration::admin.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $type = PagesType::withTrashed()->where('id', $id)->first();

        if (!empty($type->deleted_at)) {
            $type->restore();
        } else {
            $type->delete();
        }

        return response()->json();
    }
}
