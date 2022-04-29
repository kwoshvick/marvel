<?php

namespace App\Services;

use App\Models\Character;
use Illuminate\Support\Facades\Http;

class MarvelService
{
    private mixed $gateway;
    private mixed $privateKey;
    private mixed $publicKey;

    public function __construct(){
        $this->gateway = env('MARVEL_API_BASE_URL', 'https://gateway.marvel.com/v1/public/');
        $this->privateKey = env('MARVEL_API_PRIVATE_KEY', '');
        $this->publicKey = env('MARVEL_API_PUBLIC_KEY', '');
    }

    public function fetchCharacters()
    {
        $offset = 0;
        $limit = 100;
        $totalResultsCount = 1;
        while($offset < $totalResultsCount) {
            $url = $this->urlBuilder($limit,$offset);
            $data = $this->getData($url);
            $this->resultsProcessor($data['results']);
            $offset += $limit ;
            $totalResultsCount = $data['total'];
        }
    }

    private function resultsProcessor(array $characters){
        foreach ($characters as $character) {
            if (Character::where('marvel_id', $character['id'])->exists()) {
                continue;
            }
            Character::create([
                'marvel_id' => $character['id'],
                'name' => $character['name'],
                'description' => $character['description'],
                'thumbnail' => $character['thumbnail']['path'] . '.' . $character['thumbnail']['extension'],
                'series' => $character['series']['available'],
                'comics' => $character['comics']['available'],
                'stories' => $character['stories']['available']
            ]);
        }
    }

    public function urlBuilder($limit,$offset): string
    {
        $params = [];
        $timestamp = time();
        $hash = $this->generateAuthenticationHash($timestamp);
        $queryParameter = [
            'ts' => $timestamp,
            'apikey' => $this->publicKey,
            'hash' => $hash,
            'limit' => $limit,
            'offset' =>$offset
        ];
        return $this->gateway.'characters'.'?' . http_build_query(array_merge($queryParameter, $params));
    }

    private function generateAuthenticationHash(string $timestamp): string
    {
        return md5($timestamp . $this->privateKey . $this->publicKey);
    }

    private function getData(string $url)
    {
        $response = Http::retry(10, 500)
            ->timeout(30)
            ->get($url);
        if ($response->clientError()) {
            $error = match ($response->status()){
                401 => 'Invalid hash or referer',
                403 => 'Forbidden',
                405 => 'Method not allowed',
                409 => 'Invalid parameters',
                default => 'An error occurred'
            };
            throw new \Exception($error, $response->status());
        }
        return $response['data'] ?? null;
    }
}
