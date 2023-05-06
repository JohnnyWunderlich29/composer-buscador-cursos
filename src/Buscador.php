<?php

namespace Alura\BuscadorCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador 
{
    private $httpClient;
    private $crawler;
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $verbo, string $url): array
    {
        $response = $this->httpClient->request($verbo, $url);
        $html = $response->getBody();

        $this->crawler->addHtmlContent($html);
        $elementosCursos = $this->crawler->filter('span.card-curso__nome');

        $cursos = [];
        foreach ($elementosCursos as $elemento){
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }
}