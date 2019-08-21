<?php

namespace App\Modules\Blog\Http\Controllers\Admin;

use App\Modules\Blog\Forms\BlogCommentForm;
use App\Modules\Blog\Http\Requests\StoreBlogCommentRequest;
use App\Modules\Blog\Models\BlogComment;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class BlogCommentsController extends BaseAdministrationController {
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return \Illuminate\Http\Response
     */
    public function index(DataTables $datatable) {
        $columns = [
            'id' => ['title' => trans('blog::admin.id')],
            'name' => ['title' => trans('blog::admin.name')],
            'email' => ['title' => trans('blog::admin.email')],
            'article' => ['title' => trans('blog::admin.article')],
            'comment' => ['title' => trans('blog::admin.comment')],
            'visible' => ['title' => trans('blog::admin.visible')],
            'created_at' => ['title' => trans('blog::admin.created_at')],
            'action' => ['title' => trans('blog::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(BlogComment::reversed()->with('article'));
        $table->columns($columns);
        $table->addColumn('article', function ($comment) {
            return $comment->article->title;
        });
        $table->editColumn('comment', function ($comment) {
            $comment = $comment->comment;
            if (strlen($comment) > 100)
                $comment = substr($comment, 0, 100) . '...';

            return $comment;

        });
        $table->addColumn('visible', function ($comment) {
            return AdministrationField::switch('visible', $comment);
        });
        $table->addColumn('action', function ($comment) {
            $action = AdministrationField::edit(Administration::route('blog_comments.edit', $comment->id));
            $action .= AdministrationField::delete(Administration::route('blog_comments.destroy', $comment->id));
            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {
            if ($request->has('search')) {
                $query->where('name', 'LIKE', '%' . $request->search["value"] . '%');
                $query->orWhere('email', 'LIKE', '%' . $request->search["value"] . '%');
                $query->orWhere('comment', 'LIKE', '%' . $request->search["value"] . '%');
                $query->orWhereHas('article', function ($art_q) use ($request) {
                    $art_q->whereHas('translations', function ($art_trans_q) use ($request) {
                        $art_trans_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                    });
                });
            }
        });
        $table->rawColumns(['visible', 'action']);


        Administration::setTitle(trans('blog::admin.comments'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.module_name'), Administration::route('blog.index'));
            $breadcrumbs->push(trans('blog::admin.comments'));
        });

        return $table->generate();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $comment = BlogComment::where('id', $id)->first();

        if (empty($comment)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('blog_comments.update', $comment->id));
        $form->form(BlogCommentForm::class);
        $form->model($comment);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('blog::admin.comments'), Administration::route('blog_comments.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('blog::admin.comments') . ' - ' . trans('administration::admin.edit') . ' #' . $comment->id);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreBlogCommentRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogCommentRequest $request, $id) {
        $comment = BlogComment::where('id', $id)->first();

        if (empty($comment)) {
            abort(404);
        }

        $comment->fill($request->validated());
        $comment->save();

        return redirect(Administration::route('blog_comments.index'))->withSuccess([trans('administration::admin.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $comment = BlogComment::where('id', $id)->first();
        $comment->delete();


        return response()->json();
    }
}
