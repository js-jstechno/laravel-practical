<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Mail\Useremail;
use App\Helpers\UploadHelper;
use App\Repositories\AuthRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Session;
use Hash;

class AuthController extends Controller
{
    public $AuthRepository;
    public $responseRepository;

    public function __construct(AuthRepository $AuthRepository, ResponseRepository $rp)
    {
        $this->AuthRepository = $AuthRepository;
        $this->responseRepository = $rp;
    }


    public function indexAll(Request $request)
    {
        try {
            $data = $this->AuthRepository->getData($request->pagenum, $request->pagesize);
            foreach($data as $a=>$b){
                $phone = $b->phone;
                $description = "Welcome";
                smss($phone, $description);
            }
            return $this->responseRepository->ResponseSuccess($data, 'Users Data Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(Request $request)
    {
        try {
            $unit = $this->AuthRepository->register($request);
            return $this->responseRepository->ResponseSuccess($unit, 'New Auth Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseRepository->ResponseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function userupdate(Request $request, $id)
    {
        try {
            $unit = $this->AuthRepository->userupdate($request, $id);
            return $this->responseRepository->ResponseSuccess($unit, 'User Updated Successfully !');
        } catch (\Exception $exception) {
            return $this->responseRepository->ResponseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function userdelete(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $user = User::find($id);
            if ($user) {
                $email = $user->email;
                $phone = $user->phone;
                $name = $user->name;
                $title = "Delete User";
                $description = "Now we remove your account for some reason";
                Mail::to($email)->send(new Useremail($title, $description, $name));
                smss($phone, $description);
                $user->delete();
            }
        }
        return response()->json(['success' => "User Delete Successfully !"]);
    }

}
