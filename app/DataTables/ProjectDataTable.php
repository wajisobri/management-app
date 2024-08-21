<?php

namespace App\DataTables;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class ProjectDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('project_name', function (Project $project) {
                return $project->project_name;
            })
            ->addColumn('project_description', function (Project $project) {
                return $project->project_description;
            })
            ->addColumn('deadline', function (Project $project) {
                return $project->deadline->format('l, Y/m/d H:i');
            })
            ->addColumn('created_by', function (Project $project) {
                return $project->userCreated->name ?? '-';
            })
            ->addColumn('created_at', function (Project $project) {
                return $project->created_at->format('Y/m/d H:i');
            })
            ->addColumn('action', '
                <div class="btn-group">
                    <button class="btn btn-sm btn-warning" onclick="openModalEditProject({{ $id }})">
                        <i class="ri-pencil-line"></i>
                    </button>
                    <a href="{{ route("projects.destroy", $id) }}" class="btn btn-sm btn-danger" data-confirm-delete="true">
                        <i class="ri-delete-bin-6-line"></i>
                    </a>
                    <a href="{{ route("projects.files.index", $id) }}" class="btn btn-sm btn-info">
                        <i class="ri-file-2-line"></i>
                    </a>
                </div>
            ')
            ->filter(function ($query) {
                if (request()->has('search') && !is_null(request('search')['value'])) {
                    $search = request('search')['value'];

                    $query->where('project_name', 'like', "%$search%")
                        ->orWhere('project_description', 'like', "%$search%")
                        ->orWhere('deadline', 'like', "%$search%")
                        ->orWhereHas('userCreated', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhere('created_at', 'like', "%$search%");
                }
            })
            ->order(function ($query) {
                if (request()->has('order')) {
                    $order = request('order')[0];

                    if ($order['column'] == 1) {
                        $query->orderBy('project_name', $order['dir']);
                    }

                    if ($order['column'] == 2) {
                        $query->orderBy('project_description', $order['dir']);
                    }

                    if ($order['column'] == 3) {
                        $query->orderBy('deadline', $order['dir']);
                    }

                    if ($order['column'] == 4) {
                        $query->orderBy('created_by', $order['dir']);
                    }

                    if ($order['column'] == 5) {
                        $query->orderBy('created_at', $order['dir']);
                    }
                }
            })
            ->rawColumns(['project_description', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Project $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Project $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('userCreated')
            ->select('id', 'project_name', 'project_description', 'deadline', 'created_by', 'created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('project-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex', '#')
                ->exportable(false)
                ->printable(false),
            Column::make('project_name')->title('Project Name'),
            Column::make('project_description')->title('Project Description'),
            Column::make('deadline')->title('Deadline'),
            Column::make('created_by')->title('Author'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Project_' . date('YmdHis');
    }
}
