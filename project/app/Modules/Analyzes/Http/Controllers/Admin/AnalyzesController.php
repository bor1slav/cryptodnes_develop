<?php

namespace App\Modules\Analyzes\Http\Controllers\Admin;

use App\Modules\Analyzes\Forms\AnalyzeForm;
use App\Modules\Analyzes\Forms\PageForm;
use App\Modules\Analyzes\Http\Requests\StoreAnalyzeRequest;
use App\Modules\Analyzes\Models\Analyze;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AnalyzesController extends BaseAdministrationController
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
            'category' => ['title' => trans('analyzes::admin.category')],
            'visible' => ['title' => trans('analyzes::admin.visible')],
//            'is_popular' => ['title' => trans('analyzes::admin.is_popular')],
            'created_at' => ['title' => trans('analyzes::admin.created_at')],
            'action' => ['title' => trans('analyzes::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(Analyze::withTrashed()->with(['category'])->reversed());
        $table->columns($columns);
        $table->addColumn('category', function ($analyze) {
            return $analyze->category->title;
        });
        $table->addColumn('visible', function ($analyze) {
            return AdministrationField::switch('visible', $analyze);
        });
        $table->addColumn('is_popular', function ($article) {
            return AdministrationField::switch('is_popular', $article);
        });
        $table->addColumn('action', function ($analyze) {
            $action = AdministrationField::edit(Administration::route('analyzes.edit', $analyze->id));
//            $action .= AdministrationField::media($analyze);

            if (empty($analyze->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('analyzes.destroy', $analyze->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('analyzes.destroy', $analyze->id));
            }

            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {

            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });
                $query->orWhereHas('category', function ($cat_q) use ($request) {
                    $cat_q->whereHas('translations', function ($cat_trans_q) use ($request) {
                        $cat_trans_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                    });
                });
            }
        });
        $table->rawColumns(['visible', 'is_popular', 'action']);


        Administration::setTitle(trans('analyzes::admin.module_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('analyzes::admin.module_name'));
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
        $form->route(Administration::route('analyzes.store'));
        $form->form(AnalyzeForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('analyzes::admin.module_name'), Administration::route('analyzes.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('analyzes.create'));
        });

        Administration::setTitle(trans('analyzes::admin.module_name') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnalyzeRequest $request
     * @return Response
     */
    public function store(StoreAnalyzeRequest $request)
    {
        $analyze = new Analyze();
        $analyze->fill($request->validated());
        $analyze->save();

        if  (!empty($request->file)) {
            //delete all previous media
            $old_media = $analyze->getMedia();
            foreach ($old_media as $image) {
                $image->delete();
            }
            $analyze->addMedia($request->file)->toMediaCollection();
        }

        return redirect(Administration::route('analyzes.index'))->withSuccess([trans('administration::admin.success_create')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $analyze = Analyze::withTrashed()->where('id', $id)->first();

        if (empty($analyze)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('analyzes.update', $analyze->id));
        $form->form(AnalyzeForm::class);
        $form->model($analyze);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('analyzes::admin.module_name'), Administration::route('analyzes.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('analyzes::admin.article') . ' - ' . trans('administration::admin.edit') . ' #' . $analyze->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreAnalyzeRequest $request
     * @param int $id
     * @return Response
     */
    public function update(StoreAnalyzeRequest $request, $id)
    {
        $analyze = Analyze::withTrashed()->where('id', $id)->first();

        if (empty($analyze)) {
            abort(404);
        }

        $analyze->fill($request->validated());
        $analyze->save();

        if  (!empty($request->file)) {
            //delete all previous media
            $old_media = $analyze->getMedia();
            foreach ($old_media as $image) {
                $image->delete();
            }

            $analyze->addMedia($request->file)->toMediaCollection();
        }

        return redirect(Administration::route('analyzes.index'))->withSuccess([trans('administration::admin.success_update')]);
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
        $analyze = Analyze::withTrashed()->where('id', $id)->first();

        if (!empty($analyze->deleted_at)) {
            $analyze->restore();
        } else {
            $analyze->delete();
        }

        return response()->json();
    }
}
