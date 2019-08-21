<?php

namespace App\Modules\Analyzes\Http\Controllers\Admin;

use App\Modules\Analyzes\Forms\AnalyzeCategoryForm;
use App\Modules\Analyzes\Http\Requests\StoreAnalyzeCategoryRequest;
use App\Modules\Analyzes\Models\AnalyzeCategory;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AnalyzesCategoriesController extends BaseAdministrationController
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
            'id' => ['title' => trans('analyzes::admin.id')],
            'title' => ['title' => trans('analyzes::admin.title')],
            'coin' => ['title' => trans('analyzes::admin.coin')],
            'visible' => ['title' => trans('analyzes::admin.visible')],
            'created_at' => ['title' => trans('analyzes::admin.created_at')],
            'action' => ['title' => trans('analyzes::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(AnalyzeCategory::withTrashed()->with(['coin'])->reversed());
        $table->columns($columns);
        $table->addColumn('coin', function ($category) {
            if (!empty($category->coin)) {
            return $category->coin->title;
            }

            return 'none';
        });
        $table->addColumn('visible', function ($category) {
            return AdministrationField::switch('visible', $category);
        });
        $table->addColumn('action', function ($category) {
            $action = AdministrationField::edit(Administration::route('analyzes_categories.edit', $category->id));

            if (empty($category->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('analyzes_categories.destroy', $category->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('analyzes_categories.destroy', $category->id));
            }

            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {

            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });
                $query->orWhereHas('coin', function ($cat_q) use ($request) {
                    $cat_q->whereHas('translations', function ($cat_trans_q) use ($request) {
                        $cat_trans_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                    });
                });
            }
        });
        $table->rawColumns(['visible', 'action']);


        Administration::setTitle(trans('analyzes::admin.module_categories_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('analyzes::admin.module_categories_name'));
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
        $form->route(Administration::route('analyzes_categories.store'));
        $form->form(AnalyzeCategoryForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('analyzes::admin.module_categories_name'), Administration::route('analyzes_categories.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('analyzes_categories.create'));
        });

        Administration::setTitle(trans('analyzes::admin.module_categories_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnalyzeCategoryRequest $request
     * @return Response
     */
    public function store(StoreAnalyzeCategoryRequest $request)
    {
        $category = new AnalyzeCategory();
        $category->fill($request->validated());
        $category->save();

        return redirect(Administration::route('analyzes_categories.index'))->withSuccess([trans('administration::admin.success_create')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $category = AnalyzeCategory::withTrashed()->where('id', $id)->first();

        if (empty($category)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('analyzes_categories.update', $category->id));
        $form->form(AnalyzeCategoryForm::class);
        $form->model($category);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('analyzes::admin.module_categories_name'), Administration::route('analyzes_categories.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('analyzes::admin.category') . ' - ' . trans('administration::admin.edit') . ' #' . $category->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreAnalyzeCategoryRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreAnalyzeCategoryRequest $request, $id)
    {
        $category = AnalyzeCategory::withTrashed()->where('id', $id)->first();

        if (empty($category)) {
            abort(404);
        }

        $category->fill($request->validated());
        $category->save();

        return redirect(Administration::route('analyzes_categories.index'))->withSuccess([trans('administration::admin.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = AnalyzeCategory::withTrashed()->where('id', $id)->first();

        if (!empty($category->deleted_at)) {
            $category->restore();
        } else {
            $category->delete();
        }

        return response()->json();
    }
}
