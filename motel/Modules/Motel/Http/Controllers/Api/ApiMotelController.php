<?php

namespace Modules\Motel\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Motel\Entities\Motel;
use Modules\Motel\Http\Requests\CreateMotelRequest;
use Modules\Motel\Http\Requests\UpdateMotelRequest;
use Modules\Motel\Repositories\MotelRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Motel\Http\Controllers\Api\ApiController;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;


class ApiMotelController extends ApiController
{
    /**
     * @var MotelRepository
     */
    private $motel;

    public function __construct(MotelRepository $motel)
    {
        parent::__construct();

        $this->motel = $motel;
    }
	/**
     * @SWG\Get(
     *   path="/motel/send-mail-again",
     *   description="",
     *   summary="",
     *   operationId="",
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
	public function SendMailAgain(){
		$data = $this->motel->SendMailAgain();
		if($data==true){
			return $this->respond([
	            'status' => 'success',
	            'status_code' => 200,
	            'message' => "We have sent a link to the your email address, please go to the mail box to confirm",
        	]);
		}
	}
	/**
     * @SWG\Get(
     *   path="/motel/update-roles",
     *   description="",
     *   summary="",
     *   operationId="",
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
	public function getUpdateRoles(){
		$data = $this->motel->getUpdateRoles();
		//return $data;
		if($data['code'] == 200){
			return $this->respond([
	            'status' => 'success',
	            'status_code' => 200,
	            'message' => "Upgrade successful!",
	            'data' => $data['data'],
        	]);
		}else{
			return $this->respond([
	            'status' => 'error',
	            'status_code' => 201,
	            'message' => "Your account has not been activated"
        	]);
		}
	}
    /**
     * @SWG\Post(
     *     path="/motel/update-profile",
     *     consumes={"multipart/form-data"},
     *     description="",
     *     operationId="uploadFile",
     *     @SWG\Parameter(
     *         description="file to upload",
     *         in="formData",
     *         name="image",
     *         required=true,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="phone",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="first_name",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="last_name",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="address",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="latitude",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="longitude",
     *         required=true,
     *         type="string"
     *     ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *     ),
     *   security={
     *       {"api_key": {}}
     *   },
     *     summary="uploads an image",
     *     tags={
     *         "Motel"
     *     }
     * )
     * */
    public function postUpdateProfile(Request $request){
        $data['phone'] = $request->phone;
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['address'] = $request->address;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['image'] = $request->File('image');
        $data = $this->motel->postUpdateProfile($data);
       return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Update successful!",
                'data' => $data,
            ]);
    }
    /**
     * @SWG\Get(
     *   path="/motel/get-news",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="limit",
     *     required=false,
     *     type="integer",
     *     default="10"
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="country",
     *     required=false,
     *     type="integer",
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="page",
     *     required=false,
     *     type="integer",
     *     default="1"
     *   ),
     * @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getNews(Request $request){
        $perPage = $request->has('limit') ? $request->get('limit') : 10;
        $currentPage = $request->has('page') ? $request->get('page') : 1;
        $country = $request->country;
        //return $country;
        $data = $this->motel->getNews($country);
        //return $data;

        $total = count($data->get());
        $news = $data->paginate($perPage);
        $paginate = new Paginator($data, $total, $perPage, $currentPage);

        $news = $news->toarray();
        //foreach($news )
        if(count($news) > 0){
             return $this->respondWithPagination($paginate,$news['data'],'Get list news');
        }
        else{
            return $this->respondNotFound('Not Found');
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/get-news-of-current-user",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="limit",
     *     required=false,
     *     type="integer",
     *     default="10"
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="page",
     *     required=false,
     *     type="integer",
     *     default="1"
     *   ),
     * @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getNewsOfCurrenUser(Request $request){
        $perPage = $request->has('limit') ? $request->get('limit') : 10;
        $currentPage = $request->has('page') ? $request->get('page') : 1;
        //return $country;
        $data = $this->motel->getNewsOfCurrenUser();
        //return $data;

        $total = count($data->get());
        $news = $data->paginate($perPage);
        $paginate = new Paginator($data, $total, $perPage, $currentPage);

        $news = $news->toarray();
        //foreach($news )
        if(count($news) > 0){
             return $this->respondWithPagination($paginate,$news['data'],'Get list news');
        }
        else{
            return $this->respondNotFound('Not Found');
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/get-news-liked-of-user",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="limit",
     *     required=false,
     *     type="integer",
     *     default="10"
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="page",
     *     required=false,
     *     type="integer",
     *     default="1"
     *   ),
     * @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getNewsLikedOfUser(Request $request){
        $perPage = $request->has('limit') ? $request->get('limit') : 10;
        $currentPage = $request->has('page') ? $request->get('page') : 1;
        //return $country;
        $data = $this->motel->getNewsLikedOfUser();
        //return $data;

        $total = count($data->get());
        $news = $data->paginate($perPage);
        $paginate = new Paginator($data, $total, $perPage, $currentPage);

        $news = $news->toarray();
        //foreach($news )
        if(count($news) > 0){
             return $this->respondWithPagination($paginate,$news['data'],'Get list news');
        }
        else{
            return $this->respondNotFound('Not Found');
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/delete-news-of-user",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="id",
     *     required=false,
     *     type="integer",
     *   ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function deleteNewsOfUser(Request $request){
        $id = $request->id;
        $data = $this->motel->deleteNewsOfUser($id);
        if($data == true){
           return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Delete successful",
            ]);        
        }else{
            return $this->respondNotFound('Not Found');
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/unlike-news-by-user",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="id",
     *     required=false,
     *     type="integer",
     *   ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function unlikeNewsByUser(Request $request){
        $id = $request->id;
        $data = $this->motel->unlikeNewsByUser($id);
        if($data == true){
           return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Unlike successful",
            ]);        
        }else{
            return $this->respondNotFound('Not Found');
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/like-news",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="id",
     *     required=false,
     *     type="integer",
     *   ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function likeNews(Request $request){
        $id = $request->id;
        $data = $this->motel->likeNews($id);
        if($data == true){
           return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Like successful",
            ]);        
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/get-room-of-user",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="limit",
     *     required=false,
     *     type="integer",
     *     default="10"
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="page",
     *     required=false,
     *     type="integer",
     *     default="1"
     *   ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getRoomOfUser(Request $request){
        $perPage = $request->has('limit') ? $request->get('limit') : 10;
        $currentPage = $request->has('page') ? $request->get('page') : 1;

        $data = $this->motel->getRoomOfUser();

        $total = count($data->get());
        $room = $data->paginate($perPage);
        $paginate = new Paginator($data, $total, $perPage, $currentPage);

        $room = $room->toarray();
        //foreach($news )
        if(count($room) > 0){
             return $this->respondWithPagination($paginate,$room['data'],'Get list room');
        }
        else{
            return $this->respondNotFound('Not Found');
        }


        if($data == true){
           return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Delete successful",
            ]);        
        }
    }
    /**
     * @SWG\Get(
     *   path="/motel/filter-motel",
     *   description="",
     *   summary="",
     *   operationId="",
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="limit",
     *     required=false,
     *     type="integer",
     *     default="3"
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="latitude",
     *     required=false,
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="longitude",
     *     required=false,
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     description="",
     *     in="query",
     *     name="unit_price",
     *     required=false,
     *     type="integer",
     *     default="0",
     *   ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *   produces={"application/json"},
     *   tags={"Motel"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getListFilter(Request $request){
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $limit = $request->limit;
        $unit_price = $request->unit_price;
        $data = $this->motel->getListFilter($latitude,$longitude,$limit,$unit_price);
        //return $data;

        //$news = $news->toarray();
        //foreach($news )
        if(count($data) > 0){
            return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Get list successful!",
                'data' => $data,
            ]);
        }
        else{
            $arr = [];
            return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Get list successful!",
                'data' => $arr,
            ]);
        }
    }
    /**
     * @SWG\Post(
     *     path="/motel/post-news",
     *     consumes={"multipart/form-data"},
     *     description="",
     *     operationId="uploadFile",
     *     @SWG\Parameter(
     *         description="file to upload",
     *         in="formData",
     *         name="sub1",
     *         required=false,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         description="file to upload",
     *         in="formData",
     *         name="sub2",
     *         required=false,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         description="file to upload",
     *         in="formData",
     *         name="sub3",
     *         required=false,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         description="file to upload",
     *         in="formData",
     *         name="sub4",
     *         required=false,
     *         type="file"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="location",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="erea",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="unit_price",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="phone",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="description",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="country",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="latitude",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="",
     *         in="formData",
     *         name="longitude",
     *         required=true,
     *         type="string"
     *     ),
     *   @SWG\Parameter(name="MT-API-KEY",in="header",required=true,type="string",description="Authorise connection",default="dev-api-key"),
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *     ),
     *   security={
     *       {"api_key": {}}
     *   },
     *     summary="uploads an image",
     *     tags={
     *         "Motel"
     *     }
     * )
     * */
    public function postNews(Request $request){
        $data['location'] = $request->location;
        $data['erea'] = $request->erea;
        $data['unit_price'] = $request->unit_price;
        $data['phone'] = $request->phone;
        $data['description'] = $request->description;
        $data['country'] = $request->country;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['sub1'] = $request->File('sub1');
        $data['sub2'] = $request->File('sub2');
        $data['sub3'] = $request->File('sub3');
        $data['sub4'] = $request->File('sub4');
        $result = $this->motel->postNews($data);
        //return $data;
        if($result == true){
            return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Upload successful!",
                // 'data' => $result,
            ]); 
        }
      
    }
}