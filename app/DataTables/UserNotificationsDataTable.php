<?php

namespace App\DataTables;

use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserNotificationsDataTable extends DataTable
{

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                if($row->notification->expires_at < now()){
                    return '<button class="px-2 py-1 text-sm font-medium rounded bg-yellow-300 text-yellow-800 " data-id="'.$row->id.'" disabled>Expired</button>';
                }
                if ($row->read_at) {
                    return '';
                }
                return '<button class="px-2 py-1 text-sm font-medium rounded bg-gray-800 hover:bg-gray-700 text-white mark-read" data-id="'.$row->id.'">Mark as Read</button>';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserNotification $model): QueryBuilder
    {
        return $model->unread()->newQuery()
            ->where('user_id', auth()->user()->id)
            ->with('notification');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('usernotifications-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('rtip')
                    ->parameters([
                        'ordering' => false,
                    ])
                    ->orderBy(2)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('notification.type')->title('Type'),
            Column::make('notification.short_text')->title('Message'),
            Column::make('notification.created_at')->title('Date')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->title('Action'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserNotifications_' . date('YmdHis');
    }
}
