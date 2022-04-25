<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;
use Validator;
use App\Models\User;  //Need to check
use App\Models\Users;  //Need to check
use App\Models\Services;
use App\Models\AgentProvidedServices;
use App\Models\Fitness_survey;
use App\Models\Verification;

use App\Models\BusinessReviews;
use App\Models\Categorys;
use App\Models\Ratings;

use App\Models\Businessreviewlikedislike;
use Hash;
use DateTime;
use Session;

use App\Models\Quoates;
use App\Models\Giweaway;

use App\Models\Hotspots;
use App\Models\BusinessFav;

use App\Models\Replies;
use App\Models\BuinessReports;

class agentController extends Controller
{
    //agent register 
    public function agentRegister(Request $request)  //In Use //RR  (UNDER Construction)
    {
        date_default_timezone_set('Asia/Kolkata');
        $email = $request->email;

        $emailExist = DB::table('users')->where('email', $email)->where('role',99)->count();
        if ($emailExist > 0) {
            $result = array('status' => false, 'message' => 'Email address already registered');
        } 
        else if(empty($request->lat)){
            $result = array('status' => false, 'message' => 'Latitude is required');
        }
        else if(empty($request->long)){
            $result = array('status' => false, 'message' => 'Longitude is required');
        }else {
            $fname = $request->fname;
            $lname = $request->lname;
            $phone = $request->phone;
            $govtId= $request->govtid;
            $lat= $request->lat;
            $long= $request->long;
            $role= 99;
          
            if(empty($fname)) {
                $result = array('status' => false, 'message' => 'First Name is required.');
            }else if (empty($lname)){
                $result = array('status' => false, 'message' => 'Last Name is required.');
            }else if(empty($phone)){
                $result = array('status' => false, 'message' => 'Phone is required.');

        //---------for govt. id file---------------------Need to check-----------------------------------------------------
            }else if(empty($govtId)){
                $result = array('status' => false, 'message' => 'Id Proof is required.');
            }else{

                if(!empty($govtId)){
                    $fileimage = "";
                    $image_url = '';
                    if ($request->hasfile('govtId')) {
                        $file_image = $request->file('govtId');
                        $extension = $file_image->getClientOriginalExtension();
                        $allowedExt = array('jpg','jpeg','png','pdf');
                        if (!in_array($extension, $allowedExt)) {
                            $result = array('status' => false, 'message' => 'Please upload only jpg, jpeg, png and pdf files');
                        }

                        $fileimage = time() . "_" . $file_image->getClientOriginalExtension();
                        $destination = public_path("govtId");
                        $file_image->move($destination, $fileimage);
                        $image_url = url('public/upload_doc') . '/' . $fileimage;
                    }else{
                        $result = array('status' => false, 'message' => 'Id Proof is required.');
                    }
                }
        //---------for govt. id file-------------------------------------------------------------------------------

                $image_url = url('public/images/userimage.png');
                $password = Hash::make($request->password);
                $otp =  rand(100000, 999999);
                $date = date("Y-m-d H:i:s", time());

                $data = ['fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone'=>$phone, 'password' => $password, 'image' => $image_url, 'status' => 1, 'role' => $role, 'upload_doc'=> $fileimage,'lat'=>$lat,'long'=>$long];
                
                $updated = DB::table('temp_users')->where('email', $request->email)->where('role',$role)->first();
                $up_otp = ['otp' => $otp, 'email' => $email, 'role' => $role, 'create_at' => $date, 'update_at' => $date];
                if (!empty($updated)) {
                    DB::table('temp_users')->where('email', $request->email)->delete();
                    DB::table('password_otp')->where('email', $request->email)->delete();
                    $subject = "Register Otp";
                    $message = "Register Otp OTP " . $otp;

                    $update = DB::table('temp_users')->insert($data);
                    $upt_success = DB::table('password_otp')->insert($up_otp);
                } else {
                    $subject = "Register Otp";
                    $message = "Register Otp OTP " . $otp;

                    $update = DB::table('temp_users')->insert($data);
                    $up_otp = ['otp' => $otp, 'email' => $email, 'role'=>$role, 'create_at' => $date, 'update_at' => $date];
                    $upt_success = DB::table('password_otp')->insert($up_otp);
                }

                if ($this->sendMail($request->email, $subject, $message)) {
                    //  $this->sendMail($request->email,$subject,$message);
                    $emailExist = DB::table('temp_users')->where('email', $email)->where('role',99)->first();
                    $result = array('status' => true, 'message' => 'OTP sent successfully.', 'data' => $emailExist);
                } else {
                    $result = array('status' => false, 'message' => 'Something went wrong. Please try again.');
                }
            }
        }
        echo json_encode($result);
    }
    //agent register 
    // public function agentRegister_OLD(Request $request)  //In Use //RR
    // {
    //     date_default_timezone_set('Asia/Kolkata');
    //     $email = $request->email;

    //     $emailExist = DB::table('users')->where('email', $email)->where('role',99)->count();
    //     if ($emailExist > 0) {
    //         $result = array('status' => false, 'message' => 'Email address already registered');
    //     } else {
    //         $fname = $request->fname;
    //         $lname = $request->lname;
    //         $phone = $request->phone;
    //         $govtId= $request->govtid;

    //         if(empty($fname)) {
    //             $result = array('status' => false, 'message' => 'First Name is required.');
    //         }else if (empty($lname)){
    //             $result = array('status' => false, 'message' => 'Last Name is required.');
    //         }else if(empty($phone)){
    //             $result = array('status' => false, 'message' => 'Phone is required.');

    //     //---------for govt. id file---------------------Need to check-----------------------------------------------------
    //         }else if(empty($govtId)){
    //             $result = array('status' => false, 'message' => 'Id Proof is required.');
    //         }else{

    //             if(!empty($govtId)){
    //                 $fileimage = "";
    //                 $image_url = '';
    //                 if ($request->hasfile('govtId')) {
    //                     $file_image = $request->file('govtId');
    //                     $extension = $file_image->getClientOriginalExtension();
    //                     $allowedExt = array('jpg','jpeg','png','pdf');
    //                     if (!in_array($extension, $allowedExt)) {
    //                         $result = array('status' => false, 'message' => 'Please upload only jpg, jpeg, png and pdf files');
    //                     }

    //                     $fileimage = time() . "_" . $file_image->getClientOriginalExtension();
    //                     $destination = public_path("govtId");
    //                     $file_image->move($destination, $fileimage);
    //                     $image_url = url('public/upload_doc') . '/' . $fileimage;
    //                 }else{
    //                     $result = array('status' => false, 'message' => 'Id Proof is required.');
    //                 }
    //             }
    //     //---------for govt. id file-------------------------------------------------------------------------------

    //             $image_url = url('public/images/userimage.png');
    //             $password = Hash::make($request->password);
    //             $otp =  rand(100000, 999999);
    //             $date = date("Y-m-d H:i:s", time());

    //             $data = ['fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone'=>$phone, 'password' => $password, 'image' => $image_url, 'status' => 1, 'role' => 99, 'upload_doc'=> $fileimage];
                
    //             $updated = DB::table('temp_users')->where('email', $request->email)->where('role',99)->first();
    //             $up_otp = ['otp' => $otp, 'email' => $email, 'role' => 99, 'create_at' => $date, 'update_at' => $date];
    //             if (!empty($updated)) {
    //                 DB::table('temp_users')->where('email', $request->email)->delete();
    //                 DB::table('password_otp')->where('email', $request->email)->delete();
    //                 $subject = "Register Otp";
    //                 $message = "Register Otp OTP " . $otp;

    //                 $update = DB::table('temp_users')->insert($data);
    //                 $upt_success = DB::table('password_otp')->insert($up_otp);
    //             } else {
    //                 $subject = "Register Otp";
    //                 $message = "Register Otp OTP " . $otp;

    //                 $update = DB::table('temp_users')->insert($data);
    //                 $up_otp = ['otp' => $otp, 'email' => $email, 'create_at' => $date, 'update_at' => $date];
    //                 $upt_success = DB::table('password_otp')->insert($up_otp);
    //             }

    //             if ($this->sendMail($request->email, $subject, $message)) {
    //                 //  $this->sendMail($request->email,$subject,$message);
    //                 $emailExist = DB::table('temp_users')->where('email', $email)->where('role',99)->first();
    //                 $result = array('status' => true, 'message' => 'OTP sent successfully.', 'data' => $emailExist);
    //             } else {
    //                 $result = array('status' => false, 'message' => 'Something went wrong. Please try again.');
    //             }
    //         }
    //     }
    //     echo json_encode($result);
    // }

    
    //agent Login
    public function agentLoginCheck(Request $request)   //In Use //RR
    {
        date_default_timezone_set('Asia/Kolkata');
        $email = $request->email;

        if(!isset($email)) {
            $result = array('status' => false, 'message' => 'Email is required.');
        } else if (!isset($request->password)) {
            $result = array('status' => false, 'message' => 'Password is required.');
        }
        else {

            $password = md5($request->password);
            $emailExist = DB::table('users')->where('email', $email)->where('role',99)->first();
            if (!empty($emailExist)) {
                if ($emailExist->email = $email) {
                    if ($emailExist->status == 2) {
                        if (Hash::check($request->password, $emailExist->password)) {
                            $data['login_check'] = 1;
                            $data['lat'] = $request->lat;
                            $data['long'] = $request->long;
							$data['fcm_token'] = $request->fcm_token;
								
                            DB::table('users')->where('email', $email)->where('role',99)->update($data);
                            $image_url = url('public/images/userimage.png');
                            $emailExist->image = isset($emailExist->image) ? $emailExist->image : $image_url;
                            $result = array('status' => true, 'message' => 'Logged in Successfully.', 'data' => $emailExist);
                        } else {
                            $result = array('status' => false, 'message' => 'Invalid Password');
                        }
                    } else {
                        $result = array('status' => false, 'message' => 'Your account has been deactivated by admin');
                    }
                } else {
                    $result = array('status' => false, 'message' => 'Invalid Email address');
                }
            } else {
                $result = array('status' => false, 'message' => 'User not registered');
            }
        }
        echo json_encode($result);
    }

    // public function agentLoginCheck_OLD(Request $request)   //In Use //RR
    // {
    //     date_default_timezone_set('Asia/Kolkata');
    //     $email = $request->email;

    //     if(!isset($email)) {
    //         $result = array('status' => false, 'message' => 'Email is required.');
    //     } else if (!isset($request->password)) {
    //         $result = array('status' => false, 'message' => 'Password is required.');
    //     } else {

    //         $password = md5($request->password);
    //         $emailExist = DB::table('users')->where('email', $email)->where('role',99)->first();
    //         if (!empty($emailExist)) {
    //             if ($emailExist->email = $email) {
    //                 if ($emailExist->status == 2) {
    //                     if (Hash::check($request->password, $emailExist->password)) {
    //                         $data['login_check'] = 1;
    //                         DB::table('users')->where('email', $email)->where('role',99)->update($data);
    //                         $image_url = url('public/images/userimage.png');
    //                         $emailExist->image = isset($emailExist->image) ? $emailExist->image : $image_url;
    //                         $result = array('status' => true, 'message' => 'Logged in Successfully.', 'data' => $emailExist);
    //                     } else {
    //                         $result = array('status' => false, 'message' => 'Invalid Password');
    //                     }
    //                 } else {
    //                     $result = array('status' => false, 'message' => 'Your account has been deactivated by admin');
    //                 }
    //             } else {
    //                 $result = array('status' => false, 'message' => 'Invalid Email address');
    //             }
    //         } else {
    //             $result = array('status' => false, 'message' => 'User not registered');
    //         }
    //     }
    //     echo json_encode($result);
    // }

    public function agentForgotPassword(Request $request)  //In Use //RR  (Have to Confirm OTP first)
    {
        date_default_timezone_set('Asia/Kolkata');
        $email = $request->email;
        $otp =  mt_rand(100000, 999999);
        $date = date("Y-m-d H:i:s", time());
        if (!empty($email)) {
            $check_email = DB::table('users')->where('email', $email)->where('role',99)->count();

            $subject = "Forgot password";
            $message = "Forgot password OTP " . $otp;
            if ($check_email > 0) {

                $this->sendMail($request->email, $subject, $message);

                $up_otp = ['otp' => $otp, 'create_at' => $date, 'update_at' => $date, 'email' => $email];
                $upt_success = DB::table('password_otp')->where('email', $email)->where('role',99)->update($up_otp);  //Update where email=comming email //RR
                if ($upt_success) {
                    $result = array('status' => true, 'message' => 'Otp sent successfully');
                } else {
                    $upt_success2 = DB::table('password_otp')->insert($up_otp);
                    if ($upt_success2) {
                        $result = array('status' => true, 'message' => 'Otp sent successfully');
                    } else {
                        $result = array('status' => false, 'message' => 'Otp not Send');
                    }
                }
            } else {

                $result = array('status' => false, 'message' => 'Invalid Email Address');
            }
        } else {
            $result = array('status' => false, 'message' => 'Email is required');
        }
        echo json_encode($result);
    }

    public function agentResendOtp(Request $request)   //In Use //RR
    {
        date_default_timezone_set('Asia/Kolkata');
        $email = $request->email;
        $otp =  mt_rand(100000, 999999);
        $date = date("Y-m-d H:i:s", time());
        if (!empty($email)) {
            $check_email = DB::table('temp_users')->where('email', $email)->where('role',99)->count();

            $subject = "Resend Otp";
            $message = "Resend OTP " . $otp;
            if ($check_email > 0) {

                $this->sendMail($request->email, $subject, $message);

                $up_otp = ['otp' => $otp, 'create_at' => $date, 'update_at' => $date, 'email' => $email];
                $upt_success = DB::table('password_otp')->where('email', $email)->where('role',99)->update($up_otp);
                if ($upt_success) {

                    $result = array('status' => true, 'message' => 'Otp send successfully');
                } else {
                    $upt_success2 = DB::table('password_otp')->where('role',99)->insert($up_otp);
                    if ($upt_success2) {
                        $result = array('status' => true, 'message' => 'Otp send successfully');
                    } else {
                        $result = array('status' => false, 'message' => 'Otp not Send');
                    }
                }

            } else {

                $result = array('status' => false, 'message' => 'Invalid Email Address');
            }
        } else {
            $result = array('status' => false, 'message' => 'Email is required');
        }
        echo json_encode($result);
    }

    public function agentPasswordVerification(Request $request)  //In Use //RR (Reset Password)
    {
        date_default_timezone_set('Asia/Kolkata');
        $email = $request->email;
        $otp = $request->otp;
        // $method = $request->method;
        $method = 1; 

        $verify_otp = DB::table('password_otp')->where('email', $email)->where('otp', $otp)->where('role',99)->first();

        if (!empty($verify_otp)) {
            $otp_expires_time = Carbon::now()->subMinutes(60);
            $otp_expires_time =  date('m/d/Y h:i:s', time());
            if ($verify_otp->create_at < $otp_expires_time) {
                $result = array('status' => false, 'message' => 'OTP Expired.');
            } else {
                DB::table('password_otp')->where('email', $email)->where('role',99)->delete();
                $user_data = DB::table('temp_users')->where('email', $email)->where('role',99)->first();
                //  dd($user_data);
                $image_url = url('public/images/userimage.png');
                $date = date("Y-m-d h:i:s", time());
                if ($method == 1) {
         
                    $updateData['fname'] = $user_data->fname;
                    $updateData['lname'] = $user_data->lname;
                    $updateData['email'] = $user_data->email;
                    $updateData['password'] = $user_data->password;
                    $updateData['phone'] = $user_data->phone;
                    $updateData['role'] = $user_data->role;
                    $updateData['image'] = isset($user_data->image) ? $user_data->image : $image_url;
                    $updateData['created_at'] = $date;
                    $updateData['updated_at'] = $date;
                    $updateData['lat'] = $user_data->lat;
                    $updateData['long'] = $user_data->long;
                    $updateData['status'] = 1;
                    //  dd($updateData);

                    DB::table('users')->insert($updateData);
                    DB::table('temp_users')->where('email', $email)->where('role',99)->delete();
                    $insertedData =  DB::table('users')->where('email', $email)->where('role',99)->first();
                    $result = array('status' => true, 'message' => 'Signed up successfully.', 'data' => $insertedData);
                } else {
                    $insertedData =  DB::table('users')->where('email', $email)->where('role',99)->first();
                    $result = array('status' => true, 'message' => 'Password OTP verified.', 'data' => $insertedData);
                }
            }
        } else {
            $result = array('status' => false, 'message' => 'invalid Otp');
        }

        echo json_encode($result);
    }

    // public function agentPasswordVerification_OLD(Request $request)  //In Use //RR (Reset Password)
    // {
    //     date_default_timezone_set('Asia/Kolkata');
    //     $email = $request->email;
    //     $otp = $request->otp;
    //     // $method = $request->method;
    //     $method = 1; 

    //     $verify_otp = DB::table('password_otp')->where('email', $email)->where('otp', $otp)->where('role',99)->first();

    //     if (!empty($verify_otp)) {
    //         $otp_expires_time = Carbon::now()->subMinutes(60);
    //         $otp_expires_time =  date('m/d/Y h:i:s', time());
    //         if ($verify_otp->create_at < $otp_expires_time) {
    //             $result = array('status' => false, 'message' => 'OTP Expired.');
    //         } else {
    //             DB::table('password_otp')->where('email', $email)->where('role',99)->delete();
    //             $user_data = DB::table('temp_users')->where('email', $email)->where('role',99)->first();
    //             //  dd($user_data);
    //             $image_url = url('public/images/userimage.png');
    //             $date = date("Y-m-d h:i:s", time());
    //             if ($method == 1) {
         
    //                 $updateData['fname'] = $user_data->fname;
    //                 $updateData['lname'] = $user_data->lname;
    //                 $updateData['email'] = $user_data->email;
    //                 $updateData['password'] = $user_data->password;
    //                 $updateData['phone'] = $user_data->phone;
    //                 $updateData['role'] = $user_data->role;
    //                 $updateData['image'] = isset($user_data->image) ? $user_data->image : $image_url;
    //                 $updateData['created_at'] = $date;
    //                 $updateData['updated_at'] = $date;
    //                 $updateData['status'] = 1;
    //                 //  dd($updateData);

    //                 DB::table('users')->insert($updateData);
    //                 DB::table('temp_users')->where('email', $email)->where('role',99)->delete();
    //                 $insertedData =  DB::table('users')->where('email', $email)->where('role',99)->first();
    //                 $result = array('status' => true, 'message' => 'Signed up successfully.', 'data' => $insertedData);
    //             } else {
    //                 $insertedData =  DB::table('users')->where('email', $email)->where('role',99)->first();
    //                 $result = array('status' => true, 'message' => 'Password OTP verified.', 'data' => $insertedData);
    //             }
    //         }
    //     } else {
    //         $result = array('status' => false, 'message' => 'invalid Otp');
    //     }

    //     echo json_encode($result);
    // }

    public function agentPasswordUpdate(Request $request)  //In Use //RR
    {
        date_default_timezone_set('Asia/Kolkata');
        $email = $request->email;  //Email is required (May send in hidden field)

        $newPassword = Hash::make($request->newPassword);
        $confirmPassword = Hash::make($request->confirmPassword);

        if (!isset($email)) {
            $result = array('status' => false, 'message' => 'Email is required');
        } else if (!isset($request->newPassword)) {
            $result = array('status' => false, 'message' => 'New password is required');
        } else if (!isset($request->confirmPassword)) {
            $result = array('status' => false, 'message' => 'Confirm password is required');
        } else if (!Hash::check($request->confirmPassword, $newPassword)) {
            $result = array('status' => false, 'message' => 'password not match');
        } else {
            $date = date("Y-m-d h:i:s", time());
            $data = ['password' => $newPassword, 'updated_at' => $date];  //array of data
            $pass_upde = DB::table('users')->where('email', $email)->where('role',99)->update($data);
            if ($pass_upde) {
                $result = array('status' => true, 'message' => 'Password reset successfully.');
            } else {
                $result = array('status' => false, 'message' => 'Password not changed.');
            }
        }

        echo json_encode($result);
    }

    public function agentEditProfile(Request $request)  //In Use //RR (For Agent)
    {
        if(!empty($request->id) && is_numeric($request->id)){
            $useData = DB::table('users')->where('id', $request->id)->where('role',99)->first();  //Get first record   

            $service = explode(',',$useData->serviceId);
            $serviceName = '';
            foreach($service as $serviceId){ //get servic name from service id
                $getSerName = DB::table('services')->select('name')->where('id',$serviceId)->get();
                $serviceName .= $getSerName[0]->name.','; 
            }

            $data = array(
                'id'=>$useData->id,
                'fname'=>$useData->fname,
                'lname'=>$useData->lname,
                'email'=>$useData->email,
                'serviceId'=>$useData->serviceId,
                'serviceName'=>$serviceName,
                'phone'=>$useData->phone,
                'role'=>$useData->role,
                'image'=>$useData->image,
                'upload_doc'=>$useData->upload_doc
            );
        }else{
            $result = array('status'=>false, 'message'=>'No user id found');
            echo json_encode($result);
            die;
        }

        if(!empty($useData))
        {
            $result = array('status' => true, 'data' => $data);
        }
        else
        {
            $result = array('status' => false, 'message' => 'No Record Found');
        }
        echo json_encode($result);
    }

    public function agentProfile_update(Request $request)  //In Use (Done for Agent) //RR 
    {
        date_default_timezone_set('Asia/Kolkata');
        if (!empty($request->id)) {
            $userData = DB::table('users')->where('id', $request->id)->where('role',99)->first();  //Get Result //RR

            if (!isset($request->fname)) {
                $result = array('status' => false, 'message' => 'First name is required');
            } else if (!isset($request->lname)) {
                $result = array('status' => false, 'message' => 'Last name is required');
            } else if (!isset($request->phone)) {
                $result = array('status' => false, 'message' => 'Phone number is required');
            } else if (!isset($request->email)) {
                $result = array('status' => false, 'message' => 'Email is required');
            } else {
                $fileimage = "";
                $image_url = '';
                if ($request->hasfile('image')) {
                    $file_image = $request->file('image');
                    //Need to add validations here also //RR
                    $fileimage = $request->id."-".md5(date("Y-m-d h:i:s", time())) . "." . $file_image->getClientOriginalExtension();
                    $destination = public_path("images");
                    $file_image->move($destination, $fileimage);
                    $image_url = url('public/images') . '/' . $fileimage;
                } else {
                    $image_url = $userData->image;
                }

                $updateData = array(
                    'fname' => isset($request->fname) ? $request->fname : $userData->fname,
                    'lname' => isset($request->lname) ? $request->lname : $userData->lname,
                    'phone' => isset($request->phone) ? $request->phone : $userData->phone,
                    'email'=>isset($request->email)? $request->email : $userData->email,
                    'image' => $image_url,
                    'updated_at' => date("Y-m-d h:i:s", time())
                );

                $updateRecord = DB::table('users')->where('id', $userData->id)->update($updateData);  //Update

                if ($updateRecord) {
                    $updatedeData = DB::table('users')->where('id', $request->id)->first();  //Select Updated Record
                    $getUpdatedData = array(
                        'fname'=>$updatedeData->fname,
                        'lname'=>$updatedeData->lname,
                        'email'=>$updatedeData->email,
                        'phone'=>$updatedeData->phone,
                        'role'=>$updatedeData->role,
                        'image'=>$updatedeData->image
                    );
                    $result = array('status' => true, 'message' => 'Profile Update Successfully.', 'data' => $getUpdatedData);
                } else {
                    $result = array('status' => false, 'message' => 'Profile Update Failed.');
                }
            }
        } else {
            $result = array('status' => false, 'message' => 'User ID Not Found');
        }
        echo json_encode($result);
    }

    public function updateServices(request $request){   //Service - Amount Insert and Update //RR (In Use)

        if (!empty($request->id)) {
            // $userData = DB::table('users')->where('id', $request->id)->where('role',99)->first();
            $userData = Users::where('id',$request->id)->first();
              //Get Result //RR

            if(!empty($userData)){
                if(!isset($request->serviceId)){
                    $result = array('status' => false, 'message' => 'Service Id is required');
                }else if(!isset($request->serviceAmount)){
                    $result = array('status' => false, 'message' => 'Service Amount is required');
                }else{
                    $serviceId = $request->serviceId;
                    $serviceAmount = $request->serviceAmount;

                    $sId = count(explode(',',$serviceId));
                    $sAmt = count(explode(',',$serviceAmount));
                    if($sId != $sAmt){
                        $result = array('status' => false, 'message' => 'Number of services and service amount must be same.');
                    }else{
                        //Update 
                        $userData->serviceId=$serviceId;
                        $userData->serviceAmount=$serviceAmount;
                        $userData->save();

                        $this->deeteInsertAgentServices($userData);   //NEWWW for delete-insert data in service table //RR (IMP)

                        // $updateRecord = DB::table('users')->where('id', $request->id)->update($updateData);  //Update
                        // if ($updateRecord) {
                        //     $updatedeData = DB::table('users')->where('id', $request->id)->first();  //Select Updated Record
                        $getUpdatedData = array('id'=>$userData->id );
                        $result = array('status' => true, 'message' => 'Services Update Successfully.', 'data' => $getUpdatedData);
                        // } else {
                        //     $result = array('status' => false, 'message' => 'Services Update Failed.');
                        // }
                    }
                }
            }else{
                $result = array('status' => false, 'message' => 'Agent may not registered, record not found.');
            }
        } else {
            $result = array('status' => false, 'message' => 'Agent Id Not Found');
        }
        echo json_encode($result);
    }

    public function onlineOfflineStatus(request $request){  //In Use - Online Status //RR
        if(isset($request->id)){
            $onlineStatus = $request->onlinestatus;
            if($onlineStatus != 0 && $onlineStatus != 1){
                $result = array('status' => false, 'message' => 'Please send status 0 or 1 only');
            }else{
                $agentData = Users::where('id',$request->id)->where('role',99)->first();
                if($agentData){
                    //Update 
                    $agentData->isOnline=$onlineStatus;
                    $agentData->save();
                    $result = array('status' => true, 'message' => 'Online Status Updated Successfully.');
                }else{
                    $result = array('status' => false, 'message' => 'Agent not registered');
                }
            }
        }else{
            $result = array('status' => false, 'message' => 'Agent Id Not Found');
        }
        echo json_encode($result);
    }


    public function upcomingBookings(Request $request){  //In use (for Agent) //RR

        if(isset($request->agentId)){
            $upcomingsBookings = DB::table('tblbookedagent')->where('agentId', $request->agentId)->where('isAccepted', 1)->where('status', 1)->get();
          
            if(!empty($upcomingsBookings) && count($upcomingsBookings) > 0){

                foreach($upcomingsBookings as $key=> $upcom)
                {
                    $UserDetails1 = DB::table('users')->select('lname','fname','image')->where('id', $upcom->userId)->first();
                    if(!empty($UserDetails1))
                    {
                        $img = $UserDetails1->image;

                        if(isset($img))
                        {
                            $upcomingsBookings[$key]->user_image = $img;
                        }
                        else
                        {
                            $upcomingsBookings[$key]->user_image = url('public/images/userimage.png');
                        }
                        $upcomingsBookings[$key]->fname = $UserDetails1->fname;
                        $upcomingsBookings[$key]->lname = $UserDetails1->lname;
    
                    }
                    else
                    {
                        $upcomingsBookings[$key]->user_image = url('public/images/userimage.png');
                        $upcomingsBookings[$key]->fname = "";
                        $upcomingsBookings[$key]->lname = "";
                      }
                 
                    $userAvg = Ratings::Where('userId', $upcom->userId)->Where('role', "97")->pluck('ratings')->avg();
                    if(is_null($userAvg))
                    {
                        $userAvg=0;
                    }
                   
                     $upcomingsBookings[$key]->userAvgRating  = $userAvg;
                     //services
                     $servicesDetails = DB::table('services')->select('name')->where('id', $upcom->serviceId)->first();
                     $upcomingsBookings[$key]->service_name  = $servicesDetails->name;
                }

                $result = array('status'=>true, 'data'=>$upcomingsBookings);
            }else{
                $result = array('status'=>false, 'message'=>'No upcoming bookings');
            }
        }else{
            $result = array('status'=>false, 'message'=>'AgentId Id is required');
        }
        echo json_encode($result);
    }


    public function pastBooking(Request $request){  //In use (for Agent) //RR
        if(isset($request->agentId)){
            $pastBookings = DB::table('tblbookedagent')->where('agentId', $request->agentId)->where('isApproved', 1)->where('status', 1)->get();
            if(!empty($pastBookings) && count($pastBookings) > 0){
                foreach($pastBookings as $key=> $upcom)
                {
                    $UserDetails1 = DB::table('users')->select('lname','fname','image')->where('id', $upcom->userId)->first();
                    if(!empty($UserDetails1))
                    {
                        $img = $UserDetails1->image;

                        if(isset($img))
                        {
                            $pastBookings[$key]->user_image = $img;
                        }
                        else
                        {
                            $pastBookings[$key]->user_image = url('public/images/userimage.png');
                        }
                        $pastBookings[$key]->fname = $UserDetails1->fname;
                        $pastBookings[$key]->lname = $UserDetails1->lname;
    
                    }
                    else
                    {
                        $pastBookings[$key]->user_image = url('public/images/userimage.png');
                        $pastBookings[$key]->fname = "";
                        $pastBookings[$key]->lname = "";
                      }
                 
                    $userAvg = Ratings::Where('userId', $upcom->userId)->Where('role', "97")->pluck('ratings')->avg();
                    if(is_null($userAvg))
                    {
                        $userAvg=0;
                    }
                   
                     $pastBookings[$key]->userAvgRating  = $userAvg;
                     //services
                     $servicesDetails = DB::table('services')->select('name')->where('id', $upcom->serviceId)->first();
                     $pastBookings[$key]->service_name  = $servicesDetails->name;
                }
               
                $result = array('status'=>true, 'data'=>$pastBookings);
            }else{
                $result = array('status'=>false, 'message'=>'No upcoming bookings');
            }   
        }else{
            $result = array('status'=>false, 'message'=>'Agent Id is required');
        }
        echo json_encode($result);
    }


    public function agentTotalRatings(Request $request){ //In agent (for agent) //RR
        if($request->input())
        {
            $RatingsDetails = Ratings::join('users','users.id', '=','tblratings.agentId')
                                    ->where('userId', $request->agentId)
                                    ->get([
                                            'tblratings.agentId',
                                            'tblratings.ratings',
                                            'tblratings.reviews',
                                            'users.fname',
                                            'users.lname',
                                            'users.image',
                                        ]);

            if(!empty($RatingsDetails)){
                $result = array('status'=>true,'data'=>$RatingsDetails);
            }else{
                $result = array('status'=>false,'data'=>'');
            }
            echo json_encode($result);
        }
    }

    // public function agentNotification(Request $request){
    //     echo "Here";
    //     die; //test
    // }


    // public function AgentFcmToken(Request $request){
    //     echo "Here";
    //     die;
    // }


    public function acceptDeclineWork(Request $request){  //In use Agent Accepts-Decline requested work  //RR

        if(isset($request->bookingId)){
            $bookingId = $request->bookingId;
            $userId = $request->userId;
            $agentId = $agentId->agentId;
            $isAcceptReject = $request->isAccepted;  //Accepted by Agent

            if($isAcceptReject != 1 && $isAcceptReject != 2){
                $result = array('status'=>false, 'message'=>'Values must be 1 or 2 only.');
            }else{
                $update = DB::table('tblbookedagent')->where('id', $request->bookingId)->update(array('isAccepted'=>$isAcceptReject));
                if($update){
                    if($isAcceptReject == 1){
                        $notiData = "Agent $agentId accepted User $userId for booking $bookingId";  //notification data

                        $get_token = Users::select('fcm_token')->where('id',$userId)->first();
                
                     $responseNotification=   $this->sendNotification($get_token->fcm_token, array(
                                    "title" => "Sample Message", 
                                    "body" => $notiData
                                ));

                                
                        $result = array('status'=>true, 'message'=>'Work accepted successfully', 'notification'=>$responseNotification);
                        //Notification must be send to user after acceptance //RR
                    }else if($isAcceptReject == 2){
                        $notiData = "Agent $agentId reject User $userId for booking $bookingId";  //notification data

                        
                        $get_token = Users::select('fcm_token')->where('id',$userId)->first();
                
                     $responseNotification=   $this->sendNotification($get_token->fcm_token, array(
                                    "title" => "Sample Message", 
                                    "body" => $notiData
                                ));

                        $result = array('status'=>true, 'message'=>'Work rejected successfully', 'notification'=>$responseNotification);
                        //Notification must be send to user after rejection //RR
                    } 
                }else{
                    $result = array('status'=>false, 'message'=>'Something went wrong');
                }
            } 
        }else{
            $result = array('status'=>false, 'message'=>'Booking id is required');
        }
        echo json_encode($result);
    }

    public function allBookedUserDetails(Request $request){

        if(isset($request->agentId)){
            // SELECT DISTINCT agentId FROM tblbookedagent where userId=14 order by id desc;
            $getUserId = DB::table('tblbookedagent')->select('userId')->distinct()->where(array('agentId'=>$request->agentId))->orderBy('id','DESC')->get();
            $data = [];
            foreach($getUserId as $key=>$value){                
                $userDetails = DB::table('users')->select('id', 'fname','lname','image')->where('id', $value->userId)->first();
                if(!empty($userDetails))
                {
                    $data[] = $userDetails;
                }  
            }

            if(!empty($data)){
                $result = array('status'=>true, 'data'=> $data);
            }else{
                $result = array('status'=>false, 'message'=>'No bookings available.');
            }   
        }else{
            $result = array('status'=>false, 'message'=>'User Id is required');
        }
        echo json_encode($result);
    }


    public function deeteInsertAgentServices($user){   //In Use (IMP.) //RR
        if(!empty($user->id)){
            $serviceIds = explode(',',$user->serviceId);
            $serviceAmount = explode(',',$user->serviceAmount);
            AgentProvidedServices::where('agentId', $user->id)->delete();  //try
           
            if(!empty($serviceIds)){
                foreach ($serviceIds as $key => $value) {
                    $agentService = new AgentProvidedServices();
                    $agentService->agentId = $user->id;
                   $agentService->serviceId = $value;
                   $agentService->serviceAmount =$serviceAmount[$key]; 
                   $agentService->save();
                }
            }
        }
    }



    public function sendMail($email, $stubject = NULL, $message = NULL)  //In Use //RR Imp.
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->SMTPSecure = "tls";
            $mail->SMTPAuth = true;
            $mail->Username = "wemarkspot@gmail.com"; //"raviappic@gmail.com";
            $mail->Password = "dwspcijqkcgagrzl"; //"audnjvohywazsdqo";
            $mail->addAddress($email, "User Name");
            $mail->Subject = $stubject;
            $mail->isHTML();
            $mail->Body = $message;
            $mail->setFrom("raviappic@gmail.com");
            $mail->FromName = "We Mark The Spot";

            if ($mail->send()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }


/*
$this->sendNotification($request->device_token, array(
          "title" => "Sample Message", 
          "body" => "This is Test message body"
        ));
*/
	
//ServerKey

 public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = env('ServerKey');
  
        // payload data, it will vary according to requirement
        $data = [
            "to" => $device_token, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
      
        curl_close($ch);
      
        return $response;
    }


}