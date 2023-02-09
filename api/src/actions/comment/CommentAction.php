<?php

namespace api\actions\comment;


use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\CommentService as CommentService;
use api\services\utils\FormatterAPI;

final class CommentAction {

    
    public function __invoke(Request $rq, Response $rs, array $args) : Response
    {
        $commentService = new CommentService; 
        $comments = $commentService->getComment();
        $data = ['type' => 'Table',
        'count'=> count($comments),
        'Comment'=> $comments];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
} 