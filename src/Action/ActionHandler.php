<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

abstract class ActionHandler {

  protected $twig;

  protected $template = "error/error.twig";

  private $payload = [];

  private $messages = [];

  public function __construct(Twig $twig) {
    $this->twig = $twig;
  }

  public function __invoke(Request $request, Response $response, array $args = []): ResponseInterface {
    $this->request = $request;
    $this->response = $response;
    $this->args = $args;

    try {
      return $this->action();
    } catch (Exception $e) {
      throw new HttpNotFoundException($this->request, $e->getMessage());
    }
  }

  abstract protected function action(): Response;

  protected function respond(array $payload = []): Response {
    $this->payload = $payload;
    $this->payload['messages'] = $this->messages;
    return $this->twig->render($this->response, $this->template, $this->payload);
  }

  final public function ErrorMessage (string $text, bool $priority = false) {
    $message = new \stdclass;
    $message->text = $text;
    $message->type = 'danger';
    if($priority) unset($this->messages);
    $this->messages[] = $message;
  }

  final public function Message (string $text, bool $priority = false) {
    $message = new \stdclass;
    $message->text = $text;
    $message->type = 'info';
    if($priority) unset($this->messages);
    $this->messages[] = $message;
  }

 final public function SuccessMessage (string $text, bool $priority = false) {
    $message = new \stdclass;
    $message->text = $text;
    $message->type = 'success';
    if($priority) unset($this->messages);
    $this->messages[] = $message;
  }

}