<?php

namespace api\actions\user\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class UsersAction
{
	public function __invoke(Request $rq, Response $rs, array $args): Response
	{
		try {
			$query = $rq->getQueryParams();
			if (!isset($query['q'])) {
				throw new \Exception("Missing query parameter");
			}


			$users = UserService::getUsers();
			$listUsers = [];
			foreach ($users as $user) {
				$listUsers[] = FormatterObject::formatUser($user);
			}

			$data = [
				'count' => count($users),
				'users' => $listUsers
			];

			return FormatterAPI::formatResponse($rq, $rs, $data);
		} catch (\Exception $e) {
			$data = [
				'error' => $e->getMessage()
			];
			return FormatterAPI::formatResponse($rq, $rs, $data, 400);
		}
	}
}
