<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('actions', function ($row) {
                $csrf = csrf_field();
                $route = route('impersonate.start', $row->id);
                return <<<HTML
                    <form method="POST" action="{$route}" onsubmit="return confirm('Impersonate {$row->name}?')">
                        {$csrf}
                        <button class="px-4 py-1 bg-gray-800 hover:bg-gray-700 text-white border border-transparent rounded-md">
                            Impersonate
                        </button>
                    </form>
                HTML;
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['users.id', 'users.name', 'users.email', 'users.phone'])
            ->where('role', '!=', 'admin')
            ->withCount([
                'unreadNotifications'
            ]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1, 'asc')
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
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->searchable(false),
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('phone')->title('Phone'),
            Column::computed('unread_notifications_count')->title('Unread Notification')->searchable(false),
            Column::computed('actions')->exportable(false)->printable(false)->title(''),
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
