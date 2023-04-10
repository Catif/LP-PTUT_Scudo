<?php

namespace api\actions\user\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class UserResourcesAction
{
	public function __invoke(Request $rq, Response $rs, array $args): Response
	{
		try {
			$query = $rq->getQueryParams();

			$pagination = $this->validateQuery($query);

			$user = UserService::getUserById($args['id']);
			$resources = UserService::getResourcesByUser($user, $pagination['page'], $pagination['limit']);

			$listResources = [];
			foreach ($resources as $resource) {
				$listResources[] = FormatterObject::formatResource($resource);
			}

			$previousPage = ($pagination['page'] - 1 < 1) ? 1 : $pagination['page'] - 1;

			$data = [
				'url' => [
					'previous' => $rq->getUri()->getPath() . '?page=' . $previousPage . '&limit=' . $pagination['limit'],
					'next' => $rq->getUri()->getPath() . '?page=' . ($pagination['page'] + 1) . '&limit=' . $pagination['limit']
				],
				'count' => count($listResources),

				'result' => [
					'resources' => $listResources
				]
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

		if (!isset($query['page']) && !isset($query['limit'])) {
			return [
				'page' => 1,
				'limit' => 20
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
