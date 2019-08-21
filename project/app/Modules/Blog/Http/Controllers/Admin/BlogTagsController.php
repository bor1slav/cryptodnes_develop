<?php

namespace App\Modules\Blog\Http\Controllers\Admin;

use App\Modules\Blog\Forms\BlogTagForm;
use App\Modules\Blog\Http\Requests\StoreTagRequest;
use App\Modules\Blog\Models\BlogTag;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class BlogTagsController extends BaseAdministrationController
{
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return \Illuminate\Http\Response
     */
    public function index(DataTables $datatable)
    {

        $columns = [
            'id' => ['title' => trans('blog::admin.id')],
            'title' => ['title' => trans('blog::admin.title')],
            'in_index' => ['title' => trans('blog::admin.in_index')],
            'visible' => ['title' => trans('blog::admin.visible')],
            'created_at' => ['title' => trans('blog::admin.created_at')],
            'action' => ['title' => trans('blog::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(BlogTag::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('in_index', function ($tag) {
            return AdministrationField::switch('in_index', $tag);
        });
        $table->addColumn('visible', function ($tag) {
            return AdministrationField::switch('visible', $tag);
        });
        $table->addColumn('action', function ($tag) {
            $action = AdministrationField::edit(Administration::route('blog_tags.edit', $tag->id));

            if (empty($tag->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('blog_tags.destroy', $tag->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('blog_tags.destroy', $tag->id));
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
        $table->rawColumns(['visible', 'is_popular', 'in_index', 'action']);


        Administration::setTitle(trans('blog::admin.module_tags_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_tags_name'));
        });

        return $table->generate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = new AdministrationForm();
        $form->route(Administration::route('blog_tags.store'));
        $form->form(BlogTagForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_tags_name'), Administration::route('blog_tags.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('blog_tags.create'));
        });

        Administration::setTitle(trans('blog::admin.tags') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $tag = new BlogTag();
        $tag->fill($request->validated());
        $tag->save();

        return redirect(Administration::route('blog_tags.index'))->withSuccess([trans('administration::admin.success_create')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = BlogTag::withTrashed()->where('id', $id)->first();

        if (empty($tag)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('blog_tags.update', $tag->id));
        $form->form(BlogTagForm::class);
        $form->model($tag);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_tags_name'), Administration::route('blog_tags.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('blog::admin.tags') . ' - ' . trans('administration::admin.edit') . ' #' . $tag->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param StoreTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreTagRequest $request)
    {
        $tag = BlogTag::withTrashed()->where('id', $id)->first();

        if (empty($tag)) {
            abort(404);
        }

        $tag->fill($request->validated());
        $tag->save();

        return redirect(Administration::route('blog_tags.index'))->withSuccess([trans('administration::admin.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {

        $tag = BlogTag::withTrashed()->where('id', $id)->first();

        if (!empty($tag->deleted_at)) {
            $tag->restore();
        } else {
            $tag->delete();
        }

        return response()->json();
    }
}
