<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classes;
use App\LogRoll;
use App\LogClasses;
use App\Validations;
use App\Coupons;
use App\MentorStatistic;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistration;
use App\Mail\ForgotPassword;
use App\Transactions;
use Illuminate\Support\Str;
use DB;

class DashboardController extends Controller
{
    /**
     * Halaman index user
     * 
     * @return \view
     */
    public function indexuser()
    {
        $isMentor = MentorStatistic::where('user_id', '=', Auth()->user()->id)->count();
        $lastClass = LogRoll::where('user_id', '=', Auth()->user()->id)->with('class')->orderBy('updated_at', 'desc')->first();
        $totalClass = LogClasses::where('user_id', '=', Auth()->user()->id)->count();
        $dataEmail = User::where('id', '=', Auth()->user()->id)->first('email_verified_at');
        return view('pages.user.user_dashboard', compact('lastClass', 'totalClass', 'dataEmail', 'isMentor'));
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
                'message' => 'Maaf, ukuran maksimal gambar 500KB',
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
                        'message' => 'Email konfirmasi telah di kirim ke ' . $datauser->email . '. Cek folder spam jika tidak ada'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Email konfirmasi gagal dikirim. Ulangi lagi dalam beberapa menit',

                    ];
                }
            } catch (\Exception $e) {
                throw $e;
                $response = [
                    'status' => false,
                    'message' => 'Email konfirmasi gagal dikirim. Ulangi lagi dalam beberapa menit',

                ];
            }
        } else if ($checkValidation->first('status')->status == 'Ready') {
            $validation = $checkValidation->first();
            try {
                $sendMail = Mail::to($datauser->email)->send(
                    new ConfirmRegistration($datauser, $validation)
                );
                $response = [
                    'status' => true,
                    'message' => 'Email konfirmasi telah di kirim ke ' . $datauser->email
                ];
            } catch (\Exception $e) {
                $response = [
                    'status' => true,
                    'message' => 'Email sudah dikonfirmasi'
                ];
            }
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
                        'status' => 'done'
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

    /**
     * Halaman pre transaction
     * 
     * @param $id     menerima data id kelas
     * @param $coupon menerima data kode kupon kelas
     * 
     * @return mixed
     */
    public function preTrasaction($id, $coupon = null)
    {
        if (Transactions::where('class_id', '=', $id)->where('user_id', '=', Auth()->user()->id)->where('status', '=', 'pending')->count() != 0) {

            $class = Classes::where('id', '=', $id)->with('category')->with('speaker')->first();
            $transaction_id = Transactions::where('class_id', '=', $id)->where('user_id', '=', Auth()->user()->id)->where('status', '=', 'pending')->first()->id;

            return view('pages.user.class.class_transaction', compact('class', 'transaction_id'));
        } else if (Transactions::where('class_id', '=', $id)->where('user_id', '=', Auth()->user()->id)->where('status', '=', 'done')->count() != 0) {

            return redirect('user/myclass');
        } else {

            $class = Classes::where('id', '=', $id)->with('category')->with('speaker')->first();
            if ($coupon != null) {
                $discount = Coupons::where('class_id', '=', $id)->where('coupon', '=', $coupon)->first();
                if ($discount) {
                    $discount = $discount->discount;
                } else {
                    $coupon = null;
                    $discount = 0;
                }
            } else {
                $discount = 0;
            }

            return view('pages.user.class.class_pre_transaction', compact('class', 'discount', 'coupon'));
        }
    }

    /**
     * Send email when forgot password
     * 
     * @param $request menerima data request
     * 
     * @return redirect
     */
    public function sendEmailForgotPassword(Request $request)
    {
        $email = $request->email;
        $dataUser = User::where('email', '=', $email)->first();

        if (!$dataUser) {
            $response = [
                'status' => false,
                'message' => 'Email belum terdaftar'
            ];
        } else {
            $token = md5($dataUser->id . $email . now());
            Validations::updateOrCreate(
                ['user_id' => $dataUser->id, 'type' => 'FORGOT PASSWORD', 'status' => 'Ready'],
                [
                    'user_id' => $dataUser->id,
                    'tokens' => $token,
                    'status' => 'Ready',
                    'type' => 'FORGOT PASSWORD'
                ]
            );

            $sendMail = Mail::to($dataUser->email)->send(
                new ForgotPassword($dataUser, $token)
            );

            if (count(Mail::failures()) > 0) {
                $response = [
                    'status' => false,
                    'message' => 'Ada masalah mengirim link reset password, ulangi beberapa menit lagi'
                ];
            } else {
                $response = [
                    'status' => true,
                    'message' => 'Link untuk mereset password sudah dikirim ke ' . $email
                ];
            }
        }

        if ($response['status']) {
            return redirect('resetpassword')->with('success', $response['message']);
        } else {
            return redirect('resetpassword')->with('error', $response['message']);
        }
    }

    /**
     * Change new password
     * 
     * @param $request menerima data
     * 
     * @return mixed
     */
    public function setNewPassword(Request $request)
    {
        $dataUser = User::where('id', '=', $request->user_id)->first();
        $token = $request->token;

        try {
            DB::beginTransaction();
            Validations::where('user_id', '=', $dataUser->id)
                ->where('tokens', '=', $token)
                ->where('status', '=', 'Ready')
                ->where('type', '=', 'FORGOT PASSWORD')
                ->update(
                    [
                        'status' => 'Done'
                    ]
                );
            User::where('id', '=', $dataUser->id)->update(
                [
                    'password' => Hash::make($request->password)
                ]
            );
            DB::commit();
            $response = [
                'status' => true,
                'message' => 'Password berhasil dirubah'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'status' => false,
                'message' => 'Password gagal dirubah. Hubungi admin jika ada kendala'
            ];
        }

        if ($response['status']) {
            return redirect('login')->with('success', $response['message']);
        } else {
            return redirect('login')->with('error', $response['message']);
        }
    }
}
