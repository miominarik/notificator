<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdminEditUserRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.index');
    }

    public function all_users()
    {
        $return_data = DB::table('users')
            ->select('id', 'email', 'email_verified_at', 'blocked', 'created_at')
            ->orderByDesc('id')
            ->paginate(15);

        foreach ($return_data as $one_data_id => $one_data_data) {
            if ($one_data_data->email_verified_at !== NULL) {
                $return_data[$one_data_id]->email_verified_at = Carbon::parse($one_data_data->email_verified_at)->format('d.m.Y H:i');
            };
            $return_data[$one_data_id]->created_at = Carbon::parse($one_data_data->created_at)->format('d.m.Y H:i');
        }

        return view('superadmin.pages.users', [
            'all_users' => $return_data
        ]);
    }

    public function user_detail(Request $request)
    {
        $user_detail = DB::table('users')
            ->select('id', 'email', 'email_verified_at', 'blocked', 'superadmin', 'apple_id', 'google_id', 'microsoft_id', 'created_at', 'updated_at')
            ->where('id', $request->user_id)
            ->get();

        $user_tasks = DB::table('tasks')
            ->select('id', 'task_name', 'task_type', 'task_next_date', 'task_enabled', 'created_at')
            ->where('user_id', $request->user_id)
            ->orderByDesc('task_enabled')
            ->orderByDesc('id')
            ->paginate(10);

        $mfa_status = DB::table('mfa_authorization')
            ->where('user_id', '=', $request->user_id)
            ->count();

        if (isset($user_detail[0])) {
            if ($user_detail[0]->apple_id != NULL) {
                $user_detail[0]->apple_id = TRUE;
            } else {
                $user_detail[0]->apple_id = FALSE;

            };
            if ($user_detail[0]->google_id != NULL) {
                $user_detail[0]->google_id = TRUE;
            } else {
                $user_detail[0]->google_id = FALSE;
            };
            if ($user_detail[0]->microsoft_id != NULL) {
                $user_detail[0]->microsoft_id = TRUE;
            } else {
                $user_detail[0]->microsoft_id = FALSE;
            };

            if (isset($user_detail[0]->created_at)) {
                $user_detail[0]->created_at = Carbon::parse($user_detail[0]->created_at)->format('d.m.Y H:i');
            };

            if (isset($user_detail[0]->updated_at)) {
                $user_detail[0]->updated_at = Carbon::parse($user_detail[0]->updated_at)->format('d.m.Y H:i');
            } else {
                $user_detail[0]->updated_at = '';
            };

            return view('superadmin.pages.user_detail', [
                'user_detail' => $user_detail,
                'user_tasks' => $user_tasks,
                'mfa_status' => $mfa_status
            ]);
        } else {
            return redirect(route('superadmin.index'));
        };
    }

    public function users_deauthorization($user_id, $auth_type)
    {

        if (isset($user_id) && isset($auth_type)) {
            $allowed_auth_types = ['apple', 'microsoft', 'google'];

            if ($user_id > 0 && in_array($auth_type, $allowed_auth_types) == TRUE) {
                $auth_type_db = match ($auth_type) {
                    'apple' => 'apple_id',
                    'microsoft' => 'microsoft_id',
                    'google' => 'google_id'
                };

                DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        $auth_type_db => NULL
                    ]);
            }
        }

        return redirect()->back();

    }

    public function update_users_detail(SuperAdminEditUserRequest $request, $user_id)
    {
        $validated = $request->validated();

        if ($validated && isset($user_id) && ($validated['superadmin'] == 0 || $validated['superadmin'] == 1)) {
            DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'email' => $validated['email'],
                    'superadmin' => $validated['superadmin']
                ]);
        }
        return redirect()->back();
    }

    public function tooglestatus($user_id)
    {
        if (isset($user_id)) {
            $get_status = DB::table('users')
                ->select('blocked')
                ->where('id', $user_id)
                ->get();

            if (isset($get_status[0]->blocked)) {
                $new_status = match ($get_status[0]->blocked) {
                    0 => 1,
                    1 => 0
                };

                DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        'blocked' => $new_status
                    ]);
            };
        };

        return redirect()->back();
    }

    public function users_modules()
    {
        $users_modules = DB::table('modules')
            ->select('users.email', 'discount_percent', 'module_sms', 'module_calendar')
            ->join('users', 'modules.user_id', '=', 'users.id')
            ->orderByDesc('users.id')
            ->paginate(10);

        return view('superadmin.pages.users_modules', [
            'users_modules' => $users_modules
        ]);
    }

    public function logs()
    {
        $return_data = DB::table('logs')
            ->select('logs.log_type', 'logs.ip_address', 'logs.created_at', 'users.email', 'tasks.task_name')
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->leftJoin('tasks', 'logs.task_id', '=', 'tasks.id')
            ->orderByDesc('logs.created_at')
            ->paginate(150);

        foreach ($return_data as $one_data_id => $one_data_data) {
            $return_data[$one_data_id]->created_at = Carbon::parse($one_data_data->created_at)->format('d.m.Y H:i');
        }

        return view('superadmin.pages.logs', [
            'all_logs' => $return_data
        ]);
    }

    public function removemfa(int $user_id)
    {
        DB::table('mfa_authorization')
            ->where('user_id', '=', $user_id)
            ->delete();
        return redirect()->back();
    }

}
