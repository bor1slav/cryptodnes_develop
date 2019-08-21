<?php

namespace Charlotte\Administration\Helpers;


use Illuminate\Support\Facades\View;

class AdministrationDatatable {

    private $datatable;
    private $columns = [];
    private $parameters = [];
    private $query;
    private $generatedColumns = [];
    private $rawColumns = [];
    private $filter;
    private $filteredColumns = [];
    private $smart = true;
    private $order;

    public function __construct($datatable) {
        $this->datatable = $datatable;
    }

    public function generate() {
        if ($this->datatable->getRequest()->ajax()) {
            return $this->ajax();
        }
        return $this->builder();
    }


    protected function ajax() {
        $result = $this->datatable::of($this->query);

        foreach ($this->generatedColumns as $column_name => $closure) {
            $result = $result->addColumn($column_name, $closure);
        }

        foreach ($this->filteredColumns as $column_name => $closure) {
            $result = $result->filterColumn($column_name, $closure);
        }

        if (!empty($this->order)) {
            $result = $result->order($this->order);
        }

        if (!empty($this->filter)) {
            $result = $result->filter($this->filter);
        }

        $result = $result->rawColumns($this->rawColumns);
        $result = $result->smart($this->smart);
        $result = $result->make(true);

        return $result;
    }

    protected function builder() {

        //set order selector
        $this->parameters['rowReorder'] = [
            'selector' => 'tr>td:first-child', // I allow all columns for dragdrop except the last
            'dataSrc' => 'sortsequence',
            'update' => false, // this is key to prevent DT auto update,
        ];

        $this->parameters['orderable'] = false;

        $table = $this->datatable->getHtmlBuilder()->columns($this->columns)->parameters($this->parameters);
        $model = get_class($this->query->getModel());

        View::share('table', $table);
        View::share('model', $model);


        return view('administration::pages.empty-page')->render();
    }

    public function columns($columns) {
        $this->columns = $columns;
    }

    public function parameters($parameters) {
        $this->parameters = $parameters;
    }

    public function query($query) {
        $this->query = $query;
    }

    public function smart($smart) {
        $this->smart = $smart;
    }

    public function order($closure) {
        $this->order = $closure;
    }

    public function editColumn($name, $closure) {
        $this->generatedColumns[$name] = $closure;
    }


    public function addColumn($name, $closure) {
        //TODO check if already exists
        $this->generatedColumns[$name] = $closure;
    }

    public function rawColumns($rawColumns) {
        $this->rawColumns = $rawColumns;
    }

    public function filter($closure) {
        $this->filter = $closure;
    }

    public function filterColumn($name, $closure) {
        $this->filteredColumns[$name] = $closure;
    }
}