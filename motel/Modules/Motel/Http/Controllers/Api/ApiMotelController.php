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
	            'status' => 'success',
	            'status_code' => 201,
	            'message' => "Your account has not been activated"
        	]);
		}
	}
}