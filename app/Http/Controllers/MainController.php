<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Table;
use SevenShores\Hubspot\Resources\Analytics;
use SevenShores\Hubspot\Resources\Contacts;
use Validator;
use Auth;
use Http;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index()
    {
        return view('login');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */

    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        if(Auth::attempt($user_data))
        {
            return redirect('main/successlogin');
        }
        else
        {
            return back()->with('error', 'Wrong Login Details');
        }

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function successlogin()
    {
        $users = DB::table('users')->get();
        return view('successlogin')->with('users',$users);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function logout()
    {
        Auth::logout();
        return redirect('main');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function successregistration(Request $request)
    {
        $name = $request->input('name');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $password = $request->input('password');
        $password = Hash::make($password);
        DB::insert('insert into users(id,name,last_name,email,password) values (?,?,?,?,?)',[null,$name,$lastname,$email,$password]);
        return redirect('main/successlogin');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function successedit(Request $request,$id)
    {
        $userData['name'] = $request->input('name');
        $userData['last_name'] = $request->input('lastname');
        $userData['email'] = $request->input('email');

        DB::table('users')->where('id',$id)->update($userData);
        return redirect('main/successlogin');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        return view('register');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function syncContact()
    {
        $contacts = json_decode(file_get_contents('C:\xampp\htdocs\zoeInterview\contacts.json'),true);
        $contactsInfo = array();
        $contactsArray = array();
        $users = DB::table('users')->get()->toArray();
        $found = false;
        foreach ($contacts['contacts'] as $contact)
        {

            foreach ($contact['identity-profiles'] as $contactEmail)
            {
                foreach ($contactEmail['identities'] as $email)
                {
                    if($email['type'] ==="EMAIL" )
                    {
                        foreach ($users as $user)
                        {
                            if(isset($email['is-primary']) && $user->email === $email['value'])
                            {
                                $found = true;
                            }
                        }
                        if(!$found && $email['type'] === "EMAIL" && isset($email['is-primary']))
                        {
                            $contactsInfo['name'] = $contact['properties']['firstname']['value'];
                            $contactsInfo['last_name'] = $contact['properties']['lastname']['value'];
                            $contactsInfo['email'] = $email['value'];
                            $contactsInfo['vid'] = $contact['vid'];
                            $contactsInfo['date_hub'] = date('Y-m-d H:i:s', strtotime($contact['addedAt']));
                        }
                    }
                }
            }
            $found = false;
            if(!empty($contactsInfo)>0)
            {
                $contactsArray[] = $contactsInfo;
            }
        }
        if(!empty($contactsArray))
        {
            DB::table('users')->insert($contactsArray);
        }
        return redirect('main/successlogin');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteuser($id)
    {
        User::destroy($id);
        return redirect('main/successlogin');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edituser($id)
    {
        $user = DB::table('users')->get()->where('id',$id)->toArray();
        return view('edituser')->with('user',$user[0]);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $users = DB::table('users')->where('name','like',"%$search%")->get()->toArray();
        return view('successlogin')->with('users',$users);

    }
}
