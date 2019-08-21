<?php

namespace App\Modules\Blog\Http\Controllers\Admin;

use App\Modules\Blog\Forms\BlogForm;
use App\Modules\Blog\Http\Requests\Admin\StoreBlogRequest;
use App\Modules\Blog\Models\Blog;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class BlogController extends BaseAdministrationController
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
            'category' => ['title' => trans('blog::admin.category')],
            'in_index' => ['title' => trans('blog::admin.in_index')],
            'visible' => ['title' => trans('blog::admin.visible')],
            'main' => ['title' => trans('blog::admin.main')],
            'views_count' => ['title' => trans('blog::admin.views_count')],
            'created_at' => ['title' => trans('blog::admin.created_at')],
            'action' => ['title' => trans('blog::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(Blog::withTrashed()->with(['categories'])->reversed());
        $table->columns($columns);
        $table->addColumn('category', function ($article) {
            if ($article->categories->isNotEmpty()) {
                $response = '';
                $count = $article->categories->count();
                $i = 1;
                foreach ($article->categories as $category) {
                    $response .= $category->title;

                    if ($i != $count) {
                        $response .= ',';
                    }
                    $i++;
                }
                return $response;
            }

            return 'none';
        });
        $table->addColumn('in_index', function ($article) {
            return AdministrationField::switch('in_index', $article);
        });
        $table->addColumn('main', function ($article) {
            return AdministrationField::switch('main', $article);
        });
        $table->addColumn('visible', function ($article) {
            return AdministrationField::switch('visible', $article);
        });
        $table->addColumn('action', function ($article) {
            $action = AdministrationField::edit(Administration::route('blog.edit', $article->id));
//            $action .= AdministrationField::media($article);

            if (empty($article->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('blog.destroy', $article->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('blog.destroy', $article->id));
            }

            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {
            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });
                $query->orWhereHas('categories', function ($cat_q) use ($request) {
                    $cat_q->whereHas('translations', function ($cat_trans_q) use ($request) {
                        $cat_trans_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                    });
                });
            }
        });
        $table->rawColumns(['visible', 'is_popular', 'in_index', 'action', 'main']);


        Administration::setTitle(trans('blog::admin.module_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_name'));
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
        $form->route(Administration::route('blog.store'));
        $form->form(BlogForm::class);

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_name'), Administration::route('blog.index'));
            $breadcrumbs->push(trans('administration::admin.create'), Administration::route('blog.create'));
        });

        Administration::setTitle(trans('blog::admin.article') . ' - ' . trans('administration::admin.create'));

        return $form->generate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBlogRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        $article = new Blog();
        $article->fill($request->validated());
        $article->save();

        if (!empty($request->similar_articles)) {
            $article->similar_articles()->attach($request->similar_articles);
        }

        if (!empty($request->tags)) {
            $article->tags()->attach($request->tags);
        }

        if (!empty($request->categories)) {
            $article->categories()->attach($request->categories);
        }

        if  (!empty($request->file)) {
            //delete all previous media
            $old_media = $article->getMedia();
            foreach ($old_media as $image) {
                $image->delete();
            }
            $article->addMedia($request->file)->toMediaCollection();
        }

        return redirect(Administration::route('blog.index'))->withSuccess([trans('administration::admin.success_create')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Blog::withTrashed()->where('id', $id)->first();
        if (empty($article)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('blog.update', $article->id));
        $form->form(BlogForm::class);
        $form->model($article);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_name'), Administration::route('blog.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('blog::admin.article') . ' - ' . trans('administration::admin.edit') . ' #' . $article->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreBlogRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreBlogRequest $request)
    {
        $article = Blog::withTrashed()->where('id', $id)->first();

        if (empty($article)) {
            abort(404);
        }

        $article->fill($request->validated());
        $article->save();

        $article->similar_articles()->detach();
        if (!empty($request->similar_articles)) {
            $article->similar_articles()->attach($request->similar_articles);
        }

        $article->tags()->detach();
        if (!empty($request->tags)) {
            $article->tags()->attach($request->tags);
        }

        $article->categories()->detach();
        if (!empty($request->categories)) {
            $article->categories()->attach($request->categories);
        }

        if  (!empty($request->file)) {
            //delete all previous media
            $old_media = $article->getMedia();
            foreach ($old_media as $image) {
                $image->delete();
            }
            $article->addMedia($request->file)->toMediaCollection();
        }

        return redirect(Administration::route('blog.index'))->withSuccess([trans('administration::admin.success_update')]);
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

        $article = Blog::withTrashed()->where('id', $id)->first();

        if (!empty($article->deleted_at)) {
            $article->restore();
        } else {
            $article->delete();
        }

        return response()->json();
    }
}
