<?php

namespace Modules\Motel\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface MotelRepository extends BaseRepository
{
	public function SendMailAgain();
	public function getUpdateRoles();
	public function postUpdateProfile($data);
	public function getNews($country);
	public function getListFilter($latitude, $longitude, $limit);
}
