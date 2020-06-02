<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Role\UserRole;
use App\User;
use App\Http\Requests\UserRequest;
use App\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Node\Expr\List_;
use function GuzzleHttp\Psr7\str;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15),'listName' => 'All Users' ]);
    }

    public function active_users(User $model)
    {
        return view('users.index', ['users' => $model->where('is_active',1)->paginate(15),'listName' => 'Active Users' ]);
    }

    public function inactive_users(User $model)
    {
        return view('users.index', ['users' => $model->where('is_active',0)->paginate(15),'listName' => 'Inactive Users' ]);
    }

    public function last_15_days_users(Request $request)
    {
        $resultRecords = array();
        $resultTimes = array();
        $time = today()->subDays(13);
        for ($i=0;$i<15;$i++)
        {
            $records = User::whereDate('created_at','<=', $time )->get();
            $resultRecords[] = $records->count();
            $resultTimes[] = $time->format('M d');
            $time->addDay();
        }
        return response()->json(['records'=>$resultRecords, 'times' => $resultTimes],200);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $model->create($request->merge([
            'password' => Hash::make($request->get('password')),
            'is_active' => $request->has('is_active') ? 1 : 0,
            'identifier' => Str::uuid()->toString(),
            'roles' => [UserRole::ROLE_CUSTOMER],
            'is_quest' => 0
        ])->all());

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param \App\User $user
     * @param string $listName
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function search(Request $request)
    {
        $users = null;

        $activeStatus = null;
        $listName = 'All Users';
        if($request->get('is_active'))
        {
            switch ($request->get('is_active'))
            {
                case '1':
                    $activeStatus = "1";
                    $listName = 'Active Users';
                    break;
                case '-1':
                    $activeStatus = "0";
                    $listName = 'Inactive Users';
                    break;
            }
        }
        $phrase = $request->get('phrase') == null ? "" : $request->get('phrase');
        if($activeStatus == null)
        {

            $users = User::where($request->get('search_by') == null ? 'email' : $request->get('search_by'),'LIKE','%'.$phrase.'%')->paginate(15);
        }
        else
        {
            $users = User::where('is_active',$activeStatus)->where($request->get('search_by') == null ? 'email' : $request->get('search_by'),'LIKE','%'.$phrase.'%')->paginate(15);
        }

        return view('users.index', ['users' => $users, 'listName' => $listName]);
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $hasPassword = $request->get('password');
        $user->update(
            $request->merge([
                'password' => Hash::make($request->get('password')),
                'is_active' => $request->has('is_active') ? 1 : 0
            ])->except([$hasPassword ? '' : 'password']

            ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $profile = Profile::where('user_id',$user->id)->first();
        if($profile != null)
        {
            $profile->delete();
        }
        $setting = UserSetting::where('user_id',$user->id)->first();
        if($setting != null)
        {
            $setting->delete();
        }
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
