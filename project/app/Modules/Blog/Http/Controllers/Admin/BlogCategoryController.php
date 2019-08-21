<?php

namespace App\Modules\Blog\Http\Controllers\Admin;

use App\Modules\Blog\Forms\BlogCategoryForm;
use App\Modules\Blog\Http\Requests\Admin\StoreBlogCategoryRequest;
use App\Modules\Blog\Models\BlogCategory;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class BlogCategoryController extends BaseAdministrationController {
    public function index(DataTables $datatable) {

        $columns = [
            'id' => ['title' => trans('blog::admin.id')],
            'title' => ['title' => trans('blog::admin.title')],
            'in_index' => ['title' => trans('blog::admin.in_index')],
            'in_menu' => ['title' => trans('blog::admin.in_menu')],
            'visible' => ['title' => trans('blog::admin.visible')],
            'created_at' => ['title' => trans('blog::admin.created_at')],
            'action' => ['title' => trans('blog::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(BlogCategory::withTrashed()->reversed());
        $table->columns($columns);
        $table->editColumn('title', function ($category) {

            $title = $category->title;

            if ($category->descendants->isNotEmpty()) {
               $title .= ' <a href="' . Administration::route('blog_categories.index', ['parent_id' => $category->id]) . '"><i class="ti-arrow-circle-right" aria-hidden="true"></i></a>';
            }

            return $title;
        });
        $table->addColumn('visible', function ($category) {
            return AdministrationField::switch('visible', $category);
        });
        $table->addColumn('in_index', function ($category) {
            return AdministrationField::switch('in_index', $category);
        });
        $table->addColumn('in_menu', function ($category) {
            return AdministrationField::switch('in_menu', $category);
        });
        $table->addColumn('action', function ($category) {
            $action = AdministrationField::edit(Administration::route('blog_categories.edit', $category->id));

            if (empty($category->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('blog_categories.destroy', $category->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('blog_categories.destroy', $category->id));
            }

//            $action .= AdministrationField::media($category, ['default', 'dodo']);
            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {
            if ($request->has('parent_id')) {
                $query->where('parent_id', $request->input('parent_id'));
            } else {
                $query->whereNull('parent_id');
            }

            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });
            }
        });
        $table->rawColumns(['title', 'visible', 'in_index', 'in_menu', 'action']);


        Administration::setTitle(trans('blog::admin.categories'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_name'), Administration::route('blog.index'));
            $breadcrumbs->push(trans('blog::admin.categories'));
        });

        return $table->generate();
    }

    public function create() {
        $form = new AdministrationForm();
        $form->route(Administration::route('blog_categories.store'));
        $form->form(BlogCategoryForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.categories'), Administration::route('blog_categories.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('blog_categories.create'));
        });

        Administration::setTitle(trans('blog::admin.categories') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    public function store(StoreBlogCategoryRequest $request) {
        $category = new BlogCategory();
        $category->fill($request->validated());
        $category->save();

        return redirect(Administration::route('blog_categories.index'))->withSuccess([trans('administration::admin.success_create')]);
    }

    public function edit($id) {
        $category = BlogCategory::withTrashed()->where('id', $id)->first();
        if (empty($category)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('blog_categories.update', $category->id));
        $form->form(BlogCategoryForm::class);
        $form->model($category);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.categories'), Administration::route('blog_categories.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('blog::admin.categories') . ' - ' . trans('administration::admin.edit') . ' #' . $category->id);

        return $form->generate();
    }

    public function update($id, StoreBlogCategoryRequest $request) {
        $category = BlogCategory::withTrashed()->where('id', $id)->first();

        if (empty($category)) {
            abort(404);
        }


        $category->fill($request->validated());
        $category->save();

        return redirect(Administration::route('blog_categories.index'))->withSuccess([trans('administration::admin.success_update')]);
    }

    public function destroy($id) {
        $category = BlogCategory::withTrashed()->where('id', $id)->first();
        if (!empty($category->deleted_at)) {
            $category->restore();
        } else {
            $category->delete();
        }

        return response()->json();
    }
}
