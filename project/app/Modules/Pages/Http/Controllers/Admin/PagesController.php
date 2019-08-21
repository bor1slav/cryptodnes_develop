<?php

namespace App\Modules\Pages\Http\Controllers\Admin;

use App\Modules\Pages\Forms\PageForm;
use App\Modules\Pages\Http\Requests\StorePagesRequest;
use App\Modules\Pages\Models\Page;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class PagesController extends BaseAdministrationController
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
            'visible' => ['title' => trans('pages::admin.visible')],
            'created_at' => ['title' => trans('pages::admin.created_at')],
            'action' => ['title' => trans('pages::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(Page::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('visible', function ($page) {
            return AdministrationField::switch('visible', $page);
        });
        $table->addColumn('action', function ($page) {
            $action = AdministrationField::edit(Administration::route('pages.edit', $page->id));

            if (empty($page->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('pages.destroy', $page->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('pages.destroy', $page->id));
            }

            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {

            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });
            }
        });
        $table->rawColumns(['visible', 'action']);


        Administration::setTitle(trans('pages::admin.module_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('pages::admin.module_name'));
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
        $form->route(Administration::route('pages.store'));
        $form->form(PageForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('pages::admin.module_name'), Administration::route('pages.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('pages.create'));
        });

        Administration::setTitle(trans('pages::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePagesRequest $request
     * @return Response
     */
    public function store(StorePagesRequest $request)
    {
        $page = new Page();
        $page->fill($request->validated());
        $page->save();

        return redirect(Administration::route('pages.index'))->withSuccess([trans('administration::admin.success_create')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::withTrashed()->where('id', $id)->first();

        if (empty($page)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('pages.update', $page->id));
        $form->form(PageForm::class);
        $form->model($page);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('pages::admin.module_name'), Administration::route('pages.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('pages::admin.page') . ' - ' . trans('administration::admin.edit') . ' #' . $page->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePagesRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StorePagesRequest $request, $id)
    {
        $page = Page::withTrashed()->where('id', $id)->first();

        if (empty($page)) {
            abort(404);
        }

        $page->fill($request->validated());
        $page->save();

        return redirect(Administration::route('pages.index'))->withSuccess([trans('administration::admin.success_update')]);
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
        $page = Page::withTrashed()->where('id', $id)->first();

        if (!empty($page->deleted_at)) {
            $page->restore();
        } else {
            $page->delete();
        }

        return response()->json();
    }
}
