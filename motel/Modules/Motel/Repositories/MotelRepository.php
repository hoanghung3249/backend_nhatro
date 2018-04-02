<?php

namespace Modules\Motel\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface MotelRepository extends BaseRepository
{
	public function SendMailAgain();
	public function getUpdateRoles();
	public function postUpdateProfile($data);
	public function getNews($country);
	public function getNewsOfCurrenUser();
	public function deleteNewsOfUser($id);
	public function getRoomOfUser();
	public function likeNews($id);
	public function getNewsLikedOfUser();
	public function unlikeNewsByUser($id);
	public function getListFilter($latitude, $longitude, $limit, $unit_price = 0);
	public function postNews($data);
	public function getmyprofile();
}
