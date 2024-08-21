<?php

namespace App\DataTables;

use App\Models\ProjectFile;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProjectFileDataTable extends DataTable
{
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $formattedValue = $bytes / pow(1024, $pow);

        // Jika formattedValue lebih dari 100.000 dan masih bisa diubah ke unit yang lebih tinggi
        while ($formattedValue >= 1000 && $pow < count($units) - 1) {
            $pow++;
            $formattedValue = $formattedValue / 1024;
        }

        return round($formattedValue, $precision) . ' ' . $units[$pow];
    }

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
            ->addColumn('file', function (ProjectFile $projectFile) {
                return $projectFile->file;
            })
            ->addColumn('size', function (ProjectFile $projectFile) {
                if (Storage::disk('public')->exists('projects/' . $projectFile->project_id . '/' . $projectFile->file)) {
                    $size = Storage::disk('public')->size('projects/' . $projectFile->project_id . '/' . $projectFile->file);
                    return $this->formatBytes($size);
                }
            })
            ->addColumn('created_by', function (ProjectFile $projectFile) {
                return $projectFile->createdBy->name;
            })
            ->addColumn('created_at', function (ProjectFile $projectFile) {
                return $projectFile->created_at->format('Y/m/d H:i');
            })
            ->addColumn('action', function (ProjectFile $projectFile) {
                return '
                    <div class="btn-group">
                        <a href="' . route('projects.files.download', ['id' => $projectFile->project_id, 'fileId' => $projectFile->id]) . '" class="btn btn-sm btn-info">
                            <i class="ri-download-2-line"></i>
                        </a>
                        <a href="' . route('projects.files.destroy', ['id' => $projectFile->project_id, 'fileId' => $projectFile->id]) . '" class="btn btn-sm btn-danger" data-confirm-delete="true">
                            <i class="ri-delete-bin-6-line"></i>
                        </a>
                    </div>
                ';
            })
            ->filter(function ($query) {
                if (request()->has('search') && !is_null(request('search')['value'])) {
                    $search = request('search')['value'];

                    $query->where('file', 'like', "%$search%");
                }
            })
            ->order(function ($query) {
                if (request()->has('order')) {
                    $order = request('order');

                    if ($order[0]['column'] == 1) {
                        $query->orderBy('file', $order[0]['dir']);
                    } elseif ($order[0]['column'] == 3) {
                        $query->orderBy('created_by', $order[0]['dir']);
                    } elseif ($order[0]['column'] == 4) {
                        $query->orderBy('created_at', $order[0]['dir']);
                    }
                }
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProjectFile $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProjectFile $model): QueryBuilder
    {
        $projectId = request()->route('id');

        return $model->newQuery()
            ->where('project_id', $projectId)
            ->with('createdBy')
            ->select('id', 'project_id', 'file', 'mime_type', 'created_by', 'created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('projectfile-table')
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
            Column::make('file')->title('File Name'),
            Column::computed('size')
                ->title('Size')
                ->searchable(false)
                ->orderable(false),
            Column::make('created_by')->title('Author'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
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
        return 'ProjectFile_' . date('YmdHis');
    }
}
