<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskScheduler;
use Illuminate\Http\Request;

class TaskScheduleController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',
            'hour' => 'required|integer|min:0|max:23',
            'day' => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'day_of_week' => 'required|integer|min:0|max:6',
        ]);

        $timestamp = mktime($validatedData['hour'], 0, 0, $validatedData['month'], $validatedData['day'],0);
        $hourName = date("g:i A", $timestamp);
        $dayOfMonthName = date("jS", $timestamp);
        $monthName = date("F", $timestamp);
        $weekdayName = date("l", mktime(0, 0, 0, 1, $validatedData['day_of_week']));

        $schedule = new TaskScheduler([
            'task_id' => $validatedData['task_id'],
            'hour' => $hourName,
            'day' => $dayOfMonthName,
            'month' => $monthName,
            'day_of_week' => $weekdayName,
        ]);

        // Save the new TaskSchedule to the database
        $schedule->save();
        return response()->json([
            'status' => 'success',
            'data' => $schedule,
        ]);
    }
}
