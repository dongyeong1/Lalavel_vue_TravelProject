<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Dongpost;
use App\Models\Heart;
use App\Models\House;
use App\Models\Recomment;
use App\Models\Reserveds;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class postController extends Controller
{
    public function masterCommentLoad(Request $request)
    {
        $commentId = $request->commentId;

        $masterComment = Recomment::where('comment_id', $commentId)->get();

        return $masterComment;
    }
    public function loadPoint(Request $request)
    {
        $userId = $request->userId;
        $originPoint = DB::table('users')->where('id', $userId)->value('point');
        return $originPoint;
    }
    public function addpoint(Request $request)
    {
        $userId = $request->userId;
        $point = $request->point;

        $originPoint = DB::table('users')->where('id', $userId)->value('point');
        $resultPoint = $point + $originPoint;
        DB::table('users')->where('id', $userId)->update(['point' => $resultPoint]);

        return 1;
    }
    public function userreservedUploads(Request $request)
    {
        $userId = $request->userId;

        $userReserved = Reserveds::WHERE('user_id', $userId)->with('houses')->get();

        return $userReserved;
    }
    public function isUser(Request $request)
    {
        $userId = $request->userId;
        $houseId = $request->houseId;

        $count = DB::table('reserveds')->where('user_id', $userId)->where(
            'house_id',
            $houseId
        )->count();

        if ($count) {
            return 1;
        } else {
            return 0;
        }
    }

    public function houseDelete(Request $request)
    {
        $houseId = $request->houseId;

        DB::table('houses')->where('id', $houseId)->delete();
    }

    public function reCommentLoad(Request $request)
    {

        $writeUser = $request->userId;
        $commentId = $request->commentId;
        $houseId = $request->houseId;
        $reco = DB::table('recomments')->where('comment_id', $commentId)->where('writeUser', $writeUser)->where('house_id', $houseId)->get();

        return $reco;
    }

    public function masterComment(Request $request)
    {
        $writeUser = $request->writeUser;
        $masterContent = $request->masterContent;
        $userId = $request->userId;
        $commentId = $request->commentId;
        $houseId = $request->houseId;

        $dt = Carbon::now();

        DB::table('recomments')->insert([
            'comment_id' => $commentId, 'user_id' => $userId, 'reComment' => $masterContent, 'house_id' => $houseId,
            'writeUser' => $writeUser,
            'created_at' => $dt, 'updated_at' => $dt
        ]);
        return 1;
    }

    public function houseUpdate(Request $request)
    {

        $address = $request->address;
        $peopleNumber = $request->peopleNumber;
        $content = $request->content;
        $houseName = $request->houseName;
        $price = $request->price;
        $pet = $request->pet;
        $smoking = $request->smoking;
        $parking = $request->parking;
        $wifi = $request->wifi;
        $productImage = $request->productImage;
        $imagess = $request->imagess;
        $houseNum = $request->houseNum;

        if ($imagess) {
            $name = $productImage->getClientOriginalName();
            $extension = $productImage->extension();
            $extensionout = Str::of($name)->basename('.' . $extension);
            $filename = $extensionout . '_' . time() . '.' . $extension;
            $productImage->storeAs('public/image', $filename);
        } else {
            $filename = $productImage;
        }

        $dt = Carbon::now();

        DB::table('houses')->where('id', $houseNum)->update(['peoplenumber' => $peopleNumber, 'title' => $houseName, 'description' => $content, 'address' => $address, 'pay' => $price,  'smoking' => $smoking, 'pet' => $pet, 'parking' => $parking, 'wifi' => $wifi, 'image' => $filename, 'created_at' => $dt, 'updated_at' => $dt]);
    }

    public function masterReserved(Request $request)
    {
        $userId = $request->userId;

        $searchResult = House::where('user_id', $userId)->with('reserveds')->get();
        return $searchResult;
    }



    public function masterHouseUpload(Request $request)
    {
        $userId = $request->userId;
        $searchResult = House::where('user_id', $userId)->get();
        return $searchResult;
    }

    public function houseSearch(Request $request)
    {
        $houseName = $request->houseName;
        // $searchResult = DB::table('houses')->where('title', 'like', '%' . $houseName . '%')->get();
        $searchResult = House::where('title', 'like', '%' . $houseName . '%')->with('reserveds')->get();

        return response()->json([
            'searchResult' => $searchResult
        ]);
    }
    public function userHeartLoad(Request $request)
    {

        $userId = $request->userId;
        $heartProduct = Heart::where('user_id', $userId)->with('houses')->get();

        return $heartProduct;
    }
    public function loadStarChart()
    {
        $comment = Comment::with('houses')->get();
        // $comment = DB::table('comments')->with('houses')->get();

        return $comment;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function register(Request $request)
    {
        $email = $request->email;
        $name = $request->name;
        $password = $request->password;
        $state = $request->state;
        // $password_confirmation=$request->password_confirmation;

        $this->validate(
            $request,
            [
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required'],

            ]
        );

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->state = $state;
        $user->save();
        return response($user, 202);
    }
    public function commentLoad($houseId)
    {
        // $houseId = $request->houseId;

        $comment = Comment::where('house_id', $houseId)->with('users')->paginate(2);

        return $comment;
    }
    public function comment(Request $request)
    {

        $star = $request->star;
        $comment = $request->comment;
        $houseId = $request->houseId;
        $userId = $request->userId;
        $dt = Carbon::now();

        DB::table('comments')->insert([
            'comment' => $comment, 'user_id' => $userId, 'star' => $star, 'house_id' => $houseId,

            'created_at' => $dt, 'updated_at' => $dt
        ]);

        return 1;
    }
    public function loadUserReserve(Request $request)
    {
        $userId = $request->userId;
        $userReserved = Reserveds::WHERE('user_id', $userId)->with('houses')->get();

        return  $userReserved;
    }

    public function loadHeart(Request $request)
    {

        $userId = $request->userId;
        $houseId = $request->houseNum;
        $heart = DB::table('hearts')->where('user_id', $userId)->where('house_id', $houseId)->count();
        return $heart;
    }

    public function unClickHeart(Request $request)
    {
        $houseNum = $request->houseNum;
        $userId = $request->userId;
        DB::table('hearts')->where('user_id', $userId)->where('house_id', $houseNum)->delete();
    }

    public function clickHeart(Request $request)
    {
        $houseNum = $request->houseNum;
        $userId = $request->userId;
        DB::table('hearts')->insert(['user_id' => $userId, 'house_id' => $houseNum, 'heart' => 1]);
    }
    public function addReserve(Request $request)
    {
        $startDay = $request->startDay;
        $endDay = $request->endDay;
        $title = $request->title;

        DB::table('reserveds')->insert(['title' => $title, 'start_day' => $startDay, 'end_day' => $endDay]);
    }
    public function chartloadHouse()
    {
        $house = DB::table('houses')->get();
        return $house;
    }
    public function loadreserve(Request $request)
    {
        $postNum = $request->postNum;
        $res = Reserveds::where('house_id', $postNum)->get();

        return $res;
    }
    public function reserve(Request $request)
    {
        $startDay = $request->startDay;
        $endDay = $request->endDay;
        $title = $request->title;
        $id = $request->id;
        $userId = $request->userId;

        DB::table('reserveds')->insert(['start_day' => $startDay, 'end_day' => $endDay, 'title' => $title, 'house_id' => $id, 'user_id' => $userId]);
    }

    public function loadHouse()
    {



        $house = House::with('comments')->get();
        // $house = House::with('hearts')->get();
        return $house;
    }
    //
    public function addHouse(Request $request)
    {
        $address = $request->address;
        $peopleNumber = $request->peopleNumber;
        $content = $request->content;
        $houseName = $request->houseName;
        $price = $request->price;
        $pet = $request->pet;
        $smoking = $request->smoking;
        $parking = $request->parking;
        $wifi = $request->wifi;
        $productImage = $request->productImage;
        $userId = $request->userId;
        $colorCode = $request->colorCode;

        $name = $productImage->getClientOriginalName();
        $extension = $productImage->extension();
        $extensionout = Str::of($name)->basename('.' . $extension);
        $filename = $extensionout . '_' . time() . '.' . $extension;
        $productImage->storeAs('public/image', $filename);
        $dt = Carbon::now();

        DB::table('houses')->insert(['user_id' => $userId, 'color' => $colorCode, 'peoplenumber' => $peopleNumber, 'title' => $houseName, 'description' => $content, 'address' => $address, 'pay' => $price,  'smoking' => $smoking, 'pet' => $pet, 'parking' => $parking, 'wifi' => $wifi, 'image' => $filename, 'created_at' => $dt, 'updated_at' => $dt]);

        $house = DB::table('houses')->get();

        return $house;
    }

    public function update(Request $request)
    {
        $contentId = $request->contentId;
        $updatedContent = $request->updatedContent;
        $updatedTitle = $request->updatedTitle;
        $deleteImage = $request->deleteImage;

        $imageFile = $request->imageFile;

        if ($imageFile) {
            Storage::delete($deleteImage);
            $name = $imageFile->getClientOriginalName();
            $extension = $imageFile->extension();
            $extensionout = Str::of($name)->basename('.' . $extension);
            $filename = $extensionout . '_' . time() . '.' . $extension;
            $imageFile->storeAs('public/image', $filename);
        } else {
            $filename = null;
        }

        DB::table('dongposts')->where('id', $contentId)->update(['title' => $updatedContent, 'content' => $updatedTitle, 'image' => $filename]);
    }
    public function create(Request $request)
    {
        $content = $request->content;
        $title = $request->title;
        $imageFile = $request->imageFile;

        if ($imageFile) {
            $name = $imageFile->getClientOriginalName();
            $extension = $imageFile->extension();
            $extensionout = Str::of($name)->basename('.' . $extension);
            $filename = $extensionout . '_' . time() . '.' . $extension;
            $imageFile->storeAs('public/image', $filename);
        } else {
            $filename = null;
        }

        DB::table('dongposts')->insert(['user_id' => 1, 'title' => $title, 'content' => $content, 'image' => $filename]);
    }

    public function delete(Request $request)
    {
        $contentId = $request->contentId;

        DB::table('dongposts')->where('id', $contentId)->delete();
    }

    public function trance(Request $request)
    {
        $lang = $request->lang;
        $tr = new GoogleTranslate('ja');
        return $tr->translate($lang);
    }

    public function index()
    {
        $post = Dongpost::where('user_id', 1)->with('user')->latest()->get();
        // return Dongpost::all()->with('user');

        return $post;
    }

    public function naverSearch(Request $request)
    {



        $keword = $request->keword;
        // echo "<script>console.log( 'PHP_Console: " . $keword . '안녕' . "' );</script>";

        $client_id = "5Gakk1RlhGu4lduKfdUx";
        $client_secret = "BLGoVOeOJR";
        $encText = urlencode($keword);
        $url = "https://openapi.naver.com/v1/search/movie.json?query=" . $encText; // json 결과
        //  $url = "https://openapi.naver.com/v1/search/blog.xml?query=".$encText; // xml 결과
        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = "X-Naver-Client-Id: " . $client_id;
        $headers[] = "X-Naver-Client-Secret: " . $client_secret;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "status_code:" . $status_code . "
      ";
        curl_close($ch);
        if ($status_code == 200) {
            return $response;
        } else {
            echo "Error 내용:" . $response;
        }
    }

    public function weather()
    {
    }
}
