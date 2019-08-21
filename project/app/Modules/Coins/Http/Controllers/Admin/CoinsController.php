<?php

namespace App\Modules\Coins\Http\Controllers\Admin;

use App\Modules\Coins\Forms\CoinForm;
use App\Modules\Coins\Http\Requests\StoreCoinRequest;
use App\Modules\Coins\Models\Coin;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Helpers\AdministrationField;
use Charlotte\Administration\Helpers\AdministrationForm;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class CoinsController extends BaseAdministrationController {
    /**
     * Display a listing of the resource.
     *
     * @param DataTables $datatable
     * @return \Illuminate\Http\Response
     */
    public function index(DataTables $datatable) {

        $columns = [
            'id' => ['title' => trans('coins::admin.id')],
            'title' => ['title' => trans('coins::admin.title')],
            'visible' => ['title' => trans('coins::admin.visible')],
//            'in_menu' => ['title' => trans('coins::admin.in_menu')],
            'created_at' => ['title' => trans('coins::admin.created_at')],
            'action' => ['title' => trans('coins::admin.action')]
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(Coin::withTrashed()->reversed());
        $table->columns($columns);
        $table->addColumn('visible', function ($coin) {
            return AdministrationField::switch('visible', $coin);
        });
        $table->addColumn('in_menu', function ($coin) {
            return AdministrationField::switch('in_menu', $coin);
        });
        $table->addColumn('action', function ($coin) {
            $action = AdministrationField::edit(Administration::route('coins.edit', $coin->id));
            $action .= AdministrationField::media($coin);
            $action .= AdministrationField::link(Administration::route('analyzes.index', ['coin_id' => $coin->id]));


            if (empty($coin->deleted_at)) {
                $action .= AdministrationField::delete(Administration::route('coins.destroy', $coin->id));
            } else {
                $action .= AdministrationField::restore(Administration::route('coins.destroy', $coin->id));
            }

            return $action;
        });

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {
            if ($request->has('search')) {
                $query->whereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('title', 'LIKE', '%' . $request->search["value"] . '%');
                });

                $query->orWhereHas('translations', function ($sub_q) use ($request) {
                    $sub_q->where('slug', 'LIKE', '%' . $request->search["value"] . '%');
                });
            }
        });
        $table->rawColumns(['visible', 'in_menu', 'action']);


        Administration::setTitle(trans('coins::admin.module_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('coins::admin.module_name'));
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
        $coin = Coin::withTrashed()->where('id', $id)->first();

        if (empty($coin)) {
            abort(404);
        }

        $form = new AdministrationForm();
        $form->route(Administration::route('coins.update', $coin->id));
        $form->form(CoinForm::class);
        $form->model($coin);
        $form->method('PUT');

        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('coins::admin.module_name'), Administration::route('coins.index'));
            $breadcrumbs->push(trans('administration::admin.edit'));
        });

        Administration::setTitle(trans('coins::admin.module_name') . ' - ' . trans('administration::admin.edit') . ' #' . $coin->slug);

        return $form->generate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCoinRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCoinRequest $request, $id) {

        $coin = Coin::withTrashed()->where('id', $id)->first();

        if (empty($coin)) {
            abort(404);
        }

        $coin->fill($request->validated());
        $coin->save();

        return redirect(Administration::route('coins.index'))->withSuccess([trans('administration::admin.success_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $coin = Coin::withTrashed()->where('id', $id)->first();
        if (!empty($coin->deleted_at)) {
            $coin->restore();
        } else {
            $coin->delete();
        }

        return response()->json();
    }
}
