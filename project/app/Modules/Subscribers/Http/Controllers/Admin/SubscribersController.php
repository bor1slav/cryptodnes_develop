<?php

namespace App\Modules\Subscribers\Http\Controllers\Admin;

use App\Modules\Subscribers\Models\Subscriber;
use Charlotte\Administration\Helpers\Administration;
use Charlotte\Administration\Helpers\AdministrationDatatable;
use Charlotte\Administration\Http\Controllers\BaseAdministrationController;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Yajra\DataTables\DataTables;

class SubscribersController extends BaseAdministrationController
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
            'id' => ['title' => trans('subscribers::admin.id')],
            'email' => ['title' => trans('subscribers::admin.email')],
            'created_at' => ['title' => trans('coins::admin.created_at')],
        ];

        $table = new AdministrationDatatable($datatable);
        $table->query(Subscriber::query());
        $table->columns($columns);

        $request = $datatable->getRequest();
        $table->filter(function ($query) use ($request) {
            if ($request->has('search')) {
                $query->where('email', 'LIKE', '%' . $request->search["value"] . '%');
            }
        });

        Administration::setTitle(trans('subscribers::admin.module_name'));
        Breadcrumbs::register('administration', function ($breadcrumbs) {
            $breadcrumbs->parent('base');
            $breadcrumbs->push(trans('subscribers::admin.module_name'));
        });

        return $table->generate();
    }
}
