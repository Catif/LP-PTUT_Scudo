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

			$pagination = $this->validateQuery($query);
			$search = $query['q'];


			$users = UserService::getUsers($search, $pagination);
			$listUsers = [];
			foreach ($users as $user) {
				$listUsers[] = FormatterObject::formatUser($user);
			}

			$previousPage = ($pagination['page'] - 1 < 1) ? 1 : $pagination['page'] - 1;

			$data = [
				'url' => [
					'prev' => '/api/users/?q=' . $search . '&page=' . $previousPage . '&limit=' . $pagination['limit'],
					'actual' => '/api/users/?q=' . $search . '&page=' . $pagination['page'] . '&limit=' . $pagination['limit'],
					'next' => '/api/users/?q=' . $search . '&page=' . ($pagination['page'] + 1) . '&limit=' . $pagination['limit'],
				],
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

	private function validateQuery($query)
	{
		if (!isset($query['q']) && !empty($query['q'])) {
			throw new \Exception("Aucune information reçu pour la recherche.");
		}
		if (strlen($query['q']) < 2) {
			throw new \Exception("La recherche doit contenir au moins 2 caractères.");
		}

		if (!isset($query['page']) && !isset($query['limit'])) {
			return [
				'page' => 1,
				'limit' => 10
			];
		}

		if ((int)$query['page'] < 1) {
			throw new \Exception("La page doit être supérieur à 0.");
		}

		if ((int)$query['limit'] < 1 || (int)$query['limit'] > 50) {
			throw new \Exception("Le nombre de résultat par page doit être compris entre 1 et 50.");
		}

		try {
			return [
				'page' => $query['page'],
				'limit' => $query['limit'],
			];
		} catch (\Exception $e) {
			throw new \Exception("Les paramètres de pagination sont incorrects.");
		}
	}
}
