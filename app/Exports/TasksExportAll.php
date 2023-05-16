<?php

namespace App\Exports;

use App\Models\Task;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class TasksExportAll implements FromCollection, WithHeadings
{
    public function collection()
    {
        $user = Auth::user();
        return Task::select("id", "category_id", "task_type_id", "task_name", "task_desc", "status", "priority", "start_date", "end_date", "start_time", "end_time", "repeat_type")
            ->where('user_id', $user->id)
            ->get();
    }

    public function headings(): array
    {
        return ["Id", "Category ID", "Task Type ID" ,"Task Name", "Task Description", "Status", "Priority", "Start Date", "End Date", "Start Time", "End Time", "Repeat Type"];
    }
}