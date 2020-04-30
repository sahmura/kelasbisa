<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classes;
use App\LogRoll;
use App\LogClasses;
use App\Validations;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Halaman index user
     * 
     * @return \view
     */
    public function indexuser()
    {
        $lastClass = LogRoll::where('user_id', '=', Auth()->user()->id)->with('class')->orderBy('updated_at', 'desc')->first();
        $totalClass = LogClasses::where('user_id', '=', Auth()->user()->id)->count();
        $dataEmail = User::where('id', '=', Auth()->user()->id)->first('email_verified_at');
        return view('pages.user.user_dashboard', compact('lastClass', 'totalClass', 'dataEmail'));
    }

    /**
     * Halaman setting
     * 
     * @return view
     */
    public function settingindex()
    {
        $data = User::where('id', '=', Auth()->user()->id)->first();
        return view('pages.dashboard.settingindex', compact('data'));
    }

    /**
     * Update profil
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function updateProfile(Request $request)
    {
        if (User::where('email', '=', $request->email)->whereNotIn('id', [Auth()->user()->id])->count() == 0) {
            $update = User::where('id', '=', Auth()->user()->id)->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                ]
            );
            if ($update) {
                $response = [
                    'status' => true,
                    'message' => 'Data diri berhasil disunting',
                    'notes' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Data diri gagal disunting',
                    'notes' => ''
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Email tidak tersedia',
                'notes' => 'Gunakan email yang belum terdaftar'
            ];
        }

        return response()->json($response);
    }

    /**
     * Update password
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function updatePassword(Request $request)
    {
        $oldPassword = User::where('id', '=', Auth()->user()->id)->first();
        if (Hash::check($request->oldpassword, $oldPassword->password)) {
            if ($request->newpassword == $request->confirmpassword) {
                $update = User::where('id', '=', Auth()->user()->id)->update(
                    [
                        'password' => Hash::make($request->newpassword)
                    ]
                );
                if ($update) {
                    $response = [
                        'status' => true,
                        'message' => 'Password berhasil disunting',
                        'notes' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Password gagal disunting',
                        'notes' => ''
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Konfirmasi password tidak sesuai',
                    'notes' => 'Pastikan memasukan konfirmasi password baru dengan benar'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Password lama tidak sesuai',
                'notes' => 'Pastikan memasukan password lama dengan benar'
            ];
        }

        return response()->json($response);
    }

    /**
     * Update profil
     * 
     * @param $request menerima data
     * 
     * @return json
     */
    public function updateProfilPic(Request $request)
    {
        $data = User::where('id', '=', Auth()->user()->id)->first();
        $extension = ['jpg', 'png', 'jpeg'];
        $pic = $request->file('profil');

        if (!in_array($pic->getClientOriginalExtension(), $extension)) {
            $response = [
                'status' => false,
                'message' => 'Format yang diperbolehkan jpg, png, jpeg',
                'notes' => ''
            ];
            return redirect('setting')->with('error', $response['message']);
        } else if ($pic->getSize() >= 500048) {
            $response = [
                'status' => false,
                'message' => $pic->getSize(),
                'notes' => ''
            ];
            return redirect('setting')->with('error', $response['message']);
        } else {

            $file_name = md5($data->name . $data->id) . '.' . $pic->getClientOriginalExtension();
            if ($data->profilpic != '') {
                File::delete('assets/profilpic/' . $data->profilpic);
            }
            try {
                $pic->move('assets/profilpic', $file_name);
                $update = User::where('id', '=', Auth()->user()->id)->update(
                    [
                        'profilpic' => $file_name,
                    ]
                );
                if ($update) {
                    $response = [
                        'status' => true,
                        'message' => 'Profil picture berhasil disunting',
                        'notes' => ''
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Profil picture gagal disunting',
                        'notes' => ''
                    ];
                }
            } catch (\Exception $e) {
                throw $e;
                $response = [
                    'status' => false,
                    'message' => 'Profil picture gagal disunting',
                    'notes' => ''
                ];
            }
        }

        if ($response['status']) {
            return redirect('setting')->with('success', $response['message']);
        } else {
            return redirect('setting')->with('error', $response['message']);
        }
    }

    /**
     * Kirim email konfirmasi
     * 
     * @return Mail
     */
    public function sendConfirmMail()
    {
        $datauser = User::where('id', '=', Auth()->user()->id)->first();
        $checkValidation = Validations::where('user_id', '=', $datauser->id)->where('type', '=', 'CONFIRM REGISTRATION');
        if ($checkValidation->count() == 0) {
            try {
                $validation = Validations::create(
                    [
                        'user_id' => Auth()->user()->id,
                        'tokens' => Str::random(32),
                        'status' => 'Ready',
                        'type' => 'CONFIRM REGISTRATION'
                    ]
                );

                $sendMail = Mail::to($datauser->email)->send(
                    new ConfirmRegistration($datauser, $validation)
                );

                if ($sendMail) {
                    $response = [
                        'status' => true,
                        'message' => 'Email konfirmasi telah di kirim ke ' . $datauser->email
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Email konfirmasi gagal dikirim'
                    ];
                }
            } catch (\Exception $e) {
                throw $e;
                $response = [
                    'status' => false,
                    'message' => 'Email konfirmasi gagal dikirim'
                ];
            }
        } else if ($checkValidation->first('status')->status == 'Ready') {
            $validation = $checkValidation->first();
            $sendMail = Mail::to($datauser->email)->send(
                new ConfirmRegistration($datauser, $validation)
            );
            $response = [
                'status' => true,
                'message' => 'Email konfirmasi telah di kirim ke ' . $datauser->email
            ];
        } else {
            $response = [
                'status' => true,
                'message' => 'Email sudah dikonfirmasi'
            ];
        }


        if ($response['status']) {
            return redirect('user')->with('success', $response['message']);
        } else {
            return redirect('user')->with('error', $response['message']);
        }
    }

    /**
     * Aktivasi user
     * 
     * @param $email email user
     * @param $token token user
     *  
     * @return mixed
     */
    public function activateUser($email, $token)
    {
        $datauser = User::where('email', '=', $email)->first();
        $checkValidation = Validations::where('user_id', '=', $datauser->id)->where('tokens', '=', $token);

        if ($checkValidation->count() == 0) {
            abort('404');
        } else if ($checkValidation->first()->status == 'Done') {
            $response = [
                'status' => true,
                'message' => 'Email sudah dikonfirmasi'
            ];
            if ($response['status']) {
                return redirect('user')->with('success', $response['message']);
            } else {
                return redirect('user')->with('error', $response['message']);
            }
        } else {
            try {
                User::where('id', '=', $datauser->id)->update(
                    [
                        'email_verified_at' => now()
                    ]
                );
                $validation = $checkValidation->update(
                    [
                        'status' => 'Done'
                    ]
                );

                if ($validation) {
                    $response = [
                        'status' => true,
                        'message' => 'Email berhasil dikonfirmasi'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Email gagal dikonfirmasi'
                    ];
                }

                if ($response['status']) {
                    return redirect('user')->with('success', $response['message']);
                } else {
                    return redirect('user')->with('error', $response['message']);
                }
            } catch (\Exception $e) {
                abort('500');
            }
        }
    }
}
